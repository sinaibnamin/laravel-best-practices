@php
    $member_d_none_class = '';
    if (get_user_role() == 'member') {
        $member_d_none_class = 'd-none';
    }
    if (isset($fail_page) && $fail_page) {
        $member_d_none_class = 'd-none';
    }
@endphp
<table class="table table-hover text-nowrap">
    <thead>
        <tr>

            <th>Member</th>
            <th>Uniq ID</th>
            <th>Package</th>
            <th class="text-right">Price</th>
            <th class="text-right">Paid</th>
            <th class="text-right">Discount</th>
            <th class="text-right">Due</th>
            <th>Pay by</th>
            <th>Pay Date</th>
            <th>Validity</th>
            <th>Comments</th>
            <th>status</th>
            <th class="{{ $member_d_none_class }}">Action</th>
        </tr>
    </thead>
    <tbody>

        @foreach ($payments as $payment)
            <tr class="{{ $payment->due > 0 || (isset($fail_page) && $fail_page) ? 'due-row-bg' : '' }}">

                <td style="text-wrap: wrap;min-width:200px;" id="member_{{ $payment->id }}">

                    @php
                        $member_img_url = asset('/') . 'site_images/statics/user_dummy.jpg';
                        if (isset($payment->member->image) && $payment->member->image) {
                            $member_img_url =
                                asset('/') . 'site_images/uploaded/member_images/' . $payment->member->image;
                        }
                        $member_profile_url = '#';
                        if (isset($payment->member->id) && get_user_role() == 'admin') {
                            $member_profile_url = url('/admin_panel/member/show/' . $payment->member->id);
                        }
                    @endphp

                 
                    <a href="{{ $member_profile_url }}" class="table-user-row-info">
                        <div class="img-wrapper">
                            <img src="{{ $member_img_url }}"
                                alt="Product 1" class="table-round-image">
                        </div>
                        <div class="right-part">
                            <div class="name">
                                {{$payment->member->full_name ?? 'not found'}}
                            </div>
                            <div class="id">
                                <small>Uique ID: {{$payment->member->uniq_id ?? 'not found'}}</small>
                            </div>
                      
                        </div>
                    </a>

                </td>
                <td id="uniq_id_{{ $payment->id }}">
                    {{ $payment->member->uniq_id ?? 'not found' }}
                </td>
                <td id="package_{{ $payment->id }}">
                    {{ $payment->package->name ?? 'not found' }}
                </td>
                <td class="text-right" id="price_{{ $payment->id }}">
                    @if ($payment->package_price == 0)
                        N/A
                    @else
                        <span>{{ $payment->package_price }}</span>
                    @endif
                </td>
                <td class="text-right" id="paid_{{ $payment->id }}">
                    {{ $payment->paid }}
                </td>
                <td class="text-right" id="discount_{{ $payment->id }}">
                    {{ $payment->discount }}
                </td>
                <td id="due_{{ $payment->id }}"
                    class="text-right {{ $payment->due > 0 ? 'text-bold text-danger' : '' }}">
                    {{ $payment->due }}
                </td>
                <td>
                    {{ $payment->pay_by }}
                </td>
                <td id="pay_date_{{ $payment->id }}">
                    {{ \Carbon\Carbon::parse($payment->date)->format('M d, Y') }}
                </td>
                <td id="validity_{{ $payment->id }}">
                    @if ($payment->validity)
                        {{ \Carbon\Carbon::parse($payment->validity)->format('M d, Y') }}
                    @else
                        N/A
                    @endif
                </td>
                <td style="text-wrap: wrap; min-width: 200px; max-width: 250px;">
                    @if (strlen($payment->comments ?? '') > 42)
                        <span class="short-text">
                            {{ Str::limit($payment->comments, 42) }}
                        </span>
                        <span class="full-text" style="display: none;">
                            {{ $payment->comments }}
                        </span>
                        <a href="#" class="read-more" onclick="toggleText(this); return false;">Read More</a>
                    @else
                        {{ $payment->comments ?? 'N/A' }}
                    @endif
                </td>
                <td>
                    {{ $payment->status ?? 'N/A' }}
                </td>

                <td class="d-none" id="payment_delete_url_{{ $payment->id }}">
                    {{ url('/admin_panel/payment/delete/' . $payment->id) }}</td>


                <td class="{{ $member_d_none_class }}">


                    @if (get_user_role() == 'admin')
                        <a class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Edit"
                            href="{{ url('/admin_panel/payment/edit/' . $payment->id) }}">
                            <i class="fas fa-pencil-alt">
                            </i>
                        </a>
                        <a class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top"
                            title="Permanent delete" href="javascript:void(0)"
                            onclick="deletefunction('{{ $payment->id }}')">
                            <i class="fa-sharp fa-regular fa-trash"></i>
                        </a>
                        @else 
                        N/A
                    @endif


                </td>
            </tr>
        @endforeach
        @if (count($payments) == 0)
            <tr>
                @if (request()->query() === [] && get_user_role() != 'member')
                    <td colspan='5' class="text-primary text-bold">Please apply some filter
                        to see data</td>
                @else
                    <td colspan='5' class="text-danger text-bold">sorry no data here</td>
                @endif
            </tr>
        @endif
    </tbody>
</table>
<style>
    .due-row-bg {
        background: rgb(255 242 242);
    }

    td {
        position: relative;
    }

    .read-more {
        color: blue;
        cursor: pointer;
        text-decoration: underline;
        font-size: 0.9em;
    }
</style>

<script>
    function toggleText(link) {
        const parent = link.closest('td');
        const shortText = parent.querySelector('.short-text');
        const fullText = parent.querySelector('.full-text');

        if (shortText.style.display === 'none') {
            shortText.style.display = '';
            fullText.style.display = 'none';
            link.textContent = 'Read More';
        } else {
            shortText.style.display = 'none';
            fullText.style.display = '';
            link.textContent = 'Read Less';
        }
    }
</script>

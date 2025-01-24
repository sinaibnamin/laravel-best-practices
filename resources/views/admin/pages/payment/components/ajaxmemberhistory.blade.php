
<div class="member-history">
    @if ($member->status)
        <div class="col-12 col-md-6 col-lg-4 col-xl-3">His membership satus is <b>{{ $member->status }}</b> </div>
    @endif
    @if (!$overview->last_payment)
        <div class="col-12 col-md-6 col-lg-4 col-xl-3">He is a new member, he has no payment history</div>
    @endif
    @if ($overview->last_payment)
        <div class="col-12 col-md-6 col-lg-4 col-xl-3">His last payment was on  {{ \Carbon\Carbon::parse($overview->last_payment->date)->format('d F Y') }}</div>
    @endif
    @if ($overview->last_due_payment)
        <div class="col-12 col-md-6 col-lg-4 col-xl-3 text-danger text-bold">This member has some Due</div>
    @endif
    @if ($overview->last_package)
        <div class="col-12 col-md-6 col-lg-4 col-xl-3">He paid <b>{{ $overview->last_package->package->name }}</b> package in last package pay</div>
    @endif

    @if (get_user_role() == 'admin' && $overview->last_payment)
        <div class="col-12 col-md-6 col-lg-4 col-xl-3">Check his <a target="_blank" href="{{ url('/') }}/admin_panel/payment/list?member_id={{ $member->id }}">
                <b>payment
                    history</b> </a> </div>
    @endif

    @if ($member->validity)
        @php
            $validityDate = \Carbon\Carbon::parse($member->validity);
            $today = \Carbon\Carbon::today();
        @endphp
        @if ($validityDate->isBefore($today))
            <div class="col-12 col-md-6 col-lg-4 col-xl-3">His validity was expired on <b class="text-danger">{{ $validityDate->format('d F Y') }}</b></div>
        @elseif ($validityDate->isSameDay($today))
            <div class="col-12 col-md-6 col-lg-4 col-xl-3">His validity expires today on <b>{{ $validityDate->format('d F Y') }}</b></div>
        @else
            <div class="col-12 col-md-6 col-lg-4 col-xl-3">His validity will expire on <b>{{ $validityDate->format('d F Y') }}</b></div>
        @endif
    @endif




</div>

<style>
    .member-history {
        background: #edf6ff;
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        border: 1px solid #62aeff;
        border-radius: 3px;
        padding: 10px;
    }
</style>
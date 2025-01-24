<form action="{{ route('member_panel.bkash.pay') }}" method="post" class="">
    @csrf

    <div class="card-body row">

        <div class="form-group col-12">
            @include('admin/pages/payment/components/ajaxmemberhistory')
        </div>

        <div class="form-group col-12">
            <label>Member name</label>
            <select disabled required name="member_id" class="form-control select2 text-bold"
                style="width: 100%;">

                @php
                    $disbled_text = $member->status == 'Active' ? '' : '(Not active)';
                    $disbled_text =
                        $member->status == 'Pending' ? '(Pending member)' : $disbled_text;
                    $member_vilidity_text = '';
                    if ($member->validity) {
                        $member_vilidity_text = '(Validy: ' . $member->validity . ')';
                    }
                @endphp
                <option selected value="{{ $member->id }}"
                    data-validity="{{ $member->validity }}">
                    {{ $member->full_name }} (uniq id:
                    {{ $member->uniq_id }}) {{ $member_vilidity_text }} {{ $disbled_text }}
                </option>

            </select>
        </div>


        <div class="form-group col-12">


            <label>Select package</label>

            <select id="packageselection" required onchange="handlePackageChange(this)"
                name='package_id' class="form-control select2" style="width: 100%;">
                <option value="">Select package</option>
                @foreach ($packages as $package)
                    @php
                        $package_discount = $package->discount;
                        $package_duration = $package->duration;
                        $package_price = $package->price;

                        $duration = '';

                        if ($package_duration == 0) {
                            $duration = 'one-time pay, no validity';
                        } else {
                            $years = floor($package_duration / 360);
                            $remainingDaysAfterYears = $package_duration % 360;
                            $months = floor($remainingDaysAfterYears / 30);
                            $remainingDays = $remainingDaysAfterYears % 30;

                            if ($years > 0) {
                                $duration .= $years . ' year' . ($years > 1 ? 's' : '');
                            }
                            if ($months > 0) {
                                $duration .=
                                    ($duration ? ' ' : '') .
                                    $months .
                                    ' month' .
                                    ($months > 1 ? 's' : '');
                            }
                            if ($remainingDays > 0) {
                                $duration .=
                                    ($duration ? ' and ' : '') .
                                    $remainingDays .
                                    ' day' .
                                    ($remainingDays > 1 ? 's' : '');
                            }
                        }

                        if ($package_duration < 30 && $package_duration != 0) {
                            $duration =
                                $package_duration . ' day' . ($package_duration > 1 ? 's' : '');
                        }

                        $price = '';
                        if ($package_price > 0) {
                            $price = '/ Price: ' . $package_price;
                        }
                        $discount = '';
                        if ($package_discount > 0) {
                            $discount = '/ Discount: ' . $package_discount;
                        }
                    @endphp


                    <option value="{{ $package->id }}" data-discount="{{ $package_discount }}"
                        data-duration="{{ $package_duration }}" data-price="{{ $package_price }}">
                        {{ $package->name }} ( duration:
                        {{ $duration }} {{ $price }} {{ $discount }} )</option>
                @endforeach
            </select>

        </div>


        <div class="form-group col-12 col-md-6 col-lg-4 col-xl-3">
            <label>Package price</label>
            <input required disabled
                value="{{ old('package_price', $payment->package_price ?? 0) }}"
                name="package_price" type="number" class="form-control payment-amount-digits"
                placeholder="">
        </div>
        <div class="form-group col-12 col-md-6 col-lg-4 col-xl-3">
            <label>Discount</label>
            <input disabled required value="{{ old('discount', $payment->discount ?? 0) }}"
                name="discount" type="number" class="form-control payment-amount-digits"
                placeholder="">
        </div>
        <div class="form-group col-12 col-md-6 col-lg-4 col-xl-3">
            <label class="text-primary">Paid amount</label>
            <input required value="{{ old('paid', $payment->paid ?? 0) }}" name="paid"
                type="number" class="form-control payment-amount-digits text-primary"
                placeholder="">
        </div>

        <div class="form-group col-12 col-md-6 col-lg-4 col-xl-3">

            <label class="due-label">Due</label>
            <input disabled required value="{{ old('due', $payment->due ?? 0) }}" name="due"
                type="number" class="form-control payment-amount-digits" placeholder="">
        </div>

        <div class="form-group  col-12 col-md-4">

            <label>Pay by</label>
            <select disabled required name='pay_by' class="form-control">
                <option value="Cash">Cash</option>
                <option selected value="Online">Online</option>
            </select>
        </div>

        <div class="form-group col-12 col-md-4">
            <label>Pay Date </label>
            <input disabled required
                value="{{ old('date', $payment->date ?? now()->toDateString()) }}" name="date"
                type="date" class="form-control" placeholder="">
        </div>

        <div class="form-group col-12 col-md-4">
            <label>Validity </label>
            <input disabled value="{{ old('validity', $payment->validity ?? '') }}" name="validity"
                type="date" class="form-control" placeholder="">
        </div>

    </div>


    <div class="card-footer">
        <button type="submit" class="btn btn-primary">
            Pay with BKash
        </button>
    </div>


</form>
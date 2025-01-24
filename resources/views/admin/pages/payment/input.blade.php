@extends('admin.master')
@section('content')
    @include('admin/partials/helpers/session_alert')

    @php
        $edit_mode = false;
        $current_user_mode = 'admin';
        $action_url = route('admin_panel.payment.store');

        if (isset($page_type) && $page_type == 'edit') {
            $edit_mode = true;
            $action_url = route('admin_panel.payment.update', ['id' => $payment->id]);
        }

    @endphp

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        {{ $edit_mode ? 'Edit' : 'Create' }}
                        payment</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Payment</a></li>
                        <li class="breadcrumb-item active">{{ $edit_mode ? 'Edit' : 'Create' }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">

                        <form action="{{ $action_url }}" method="post" enctype="multipart/form-data" autocomplete="off">

                            @csrf
                            <div class="card-body row">


                                <div class="form-group col-12">
                                    <label>Select member</label>
                                    <select {{ $edit_mode ? 'disabled' : '' }} required name="member_id"
                                        class="form-control select2" style="width: 100%;"
                                        onchange="handleMemberChange(this)">
                                        <option value="">Select member</option>
                                        @foreach ($members as $member)
                                            @php
                                                $member_selected =
                                                    old('member_id', $payment->member_id ?? '') == $member->id
                                                        ? 'selected'
                                                        : '';
                                                $disbled_class = $member->status == 'Pending' ? 'disabled' : '';
                                                $disbled_text = $member->status == 'Active' ? '' : '(Not active)';
                                                $disbled_text =
                                                    $member->status == 'Pending' ? '(Pending member)' : $disbled_text;
                                                $member_vilidity_text = '';
                                                if ($member->validity) {
                                                    $member_vilidity_text = '(Validy: ' . $member->validity . ')';
                                                }
                                            @endphp

                                            <option value="{{ $member->id }}" {{ $member_selected }} {{ $disbled_class }}
                                                data-validity="{{ $member->validity }}">
                                                {{ $member->full_name }} (uniq id:
                                                {{ $member->uniq_id }}) {{ $member_vilidity_text }} {{ $disbled_text }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>



                                <div class="form-group col-12">
                                    <div class="member-history-wrapper">

                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <label>Select package</label>

                                    <select {{ $edit_mode ? 'disabled' : '' }} required
                                        onchange="handlePackageChange(this)" name='package_id' class="form-control select2"
                                        style="width: 100%;">
                                        <option value="">Select package</option>
                                        @foreach ($packages as $package)
                                            @php
                                                $package_discount = $package->discount;
                                                $package_duration = $package->duration;
                                                $package_price = $package->price;

                                                if ($edit_mode && $payment->package_id == $package->id) {
                                                    $package_discount = $payment->package_discount;
                                                    $package_duration = $payment->package_duration;
                                                    $package_price = $payment->package_price;
                                                }

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

                                                $package_selected =
                                                    old('package_id', $payment->package_id ?? '') == $package->id
                                                        ? 'selected'
                                                        : '';
                                            @endphp


                                            <option {{ $package_selected }} value="{{ $package->id }}"
                                                data-discount="{{ $package_discount }}"
                                                data-duration="{{ $package_duration }}" data-price="{{ $package_price }}">
                                                {{ $package->name }} ( duration:
                                                {{ $duration }} {{ $price }} {{ $discount }} )</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-12 col-md-6 col-lg-4 col-xl-3">
                                    <label>Package price</label>
                                    <input required readonly
                                        value="{{ old('package_price', $payment->package_price ?? 0) }}"
                                        name="package_price" type="number" class="form-control payment-amount-digits"
                                        placeholder="">
                                </div>
                                <div class="form-group col-12 col-md-6 col-lg-4 col-xl-3">
                                    <label>Discount</label>
                                    <input required value="{{ old('discount', $payment->discount ?? 0) }}" name="discount"
                                        type="number" class="form-control payment-amount-digits" placeholder="">
                                </div>
                                <div class="form-group col-12 col-md-6 col-lg-4 col-xl-3">
                                    <label class="text-primary">Paid amount</label>
                                    <input required value="{{ old('paid', $payment->paid ?? 0) }}" name="paid"
                                        type="number" class="form-control payment-amount-digits text-primary"
                                        placeholder="">
                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4 col-xl-3">
                                    @php
                                        $dueRedClass = '';
                                        if ($edit_mode && $payment->due > 0) {
                                            $dueRedClass = 'text-danger';
                                        }
                                    @endphp
                                    <label class="due-label {{ $dueRedClass }}">Due</label>
                                    <input required readonly value="{{ old('due', $payment->due ?? 0) }}" name="due"
                                        type="number" class="form-control payment-amount-digits {{ $dueRedClass }}"
                                        placeholder="">
                                </div>

                                <div class="form-group  col-12 col-md-4">

                                    <label>Pay by</label>
                                    <select required name='pay_by' class="form-control">
                                        <option {{ old('pay_by', $payment->pay_by ?? 'Cash') == 'Cash' ? 'selected' : '' }}
                                            value="Cash">Cash</option>
                                        <option
                                            {{ old('pay_by', $payment->pay_by ?? 'Cash') == 'Online' ? 'selected' : '' }}
                                            value="Online">Online</option>
                                    </select>
                                </div>

                                <div class="form-group col-12 col-md-4">
                                    <label>Pay Date </label>
                                    <input required value="{{ old('date', $payment->date ?? now()->toDateString()) }}"
                                        name="date" type="date" class="form-control" placeholder="">
                                </div>

                                <div class="form-group col-12 col-md-4">
                                    @php
                                        $validity_disbled = '';
                                        if ($edit_mode && !$payment->validity) {
                                            $validity_disbled = 'readonly';
                                        }
                                    @endphp
                                    <label>Validity </label>
                                    <input {{ $validity_disbled }} value="{{ old('validity', $payment->validity ?? '') }}"
                                        name="validity" type="date" class="form-control" placeholder="">
                                </div>


                                <div class="form-group col-12">
                                    <label>Comments</label>
                                    <input value="{{ old('comments', $payment->comments ?? '') }}" name="comments"
                                        type="text" class="form-control" placeholder="Example: fully paid">
                                </div>


                            </div>


                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection



@section('pagecss')
    <!-- Select2 -->
    <link rel="stylesheet" href="/admin_assets/plugins/select2/css/select2.min.css">
    <style>
        .payment-amount-digits {
            font-size: 25px !important;
            font-weight: bold !important;

        }
    </style>
@endsection


@section('pagejs')

    <script>
        const edit_mode = '{{ $edit_mode }}'

        if (edit_mode) {
            menu_parent_active('payment')
        } else {
            menu_make_active('payment-create')
        }
    </script>

    <!-- Select2 -->
    <script src="/admin_assets/plugins/select2/js/select2.full.min.js"></script>

    <script>
        //Initialize Select2 Elements
        $('.select2').select2()
    </script>

    @include('admin/pages/payment/components/paymentjs')
@endsection

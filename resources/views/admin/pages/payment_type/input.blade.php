@extends('admin.master')
@section('content')
    @include('admin/partials/helpers/session_alert')

    @php
        $edit_mode = false;
        $current_user_mode = 'admin';
        $action_url = route('admin_panel.payment_type.store');
        if (isset($page_type) && $page_type == 'edit') {
            $edit_mode = true;
            $action_url = route('admin_panel.payment_type.update', ['id' => $payment_type->id]);
        }
     
    @endphp

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        {{ $edit_mode ? 'Edit' : 'Create' }}
                        Payment Type</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Payment Type</a></li>
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

                                <div class="form-group col-12 col-md-6">
                                    <label>Title</label>
                                    <input value="{{ old('title', $payment_type->title ?? '') }}" name="title"
                                        type="text" class="form-control" placeholder="Example: Monthly fee of july 2024">
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label>Amount</label>
                                    <input value="{{ old('amount', $payment_type->amount ?? '') }}" name="amount"
                                        type="number" class="form-control payment-amount-digits" placeholder=""   onkeydown="return event.key !== 'e'" step="1" 
                                        min="0">
                                </div>
                               
                                <div class="form-group  col-12">
                                    <label>Description</label>
                                    <input value="{{ old('description', $payment_type->description ?? '') }}" name="description"
                                        type="text" class="form-control" placeholder="Example: Fee for admission at first time">
                                </div>
                                <div class="form-group  col-12 col-md-6">
                                    <label>Due Date</label>
                                    <input value="{{ old('due_date', $payment_type->due_date ?? '') }}" name="due_date"
                                        type="date" class="form-control" >
                                </div>
                                <div class="form-group  col-12 col-md-6">
                                    <label>Status</label>
                                    <select name='status' class="form-control" required>
                                        <option value="">Select status</option>
                                        <option {{ old('status', $payment_type->status ?? 'Active') == 'Active' ? 'selected' : '' }} value="Active">Active</option>
                                        <option {{ old('status', $payment_type->status ?? 'Active') == 'Inactive' ? 'selected' : '' }} value="Inactive">Inactive</option>
                                    </select>
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
        .payment-amount-digits{
            font-size: 25px !important;
            font-weight: bold !important;

        }
    </style>
@endsection


@section('pagejs')
    <script>
     
     menu_make_active('payment_type-create')

    </script>


    <!-- Select2 -->
    <script src="/admin_assets/plugins/select2/js/select2.full.min.js"></script>

    <script>
        //Initialize Select2 Elements
        $('.select2').select2()
    </script>


@endsection

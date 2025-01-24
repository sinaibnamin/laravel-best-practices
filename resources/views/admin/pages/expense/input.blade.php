@extends('admin.master')
@section('content')
    @include('admin/partials/helpers/session_alert')

    @php
        $edit_mode = false;
        $current_user_mode = 'admin';
        $action_url = route('admin_panel.expense.store');

        if (isset($page_type) && $page_type == 'edit') {
            $edit_mode = true;
            $action_url = route('admin_panel.expense.update', ['id' => $expense->id]);
        }

    @endphp

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        {{ $edit_mode ? 'Edit' : 'Create' }}
                        expense</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Expense</a></li>
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
                                    <div class="member-history-wrapper">

                                    </div>
                                </div>

                                <div class="form-group col-12 col-md-6">
                                    <label>Select expense type</label>
                                    <select  required name='expense_type_id'
                                        class="form-control select2" style="width: 100%;">
                                        <option value="">Select expense type</option>
                                        @foreach ($expense_types as $expense_type)
                                            @php
                                                $selected =
                                                    old('expense_type_id', $expense->expense_type_id ?? '') == $expense_type->id
                                                        ? 'selected'
                                                        : '';
                                            @endphp




                                            <option {{$selected}} value="{{ $expense_type->id }}">
                                                {{ $expense_type->title }} </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4 col-xl-3">
                                    <label class="text-primary">Expense amount</label>
                                    <input required value="{{ old('amount', $expense->amount ?? 0) }}" name="amount"
                                        type="number" class="form-control expense-amount-digits text-primary"
                                        placeholder="">
                                </div>

                                <div class="form-group col-12 col-md-6 col-lg-4 col-xl-3">
                                    <label>Expense Date</label>
                                    <input required value="{{ old('date', $expense->date ?? now()->toDateString()) }}"
                                        name="date" type="date" class="form-control" placeholder="">
                                </div>

                                <div class="form-group col-12">
                                    <label>Description</label>
                                    <input value="{{ old('description', $expense->description ?? '') }}" name="description"
                                        type="text" class="form-control" placeholder="expensec description">
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
        .expense-amount-digits {
            font-size: 25px !important;
            font-weight: bold !important;

        }
    </style>
@endsection


@section('pagejs')
    <script>
        const edit_mode = '{{ $edit_mode }}'

        if (edit_mode) {
            menu_parent_active('expense')
        } else {
            menu_make_active('expense-create')
        }
    </script>

    <!-- Select2 -->
    <script src="/admin_assets/plugins/select2/js/select2.full.min.js"></script>

    <script>
        //Initialize Select2 Elements
        $('.select2').select2()
    </script>
@endsection

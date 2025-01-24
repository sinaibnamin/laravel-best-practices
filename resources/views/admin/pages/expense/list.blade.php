@extends('admin.master')
@section('content')
    @include('admin/partials/helpers/session_alert')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">

                    <h1 class="m-0">Expense list</h1>

                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Expense</a></li>
                        <li class="breadcrumb-item active">List</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>






    <section class="content expense-list-page">


        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">

                        @php
                            $action_url = route('admin_panel.expense.index');

                        @endphp
                        {{-- filter form  --}}

                        <form action="{{ $action_url }}" method="get" enctype="multipart/form-data">

                            <div class="card-body row align-items-end">

                            
                                <div class="form-group mb-0 col-12 col-md-6 col-lg-4 col-xl-3">
                                    <label>Expense type</label>
                                    <select name='expense_type_id' class="form-control select2" style="width: 100%;">
                                        <option value="">Select expense type</option>
                                        @foreach ($expense_types as $expense_type)
                                            <option {{ old('expense_type_id') == $expense_type->id ? 'selected' : '' }}
                                                {{ request()->get('expense_type_id') == $expense_type->id ? 'selected' : '' }}
                                                value="{{ $expense_type->id }}">{{ $expense_type->title }} </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group mb-0 col-12 col-md-6 col-lg-3 col-xl-2">
                                    <label>From Date</label>
                                    <input value="{{ request()->get('from_date') }}" name="from_date" type="date"
                                        class="form-control" placeholder="Inquery no">
                                </div>
                                <div class="form-group mb-0 col-12 col-md-6 col-lg-3 col-xl-2">
                                    <label>To Date</label>
                                    <input value="{{ request()->get('to_date') }}" name="to_date" type="date"
                                        class="form-control" placeholder="Inquery no">
                                </div>


                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary mt-3"><i class="fa-regular fa-filter"></i>
                                        Filter</button>
                                    @php
                                        $url = request()->fullUrl();
                                        $urlParts = explode('?', $url);
                                        $queryString = isset($urlParts[1]) ? $urlParts[1] : '';
                                    @endphp
                                    <a target="_blank" href="{{ url('/admin_panel/expense/print') . '?' . $queryString }}"
                                        class="btn btn-warning mt-3">
                                        <i class="fa-regular fa-print"></i> Print
                                    </a>
                                </div>

                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>


        @include('admin/pages/expense/components/expense_history_summary')


        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body table-responsive p-0">
                            @include('admin/pages/expense/components/expense_list_loop')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('admin.pages.expense.components.delete_modal')





@endsection


@section('pagejs')
    <script>
        menu_make_active('expense-list')
        $('[data-toggle="tooltip"]').tooltip()
    </script>

    <!-- Select2 -->
    <script src="/admin_assets/plugins/select2/js/select2.full.min.js"></script>

    <script>
        //Initialize Select2 Elements
        $('.select2').select2()
    </script>
@endsection

@section('pagecss')
    <!-- Select2 -->
    <link rel="stylesheet" href="/admin_assets/plugins/select2/css/select2.min.css">


@endsection

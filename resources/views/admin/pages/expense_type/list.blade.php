@extends('admin.master')
@section('content')
    @include('admin/partials/helpers/session_alert')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">

                    <h1 class="m-0">Expense Type list</h1>

                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Expense Type</a></li>
                        <li class="breadcrumb-item active">List</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <section class="content expense_type-list-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Expense Type title</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($expense_types as $expense_type)
                                        <tr>
                                            <td id="title_{{ $expense_type->id }}">{{ $expense_type->title }}</td>
                                            <td id="description_{{ $expense_type->id }}"
                                                style="text-wrap: wrap;min-width:250px;">


                                                @if ($expense_type->description)
                                                    {{ $expense_type->description }}
                                                @else
                                                    N/A
                                                @endif

                                            </td>



                                            <td id="status_{{ $expense_type->id }}">
                                                @if ($expense_type->status == 'Pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                @endif
                                                @if ($expense_type->status == 'Active')
                                                    <span class="badge bg-success">Active</span>
                                                @endif
                                                @if ($expense_type->status == 'Inactive')
                                                    <span class="badge bg-dark">Inactive</span>
                                                @endif
                                                @if ($expense_type->status == 'Trash')
                                                    <span class="badge bg-danger">Trash</span>
                                                @endif

                                            </td>
                                            <td>

                                                <a class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top"
                                                    title="Edit"
                                                    href="{{ url('/admin_panel/expense_type/edit/' . $expense_type->id) }}">
                                                    <i class="fas fa-pencil-alt">
                                                    </i>
                                                </a>
                                                @if (get_user_role() == 'admin')
                                                    @if ($expense_type->status != 'Inactive')
                                                        <a class="btn btn-dark btn-sm" data-toggle="tooltip"
                                                            data-placement="top" title="Inactive"
                                                            href="{{ url('/admin_panel/expense_type/change_status/Inactive/' . $expense_type->id) }}">
                                                            <i class="fa-solid fa-down"></i>
                                                        </a>
                                                    @endif


                                                    @if ($expense_type->status != 'Active')
                                                        <a class="btn btn-success btn-sm" data-toggle="tooltip"
                                                            data-placement="top" title="Active"
                                                            href="{{ url('/admin_panel/expense_type/change_status/Active/' . $expense_type->id) }}">
                                                            <i class="fa-solid fa-check"></i>
                                                        </a>
                                                    @endif



                                                    @if ($expense_type->expenses_count < 1)
                                                        <a class="btn btn-danger btn-sm" data-toggle="tooltip"
                                                            data-placement="top" title="Permanent delete"
                                                            href="javascript:void(0)"
                                                            onclick="deletefunction('{{ $expense_type->id }}')">
                                                            <i class="fa-sharp fa-regular fa-trash"></i>
                                                        </a>
                                                    @endif
                                                @endif
                                            </td>

                                            <td class="d-none" id="delete_href_{{ $expense_type->id }}">
                                                {{ url('/admin_panel/expense_type/delete/' . $expense_type->id) }}</td>

                                        </tr>
                                    @endforeach
                                    @if (count($expense_types) == 0)
                                        <tr>
                                            <td colspan='3' class="text-danger text-bold">sorry no data here</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    @include('admin/pages/expense_type/components/delete_modal')
@endsection


@section('pagejs')
    <script>
        menu_make_active('expense_type-list')
        $role = '{{ get_user_role() }}'
        if ($role == 'member') {
            menu_parent_active('expense_type')
        }


        $('[data-toggle="tooltip"]').tooltip()
    </script>
@endsection

@section('pagecss')
@endsection

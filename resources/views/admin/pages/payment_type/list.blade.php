@extends('admin.master')
@section('content')
    @include('admin/partials/helpers/session_alert')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">

                    <h1 class="m-0">Payment Type list</h1>

                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Payment Type</a></li>
                        <li class="breadcrumb-item active">List</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <section class="content payment_type-list-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Type name</th>
                                        <th>Description</th>
                                        <th>Amount</th>
                                        <th>Due date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($payment_types as $payment_type)
                                        <tr>
                                            <td id="payment_type_{{ $payment_type->id }}">{{ $payment_type->title }}</td>
                                            <td>{{ $payment_type->description }}</td>
                                            <td>{{ $payment_type->amount ?? 'N/A' }}</td>
                                            <td>
                                                {{ $payment_type->due_date ?? 'N/A' }}
                                            </td>
                                            <td id="status_{{ $payment_type->id }}">
                                                @if ($payment_type->status == 'Pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                @endif
                                                @if ($payment_type->status == 'Active')
                                                    <span class="badge bg-success">Active</span>
                                                @endif
                                                @if ($payment_type->status == 'Inactive')
                                                    <span class="badge bg-dark">Inactive</span>
                                                @endif
                                                @if ($payment_type->status == 'Trash')
                                                    <span class="badge bg-danger">Trash</span>
                                                @endif

                                             
                                            </td>
                                            <td>
                                              
                                                <a class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Edit"
                                                    href="{{ url('/admin_panel/payment_type/edit/' . $payment_type->id) }}">
                                                    <i class="fas fa-pencil-alt">
                                                    </i>
                                                </a>
                                                @if ($payment_type->status != 'Inactive')
                                                    <a class="btn btn-dark btn-sm" data-toggle="tooltip" data-placement="top" title="Inactive"
                                                        
                                                      href="{{ url('/admin_panel/payment_type/change_status/Inactive/' . $payment_type->id) }}"
                                                        
                                                        
                                                        >
                                                        <i class="fa-solid fa-down"></i>
                                                    </a>
                                                @endif
                                             

                                                @if ($payment_type->status != 'Active')
                                                    <a class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Active"

                                                        href="{{ url('/admin_panel/payment_type/change_status/Active/' . $payment_type->id) }}"
                                                        
                                                        >
                                                        <i class="fa-solid fa-check"></i>
                                                    </a>
                                                @endif
                                             

                                                @if (get_user_role() == 'admin' && $payment_type->payments_count < 1)
                                                    <a class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Permanent delete"
                                                    href="javascript:void(0)"
                                                    onclick="deletefunction('{{ $payment_type->id }}')"
                                                    >
                                                        <i class="fa-sharp fa-regular fa-trash"></i>
                                                    </a>
                                                @endif


                                              





                                            </td>


                                            <td class="d-none" id="delete_href_{{ $payment_type->id }}">
                                                {{ url('/admin_panel/payment_type/delete/' . $payment_type->id) }}</td>



                                        </tr>
                                    @endforeach
                                    @if (count($payment_types) == 0)
                                        <tr>
                                            <td colspan='3' class="text-danger text-bold">sorry no data here</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>

                            <div class="pagination-wrapper">
                                {{ $payment_types->appends($_GET)->links() }}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


@include('admin/pages/payment_type/components/delete_modal')





@endsection


@section('pagejs')
    <script>
        menu_make_active('payment_type-list')
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

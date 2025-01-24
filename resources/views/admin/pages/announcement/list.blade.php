@extends('admin.master')
@section('content')
    @include('admin/partials/helpers/session_alert')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">

                    <h1 class="m-0">Announcement list</h1>

                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Announcement</a></li>
                        <li class="breadcrumb-item active">List</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>




    <section class="content announcement-list-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th style="max-width: 200px">Announcement</th>
                                        <th>Priority</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($announcements as $announcement)
                                        <tr>
                                          
                                            <td style="max-width: 100%" class="text-wrap" id="announcement_{{ $announcement->id }}">

                                                 @include('admin/pages/dashboard/components/announcement/announcement')

                                            </td>
                                         
                                            <td class="text-bold" id="priority_{{ $announcement->id }}">
                                                {{ $announcement->priority }}
                                            </td>

                                            <td id="status_{{ $announcement->id }}">
                                               
                                                @if ($announcement->status == 'Active')
                                                    <span class="badge bg-success">Active</span>
                                                @endif
                                                @if ($announcement->status == 'Inactive')
                                                    <span class="badge bg-dark">Inactive</span>
                                                @endif
                                             
                                            </td>

                                            <td>
                                             
                                                <a class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Edit"
                                                    href="{{ url('/admin_panel/announcement/edit/' . $announcement->id) }}">
                                                    <i class="fas fa-pencil-alt">
                                                    </i>
                                                </a>
                                                @if ($announcement->status != 'Inactive')
                                                    <a class="btn btn-dark btn-sm" data-toggle="tooltip" data-placement="top" title="Inactive"
                                                    href="{{ url('/admin_panel/announcement/change_status/Inactive/' . $announcement->id) }}">
                                                        <i class="fa-solid fa-down"></i>
                                                    </a>
                                                @endif
                                              

                                                @if ($announcement->status != 'Active')
                                                    <a class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Active"
                                                    href="{{ url('/admin_panel/announcement/change_status/Active/' . $announcement->id) }}">
                                                        <i class="fa-solid fa-check"></i>
                                                    </a>
                                                @endif
                                               

                                                @if (get_user_role() == 'admin' )
                                                    <a class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Permanent delete"
                                                    href="javascript:void(0)"
                                                    onclick="deletefunction('{{ $announcement->id }}')"
                                                    >
                                                        <i class="fa-sharp fa-regular fa-trash"></i>
                                                    </a>
                                                @endif


                                            </td>

                                            <td class="d-none" id="announcement_delete_url_{{ $announcement->id }}">
                                                {{ url('/admin_panel/announcement/delete/' . $announcement->id) }}</td>


                                        </tr>
                                    @endforeach
                                    @if (count($announcements) == 0)
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

    @include('admin.pages.announcement.components.delete_modal')



@endsection


@section('pagejs')
    <script>
        menu_make_active('announcement-list')
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
    <style>
        .image-part {
            width: 40px;
            height: 40px;
            background-size: cover !important;
        }
        .alert{
            margin-bottom: 0 !important;
        }
    </style>
@endsection

@extends('admin.master')
@section('content')
    @include('admin/partials/helpers/session_alert')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    @if ($trash_page)
                        <h1 class="m-0 text-danger">Trainer trash list</h1>
                    @else
                        <h1 class="m-0">Trainer list</h1>
                    @endif
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Trainer category</a></li>
                        <li class="breadcrumb-item active">List</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>






    <section class="content trainer-list-page">






        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">

                        @php
                            $action_url = route('admin_panel.trainer.index');
                            if ($trash_page) {
                                $action_url = route('admin_panel.trainer.trashlist');
                            }
                        @endphp
                        {{-- filter form  --}}

                        <form action="{{ $action_url }}" method="get" enctype="multipart/form-data">

                            <div class="card-body row align-items-end">

                                <div class="form-group mb-0 col-12 col-md-6 col-lg-3 col-xl-2">
                                    <label>Full name</label>
                                    <input value="{{ request()->get('full_name') }}" name="full_name" type="text"
                                        class="form-control" placeholder="full name">
                                </div>
                                <div class="form-group mb-0 col-12 col-md-6 col-lg-3 col-xl-2">
                                    <label>Phone number</label>
                                    <input value="{{ request()->get('phone_number') }}" name="phone_number" type="text"
                                        class="form-control" placeholder="0167379....">
                                </div>



                                <div class="form-group mb-0 col-12 col-md-6 col-lg-3 col-xl-2">
                                    <label>Trainer status</label>
                                    <select name='status' class="form-control">
                                        <option value="all">All</option>

                                        <option {{ request()->get('status') == 'Pending' ? 'selected' : '' }}
                                            value="Pending">
                                            Pending</option>
                                        <option {{ request()->get('status') == 'Active' ? 'selected' : '' }} value="Active">
                                            Active</option>
                                        <option {{ request()->get('status') == 'Inactive' ? 'selected' : '' }}
                                            value="Inactive">
                                            Inactive</option>

                                    </select>
                                </div>


                                <div class="col-12 col-md-6 col-lg-3 col-xl-2">
                                    <button type="submit" class="btn btn-primary mt-3"><i class="fa-regular fa-filter"></i>
                                        Filter</button>
                                </div>

                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>



        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th style="min-width: 150px; max-width:250px;">Name</th>
                                        <th>Age</th>
                                        <th>Gender</th>
                                        <th>Phone</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($trainers as $trainer)
                                        <tr>
                                            <td id="photo_{{ $trainer->id }}">


                                                @php
                                                    $trainer_img_url =
                                                        asset('/') . 'site_images/statics/super_user_dummy.jpg';
                                                    if ($trainer->image) {
                                                        $trainer_img_url =
                                                            asset('/') .
                                                            'site_images/uploaded/trainer_images/' .
                                                            $trainer->image;
                                                    }
                                                @endphp

                                                <div class="table-round-image" style="background: url({{ $trainer_img_url }});">
                                                </div>
                                            </td>
                                            <td class="" style="text-wrap:wrap;" id="name_{{ $trainer->id }}">
                                                {{ $trainer->full_name }}
                                            </td>
                                            <td id="age_{{ $trainer->id }}">
                                                @php
                                                    $dob = \Carbon\Carbon::parse($trainer->date_of_birth);
                                                    $now = \Carbon\Carbon::now();

                                                    // Calculate the age in years and months
                                                    $years = $dob->diffInYears($now);
                                                    $months = $dob->copy()->addYears($years)->diffInMonths($now);
                                                @endphp

                                                {{ $years . ' years, ' . $months . ' months' }}
                                            </td>
                                            <td>
                                                {{ $trainer->gender }}
                                            </td>
                                            <td id="phone_{{ $trainer->id }}">
                                                {{ $trainer->phone_number }}
                                            </td>

                                            <td id="status_{{ $trainer->id }}">
                                                @if ($trainer->status == 'Pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                @endif
                                                @if ($trainer->status == 'Active')
                                                    <span class="badge bg-success">Active</span>
                                                @endif
                                                @if ($trainer->status == 'Inactive')
                                                    <span class="badge bg-dark">Inactive</span>
                                                @endif
                                                @if ($trainer->status == 'Trash')
                                                    <span class="badge bg-danger">Trash</span>
                                                @endif
                                            </td>


                                            <td>
                                                <a class="btn btn-secondary btn-sm" data-toggle="tooltip"
                                                    data-placement="top" title="View"
                                                    href="{{ url('/admin_panel/trainer/show/' . $trainer->id) }}">
                                                    <i class="fas fa-eye">
                                                    </i>
                                                </a>
                                                <a class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top"
                                                    title="Edit"
                                                    href="{{ url('/admin_panel/trainer/edit/' . $trainer->id) }}">
                                                    <i class="fas fa-pencil-alt">
                                                    </i>
                                                </a>
                                                @if ($trainer->status != 'Inactive')
                                                    <a class="btn btn-dark btn-sm" data-toggle="tooltip"
                                                        data-placement="top" title="Inactive"
                                                        href="{{ url('/admin_panel/trainer/change_status/Inactive/' . $trainer->id) }}">
                                                        <i class="fa-solid fa-down"></i>
                                                    </a>
                                                @endif
                                                @if ($trainer->status != 'Pending')
                                                    <a class="btn btn-warning btn-sm" data-toggle="tooltip"
                                                        data-placement="top" title="Pending"
                                                        href="{{ url('/admin_panel/trainer/change_status/Pending/' . $trainer->id) }}">
                                                        <i class="fa-solid fa-down"></i>
                                                    </a>
                                                @endif

                                                @if ($trainer->status != 'Active')
                                                    <a class="btn btn-success btn-sm" data-toggle="tooltip"
                                                        data-placement="top" title="Active"
                                                        href="{{ url('/admin_panel/trainer/change_status/Active/' . $trainer->id) }}">
                                                        <i class="fa-solid fa-check"></i>
                                                    </a>
                                                @endif
                                                @if ($trainer->status != 'Trash')
                                                    <a class="btn btn-warning btn-sm" data-toggle="tooltip"
                                                        data-placement="top" title="Trash"
                                                        href="{{ url('/admin_panel/trainer/change_status/Trash/' . $trainer->id) }}">

                                                        <i class="fa-sharp fa-regular fa-trash"></i>
                                                    </a>
                                                @endif

                                                @if (get_user_role() == 'admin' && $trainer->status == 'Trash')
                                                    <a class="btn btn-danger btn-sm" data-toggle="tooltip"
                                                        data-placement="top" title="Permanent delete"
                                                        href="javascript:void(0)"
                                                        onclick="deletefunction('{{ $trainer->id }}')">
                                                        <i class="fa-sharp fa-regular fa-trash"></i>
                                                    </a>
                                                @endif


                                            </td>


                                            <td class="d-none" id="trainer_delete_url_{{ $trainer->id }}">
                                                {{ url('/admin_panel/trainer/delete/' . $trainer->id) }}</td>


                                        </tr>
                                    @endforeach
                                    @if (count($trainers) == 0)
                                        <tr>
                                            <td colspan='3' class="text-danger text-bold">sorry no data here</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>

                            <div class="pagination-wrapper">
                                {{ $trainers->appends($_GET)->links() }}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('admin.pages.trainer.components.delete_modal')
    
@endsection


@section('pagejs')
    <script>
        const trash_page = '{{ $trash_page }}'
        $('[data-toggle="tooltip"]').tooltip()

        if (trash_page) {
            menu_make_active('trainer-trashlist')
        } else {
            menu_make_active('trainer-list')
        }
    </script>
@endsection

@section('pagecss')
   
@endsection

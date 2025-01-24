@extends('admin.master')
@section('content')
    @include('admin/partials/helpers/session_alert')

    @php
        $current_page_mode = 'admin_view';
        if (isset($page_mode) && $page_mode == 'trainer_view') {
            $current_page_mode = 'trainer_view';
        }
    @endphp

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Trainer Detail</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Trainer</a></li>
                        <li class="breadcrumb-item active">Show</li>
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
                        <div class="card-body trainer-profile">
                            <div class="top-part" >
                                @php
                                    $trainer_img_url = asset('/') . 'site_images/statics/super_user_dummy.jpg';
                                    if ($trainer->image) {
                                        $trainer_img_url =
                                            asset('/') . 'site_images/uploaded/trainer_images/' . $trainer->image;
                                    }
                                @endphp
                                <div class="img-part" id="photo_{{ $trainer->id }}">
                                    <img src="{{$trainer_img_url}}" class="">
                                </div>
                                <div class="name-part">
                                    <h3 class="trainer-name" id="name_{{ $trainer->id }}">{{ $trainer->full_name }}</h3>
                                    <h3 class="trainer-phone" id="phone_{{ $trainer->id }}">{{ $trainer->phone_number }}</h3>
                                </div>
                            </div>
                            <div class="table-part">
                                <table class="table table-hover table-bordered mt-3">
                                    <tbody>
                                        <tr>
                                            <td>Address</td>
                                            <td>{{ $trainer->address }}</td>
                                        </tr>
                                        <tr>
                                            <td>NID</td>
                                            <td>{{ $trainer->nid }}</td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td>{{ $trainer->email }}</td>
                                        </tr>
                                        <tr>
                                            <td>Date of Birth</td>
                                            <td>{{ $trainer->date_of_birth }}</td>
                                        </tr>

                                        <tr>
                                            <td>Age</td>
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
                                        </tr>




                                        <tr>
                                            <td>Gender</td>
                                            <td>{{ $trainer->gender }}</td>
                                        </tr>
                                        <tr>
                                            <td>Emergency Contact Name</td>
                                            <td>{{ $trainer->emergency_contact_name }}</td>
                                        </tr>
                                        <tr>
                                            <td>Emergency Contact Relationship</td>
                                            <td>{{ $trainer->emergency_contact_relationship }}</td>
                                        </tr>
                                        <tr>
                                            <td>Emergency Contact Phone</td>
                                            <td>{{ $trainer->emergency_contact_phone }}</td>
                                        </tr>
                                     
                                        <tr>
                                            <td>Trainer status</td>
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

                                            <td class="d-none" id="trainer_delete_url_{{ $trainer->id }}">
                                                {{ url('/admin_panel/trainer/delete/' . $trainer->id) . '?profile_page=true' }}</td>

                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>






                        <div class="card-footer">

                            <div class="footer-default-elements">

                                @if (get_user_role() == 'trainer')
                                    <a class="btn btn-primary btn-sm" href="{{ url('/trainer_panel/editprofile') }}">
                                        <i class="fas fa-pencil-alt">
                                        </i>
                                        Edit
                                    </a>
                                @endif



                                @if (get_user_role() == 'admin' || get_user_role() == 'operator')
                                    <a class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top"
                                        title="Edit" href="{{ url('/admin_panel/trainer/edit/' . $trainer->id) }}">
                                        <i class="fas fa-pencil-alt">
                                        </i>
                                    </a>
                                    @if ($trainer->status != 'Inactive')
                                        <a class="btn btn-dark btn-sm" data-toggle="tooltip" data-placement="top"
                                            title="Inactive"
                                            href="{{ url('/admin_panel/trainer/change_status/Inactive/' . $trainer->id) }}">
                                            <i class="fa-solid fa-down"></i>
                                        </a>
                                    @endif
                                    @if ($trainer->status != 'Pending')
                                        <a class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top"
                                            title="Pending"
                                            href="{{ url('/admin_panel/trainer/change_status/Pending/' . $trainer->id) }}">
                                            <i class="fa-solid fa-down"></i>
                                        </a>
                                    @endif

                                    @if ($trainer->status != 'Active')
                                        <a class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top"
                                            title="Active"
                                            href="{{ url('/admin_panel/trainer/change_status/Active/' . $trainer->id) }}">
                                            <i class="fa-solid fa-check"></i>
                                        </a>
                                    @endif
                                    @if ($trainer->status != 'Trash')
                                        <a class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top"
                                            title="Trash"
                                            href="{{ url('/admin_panel/trainer/change_status/Trash/' . $trainer->id) }}">

                                            <i class="fa-sharp fa-regular fa-trash"></i>
                                        </a>
                                    @endif

                                    @if (get_user_role() == 'admin' && $trainer->status == 'Trash')
                                        <a class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top"
                                            title="Permanent delete" href="javascript:void(0)"
                                            onclick="deletefunction('{{ $trainer->id }}')">
                                            <i class="fa-sharp fa-regular fa-trash"></i>
                                        </a>
                                    @endif
                                @endif


                            

                            </div>




                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('admin.pages.trainer.components.delete_modal')


@endsection

@section('pagecss')
    <style>
        .trainer-profile .top-part {
            display: flex;
            gap: 20px;
            align-items: center
        }

        .trainer-profile .top-part .img-part {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            overflow: hidden;
            border: 2px solid #98caff;
        }

        .trainer-profile .top-part .img-part img {
            width: 100px;
            height: 100px;
            object-fit: cover;
        }

        .trainer-profile .top-part .name-part {
            width: auto;
            height: auto;
        }

        .trainer-profile .top-part .name-part .trainer-name {
            font-size: 30px;
            font-weight: bold;
            color: var(--blue);
        }



        .trainer-profile .top-part .name-part .trainer-phone {
            font-size: 20px;
            font-weight: bold;
            color: var(--gray);
        }

        @media (max-width:767px) {
            .trainer-profile .top-part .name-part .trainer-name {
                font-size: 20px;
            }

            .trainer-profile .top-part .name-part .trainer-phone {
                font-size: 16px;
            }
        }
    </style>
@endsection

@section('pagejs')
    <script>
        const page_mode = '{{ $current_page_mode }}'
        if (page_mode == 'trainer_view') {
            menu_make_active('setting-profile')
        }
        if (page_mode == 'admin_view') {
            menu_parent_active('trainer')
        }
        $('[data-toggle="tooltip"]').tooltip()



    </script>

    <script>
      
    </script>
@endsection

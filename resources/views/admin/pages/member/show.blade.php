@extends('admin.master')
@section('content')
    @include('admin/partials/helpers/session_alert')

    @php
        $current_page_mode = 'admin_view';
        if (isset($page_mode) && $page_mode == 'member_view') {
            $current_page_mode = 'member_view';
        }
    @endphp

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Member Detail</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Member</a></li>
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
                        <div class="card-body member-profile">


                            <div id="photo_{{ $member->id }}" class="d-none">

                                @php
                                    $member_img_url = asset('/') . 'site_images/statics/user_dummy.jpg';
                                    if ($member->image) {
                                        $member_img_url =
                                            asset('/') . 'site_images/uploaded/member_images/' . $member->image;
                                    }
                                @endphp

                                <div class="d-flex align-items-center">
                                    <div class="mr-2" style="height: max-content;width: max-content;">
                                        <img src="{{ $member_img_url }}" alt="Product 1" class="table-round-image">
                                    </div>
                                    <div class="d-flex flex-column">
                                        <div style="text-wrap: wrap;">
                                            {{ $member->full_name }}
                                        </div>

                                    </div>
                                </div>

                            </div>


                            <div class="top-part">

                                <div class="img-part">

                                    @php
                                        $member_img_url = asset('/') . 'site_images/statics/user_dummy.jpg';
                                        if ($member->image) {
                                            $member_img_url =
                                                asset('/') . 'site_images/uploaded/member_images/' . $member->image;
                                        }
                                    @endphp


                                    <img src="{{ $member_img_url }}" class="">
                                </div>
                                <div class="name-part">
                                    <h3 class="member-name" id="name_{{ $member->id }}">{{ $member->full_name }}</h3>
                                    <h3 class="member-phone" id="phone_{{ $member->id }}">{{ $member->phone_number }}</h3>
                                </div>
                            </div>
                            <div class="table-part">
                                <table class="table table-hover table-bordered mt-3">
                                    <tbody>
                                        <tr>
                                            <td>Uniq ID</td>
                                            <td id="uniq_id_{{ $member->id }}">
                                                {{ $member->uniq_id }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Address</td>
                                            <td>{{ $member->address }}</td>
                                        </tr>
                                        <tr>
                                            <td>NID</td>
                                            <td>{{ $member->nid }}</td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td>{{ $member->email }}</td>
                                        </tr>
                                        <tr>
                                            <td>Date of Birth</td>
                                            <td>{{ $member->date_of_birth }}</td>
                                        </tr>
                                        <tr>
                                            <td>Age</td>
                                            <td id="age_{{ $member->id }}">

                                                @php
                                                    $dob = \Carbon\Carbon::parse($member->date_of_birth);
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
                                            <td>{{ $member->gender }}</td>
                                        </tr>
                                        <tr>
                                            <td>Emergency Contact Name</td>
                                            <td>{{ $member->emergency_contact_name }}</td>
                                        </tr>
                                        <tr>
                                            <td>Emergency Contact Relationship</td>
                                            <td>{{ $member->emergency_contact_relationship }}</td>
                                        </tr>
                                        <tr>
                                            <td>Emergency Contact Phone</td>
                                            <td>{{ $member->emergency_contact_phone }}</td>
                                        </tr>
                                        <tr>
                                            <td>Medical Conditons Details</td>
                                            <td>{{ $member->medical_conditions_details }}</td>
                                        </tr>
                                        <tr>
                                            <td>Member status</td>
                                            <td id="status_{{ $member->id }}">
                                                @if ($member->status == 'Pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                @endif
                                                @if ($member->status == 'Approve')
                                                    <span class="badge bg-warning">Approve</span>
                                                @endif
                                                @if ($member->status == 'Active')
                                                    <span class="badge bg-success">Active</span>
                                                @endif
                                                @if ($member->status == 'Inactive')
                                                    <span class="badge bg-dark">Inactive</span>
                                                @endif
                                                @if ($member->status == 'Archive')
                                                    <span class="badge bg-secondary">Archive</span>
                                                @endif
                                                @if ($member->status == 'Expire')
                                                    <span class="badge bg-danger">Expire</span>
                                                @endif
                                            </td>

                                        <tr>
                                            <td>Blood group</td>
                                            <td>{{ $member->blood_group }}</td>
                                        </tr>
                                        <tr>
                                            <td>Profession</td>
                                            <td>{{ $member->blood_group }}</td>
                                        </tr>
                                        <tr>
                                            <td>Weight</td>
                                            <td>{{ $member->weight }}</td>
                                        </tr>
                                        <tr>
                                            <td>Height</td>
                                            <td>{{ $member->height }}</td>
                                        </tr>
                                        <tr>
                                            <td>Neck</td>
                                            <td>{{ $member->neck }}</td>
                                        </tr>
                                        <tr>
                                            <td>Shoulder</td>
                                            <td>{{ $member->shoulder }}</td>
                                        </tr>
                                        <tr>
                                            <td>Chest</td>
                                            <td>{{ $member->chest }}</td>
                                        </tr>
                                        <tr>
                                            <td>Abdomen</td>
                                            <td>{{ $member->abdomen }}</td>
                                        </tr>
                                        <tr>
                                            <td>Waist</td>
                                            <td>{{ $member->waist }}</td>
                                        </tr>
                                        <tr>
                                            <td>Marital status</td>
                                            <td>{{ $member->marital_status }}</td>
                                        </tr>
                                        <tr>
                                            <td>Validity</td>
                                            <td>{{ $member->validity ? \Carbon\Carbon::parse($member->validity)->format('d F Y') : 'N/A' }}</td>
                                        </tr>


                                        <td class="d-none" id="member_delete_url_{{ $member->id }}">
                                            {{ url('/admin_panel/member/delete/' . $member->id) . '?profile_page=true' }}
                                        </td>


                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>






                        <div class="card-footer">

                            <div class="footer-default-elements">

                                @if (get_user_role() == 'admin' || get_user_role() == 'operator')
                                    <a class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top"
                                        title="Edit" href="{{ url('/admin_panel/member/edit/' . $member->id) }}">
                                        <i class="fas fa-pencil-alt">
                                        </i>
                                    </a>
                                    {{-- @if ($member->status != 'Inactive')
                                        <a class="btn btn-dark btn-sm" data-toggle="tooltip" data-placement="top"
                                            title="Inactive"
                                            href="{{ url('/admin_panel/member/change_status/Inactive/' . $member->id) }}">
                                            <i class="fa-solid fa-down"></i>
                                        </a>
                                    @endif --}}



                                    @if ($member->status != 'Active' && $member->status != 'Pending')
                                        <a class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top"
                                            title="Active"
                                            href="{{ url('/admin_panel/member/change_status/Active/' . $member->id) }}">
                                            <i class="fa-solid fa-check"></i>
                                        </a>
                                    @endif
                                    @if (
                                        $member->status == 'Pending' ||
                                            $member->status == 'Inactive' ||
                                            $member->status == 'Archive' )
                                        <a class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top"
                                            title="Approve"
                                            href="{{ url('/admin_panel/member/change_status/Approve/' . $member->id) }}">
                                            <i class="fa-solid fa-check"></i>
                                        </a>
                                    @endif
                                    @if ($member->status != 'Archive')
                                        <a class="btn btn-secondary btn-sm" data-toggle="tooltip" data-placement="top"
                                            title="Archive"
                                            href="{{ url('/admin_panel/member/change_status/Archive/' . $member->id) }}">
                                            <i class="fa-regular fa-inbox"></i>

                                        </a>
                                    @endif

                                    @if (get_user_role() == 'admin' && $member->status == 'Archive')
                                        <a class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top"
                                            title="Permanent delete" href="javascript:void(0)"
                                            onclick="deletefunction('{{ $member->id }}')">
                                            <i class="fa-sharp fa-regular fa-trash"></i>
                                        </a>
                                    @endif
                                @endif


                                @if (get_user_role() == 'member')
                                    <a class="btn btn-primary btn-sm" href="{{ url('/member_panel/editprofile') }}">
                                        <i class="fas fa-pencil-alt">
                                        </i>
                                        Edit
                                    </a>
                                @endif





                            </div>




                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('admin.pages.member.components.delete_modal')
@endsection

@section('pagecss')
    <style>
        .member-profile .top-part {
            display: flex;
            gap: 20px;
            align-items: center
        }

        .member-profile .top-part .img-part {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            overflow: hidden;
            border: 2px solid #98caff;
        }

        .member-profile .top-part .img-part img {
            width: 100px;
            height: 100px;
            object-fit: cover;

        }

        .member-profile .top-part .name-part {
            width: auto;
            height: auto;
        }

        .member-profile .top-part .name-part .member-name {
            font-size: 30px;
            font-weight: bold;
            color: var(--blue);
        }



        .member-profile .top-part .name-part .member-phone {
            font-size: 20px;
            font-weight: bold;
            color: var(--gray);
        }

        @media (max-width:767px) {
            .member-profile .top-part .name-part .member-name {
                font-size: 20px;
            }

            .member-profile .top-part .name-part .member-phone {
                font-size: 16px;
            }
        }
    </style>
@endsection

@section('pagejs')
    <script>
        const page_mode = '{{ $current_page_mode }}'
        if (page_mode == 'member_view') {
            menu_make_active('setting-profile')
        }
        if (page_mode == 'admin_view') {
            menu_parent_active('member')
        }
        $('[data-toggle="tooltip"]').tooltip()
    </script>
@endsection

@extends('admin.master')
@section('content')
    @include('admin/partials/helpers/session_alert')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Member Attendance Daily Track</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Member Attendance</a></li>
                        <li class="breadcrumb-item active">List</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    @php
        $action_url = route('admin_panel.member_attendance.daily_track');
        $current_page_mode = 'admin';

    @endphp



    <section class="content member_attendance-list-page">

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">


                        {{-- filter form  --}}

                        <form action="{{ $action_url }}" method="get" enctype="multipart/form-data">

                            <div class="card-body row align-items-end">

                                <div class="form-group mb-0 col-12 col-md-6 col-lg-4">
                                    <label>Select Date</label>
                                    <input value="{{ request()->get('attendance_date') }}" class="form-control"
                                        type="date" name="attendance_date">
                                </div>

                                <div class="col-12 col-md-6 col-lg-3 col-xl-2">
                                    <button type="submit" class="btn btn-primary mt-3">
                                        <i class="fa-sharp fa-solid fa-table mr-2"></i>
                                        Track</button>
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
                        <div class="card-body p-0">

                            <div class="members-daily-track-wrapper ">

                                <div class="row mb-4 justify-content-between align-items-center">
                                    <div class="col-12 col-md-6">
                                        <h4 class="attendance-date m-0"
                                            data-value="{{ \Carbon\Carbon::parse($attendance_report_date)->format('Y-m-d') }}">
                                            Attendance report of <b
                                                class="text-primary">{{ \Carbon\Carbon::parse($attendance_report_date)->format('d M Y') }}</b>
                                        </h4>
                                    </div>

                                    <div class="col-12 col-md-6 col-lg-4">

                                        <div class="search-container">

                                            <input type="text" id="searchBox"
                                                placeholder="Search by name, unique ID, or phone"
                                                onkeyup="filterMembers()" />

                                            <span class="clear-icon" onclick="clearSearch()">&#10006;</span>
                                        </div>
                                    </div>
                                </div>



                                <div class="members-wrapper">
                                    @foreach ($member_attendances as $member_attendance)
                                        @php
                                            $member_img_url = asset('/') . 'site_images/statics/user_dummy.jpg';
                                            if (optional($member_attendance['member'])->image) {
                                                $member_img_url =
                                                    asset('/') .
                                                    'site_images/uploaded/member_images/' .
                                                    $member_attendance['member']->image;
                                            }
                                            $status = $member_attendance['present'] ? 'Present' : 'Absent';
                                            $staus_class = $member_attendance['present'] ? 'present' : '';

                                            $memberExpire = '';
                                            if ($member_attendance['member']->status == 'Expire') {
                                                $memberExpire = 'expire';
                                            }

                                            $bottomValidityText = $member_attendance['member']->validity
                                                ? \Carbon\Carbon::parse($member_attendance['member']->validity)->format(
                                                    'd M Y',
                                                )
                                                : 'N/A';

                                        @endphp

                                        <div class="member {{ $staus_class }} {{ $memberExpire }}"
                                            data-member-id="{{ $member_attendance['member']->id }}">
                                            <img src="{{ $member_img_url }}" alt="" class="table-round-image">
                                            <div class="name">{{ $member_attendance['member']->full_name }}</div>
                                            <div class="uniq_id">{{ $member_attendance['member']->uniq_id }}</div>
                                            <div class="phone">{{ $member_attendance['member']->phone_number }}</div>
                                            <div class="status">{{ $status }}</div>
                                            <div class="text-center validity">
                                                Validity {{ $bottomValidityText }}
                                            </div>

                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('admin/pages/member_attendance/components/delete_modal')
@endsection


@section('pagejs')
    <script>
        const current_page_mode = '{{ $current_page_mode }}'
        menu_make_active('member_attendance-list')
    </script>
    <script src="/admin_assets/dist/js/atendance/daily_track.js"></script>
    <script src="/admin_assets/dist/js/atendance/daily_track_member_search.js"></script>
@endsection

@section('pagecss')
    <link rel="stylesheet" href="/admin_assets/dist/css/attendance/attendance_daily_track.css">
@endsection

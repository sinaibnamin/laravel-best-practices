@extends('admin.master')
@section('content')
    @include('admin/partials/helpers/session_alert')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Member Attendance Monthly Report</h1>
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
        $action_url = route('admin_panel.member_attendance.monthly_report');
        $current_page_mode = 'admin';

    @endphp



    <section class="content member_attendance-list-page">

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">


                        <form action="{{ $action_url }}" method="get" enctype="multipart/form-data">

                            <div class="card-body row align-items-end">

                                <div class="form-group mb-0 col-12 col-md-6 col-lg-4">
                                    <label>Select Month</label>
                                    <input value="{{ request()->get('attendance_month') }}" class="form-control"
                                        type="month" name="attendance_month">
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
                        <div class="card-body table-responsive p-0">


                            @php
                                // Format the month and year for display
                                $formattedMonth = \Carbon\Carbon::createFromFormat(
                                    'm',
                                    $attendance_report_month,
                                )->format('F');
                                $formattedYear = $attendance_report_year;
                            @endphp

                            <div class="pt-2 pb-2 pl-3 pr-2">
                                <h4 class="m-0 attendance-date"
                                    data-value="{{ $attendance_report_month }}-{{ $attendance_report_year }}">
                                    Attendance report of <b class="text-primary">{{ $formattedMonth }}
                                        {{ $formattedYear }}</b>
                                </h4>
                            </div>



                            <table class="table table-bordered table-hover text-center">
                                <thead>
                                    <tr>
                                        <th class="text-left">Member Name</th>
                                        @for ($day = 1; $day <= $number_of_days; $day++)
                                            <th>{{ $day }}</th>
                                        @endfor
                                        <th>Total Present</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($member_attendances as $attendance)
                                        @php
                                            $totalPresent = 0; 
                                        @endphp
                                        <tr>
                                            <td class="text-left">
                                                {{ $attendance['member']->full_name }}
                                                <br>
                                                <small>{{ $attendance['member']->uniq_id }}</small>
                                                
                                            </td>
                                            @foreach ($attendance['attendance_status'] as $status)
                                                <td
                                                    style="background-color: {{ $status['status'] === 'Present' ? '#d4edda80' : '#f8d7da80' }};">
                                                    {{ $status['status'] === 'Present' ? 'P' : 'A' }}
                                                </td>
                                                @php
                                                    if ($status['status'] === 'Present') {
                                                        $totalPresent++; // Increment the total present counter
                                                    }
                                                @endphp
                                            @endforeach
                                            <td>{{ $totalPresent }} Days</td> <!-- Display the total present count -->
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
        menu_make_active('member_attendance-monthly_report')
    </script>
@endsection

@section('pagecss')
@endsection

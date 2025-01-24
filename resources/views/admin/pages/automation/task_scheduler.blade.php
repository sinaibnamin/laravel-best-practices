@extends('admin.master')
@section('content')
    @include('admin/partials/helpers/session_alert')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Automation Report list</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Automation Report</a></li>
                        <li class="breadcrumb-item active">List</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    @php
      $action_url = route('admin_panel.automation.task_scheduler');
    @endphp

    <section class="content automation_report-list-page">

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        {{-- filter form  --}}
                        <form action="{{ $action_url }}" method="get" enctype="multipart/form-data">

                            <div class="card-body row align-items-end">

                                <div class="form-group mb-0 col-12 col-md-6 col-lg-4">
                                    <label>Task type</label>
                                    <select name='type' class="form-control select2" style="width: 100%;">
                                        <option value="">Select type</option>
                                        <option {{ request()->get('type') == 'member_expire_check' ? 'selected' : '' }} value="member_expire_check">Member expire check</option>
                                        <option {{ request()->get('type') == 'member_archive_check' ? 'selected' : '' }} value="member_archive_check">Member archive check</option>

                                        <option {{ request()->get('type') == 'failed_payment_deletion' ? 'selected' : '' }} value="failed_payment_deletion">Failed payment deletion</option>
                                        <option {{ request()->get('type') == 'member_expire_sms_alert' ? 'selected' : '' }} value="member_expire_sms_alert">Member expire sms alert</option>

                                    </select>
                                </div>

                                <div class="form-group mb-0 col-12 col-md-6 col-lg-4">
                                    <label>Error status</label>
                                    <select name='error_status' class="form-control select2" style="width: 100%;">
                                        <option value="">Select error type</option>
                                        <option {{ request()->get('error_status') == 'no_error' ? 'selected' : '' }}  value="no_error">No error</option>
                                        <option {{ request()->get('error_status') == 'error' ? 'selected' : '' }} value="error">Has error</option>
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
                                        <th style="max-width: 100%">Report</th>
                                        <th>Task type</th>
                                        <th>Error status</th>
                                        
                                        <th>time</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($mem_exp_reports as $automation_report)
                                        <tr>
                                            <td id=""
                                            style="text-wrap: wrap;min-width:250px;">
                                            {!! $automation_report->report !!}
                                        </td>
                                            <td id=""> {{$automation_report->type}} </td>
                                            <td id=""> {{$automation_report->error}} </td>
                                           
                                         

                                            <td>
                                                {!! \Carbon\Carbon::parse($automation_report->created_at)->format('F d, Y') !!} <br />
                                                {!! \Carbon\Carbon::parse($automation_report->created_at)->format('g:i A') !!}
                                            </td>









                                        </tr>
                                    @endforeach
                                    @if (count($mem_exp_reports) == 0)
                                        <tr>
                                            <td colspan='3' class="text-danger text-bold">sorry no data here</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>

                            <div class="pagination-wrapper">
                                {{ $mem_exp_reports->appends($_GET)->links() }}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection


@section('pagejs')
 
    <script>
        menu_make_active('automation-task_scheduler');
    </script>
@endsection

@section('pagecss')
   
@endsection

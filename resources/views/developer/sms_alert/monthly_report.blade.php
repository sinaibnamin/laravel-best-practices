@extends('admin.master')
@section('content')
    @include('admin/partials/helpers/session_alert')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">



                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Sms</a></li>
                        <li class="breadcrumb-item active">monthly report</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>






    <section class="content payment-list-page">


        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">

                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-6 col-xl-4">
                                    <form method="GET" action="{{ url()->current() }}" class="mb-4">
                                        <div class="mb-3">
                                            <label for="month" class="form-label">Select Month</label>
                                            <input type="month" id="month" name="month" class="form-control"
                                                required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Get SMS Count</button>
                                    </form>
                                </div>
                            </div>

                            @if (!is_null($smsCount))
                                <div class="alert alert-info">
                                    <strong>Total SMS Count:</strong> {{ $smsCount }}
                                </div>
                            @endif
                        </div>




                    </div>
                </div>
            </div>
        </div>   

      
    </section>
@endsection


@section('pagejs')
    <script>
        menu_parent_active('sms-count')
    </script>
@endsection

@section('pagecss')
@endsection

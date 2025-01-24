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
                        <li class="breadcrumb-item active">change ststus</li>
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
                                    <form method="post" action="{{ route('developer_panel.system-setting-update') }}">
                                        @csrf 
                                        <div class="mb-3">
                                            <label for="sms_alert_enable" class="form-label">SMS Alert Status <small>current status = {{$ManagementSiteSettings->sms_alert_enable}}</small> </label>
                                            <select id="sms_alert_enable" name="sms_alert_enable" class="form-control" required>
                                                <option value="">select</option>
                                                <option value="true" {{ old('sms_alert_enable', $ManagementSiteSettings->sms_alert_enable ?? '') == 'true' ? 'selected' : '' }}>True</option>
                                                <option value="false" {{ old('sms_alert_enable', $ManagementSiteSettings->sms_alert_enable ?? '') == 'false' ? 'selected' : '' }}>False</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="online_payment_enable" class="form-label">Online payment enable Status <small>current status = {{$ManagementSiteSettings->online_payment_enable}}</small> </label>
                                            <select id="online_payment_enable" name="online_payment_enable" class="form-control" required>
                                                <option value="">select</option>
                                                <option value="true" {{ old('online_payment_enable', $ManagementSiteSettings->online_payment_enable ?? '') == 'true' ? 'selected' : '' }}>True</option>
                                                <option value="false" {{ old('online_payment_enable', $ManagementSiteSettings->online_payment_enable ?? '') == 'false' ? 'selected' : '' }}>False</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </form>
                                </div>
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
        menu_parent_active('system-setting')
    </script>
@endsection

@section('pagecss')
@endsection

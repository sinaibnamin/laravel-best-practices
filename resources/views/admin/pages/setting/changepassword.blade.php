@extends('admin.master')
@section('content')
    @include('admin/partials/helpers/session_alert')

    @php
        $current_panel = 'admin_panel';
        $action_url = route('admin_panel.setting.updatepassword');
        if (isset($panel_type) && $panel_type == 'member_panel') {
            $current_panel = 'member_panel';
            $action_url = route('member_panel.updatepassword');
        }
        if (isset($panel_type) && $panel_type == 'trainer_panel') {
            $current_panel = 'trainer_panel';
            $action_url = route('trainer_panel.updatepassword');
        }
    @endphp

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Change password</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Setting</a></li>
                        <li class="breadcrumb-item active">Password</li>
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

                        <form action="{{ $action_url }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Old Password</label>
                                    <input required value="{{ old('old_password') }}" name="old_password" type="password"
                                        class="form-control" placeholder="old password" minlength="5" maxlength="20">
                                </div>
                                <div class="form-group">
                                    <label>New Password</label>
                                    <input required value="{{ old('new_password') }}" id="password" name="new_password"
                                        type="password" class="form-control" placeholder="new password" minlength="5"
                                        maxlength="20">
                                </div>
                                <div class="form-group">
                                    <label>Re-Type New Password</label>
                                    <input required value="{{ old('retype_new_password') }}" name="retype_new_password"
                                        type="password" class="form-control" placeholder="re-type new password"
                                        id="confirm_password" minlength="5" maxlength="20">
                                </div>
                                <p id='message'></p>
                            </div>


                            <div class="card-footer">
                                <button id="submit-button" type="submit" class="btn btn-primary">Submit</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection



@section('pagejs')
    <script>
        menu_make_active('setting-changepassword')
    </script>

    <script>
        $("#submit-button").prop("disabled", true);
        $('#password, #confirm_password').on('keyup', function() {
            if ($('#password').val() == $('#confirm_password').val()) {
                $('#message').html('Password Matched').css('color', 'green');
                $("#submit-button").prop("disabled", false);
            } else {
                $('#message').html('Password not match').css('color', 'red');
            }
        });
    </script>
@endsection

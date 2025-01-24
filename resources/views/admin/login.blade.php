<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{$system_name}} login</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="/admin_assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="/admin_assets/dist/css/fw6/css/all.css">
    <link rel="stylesheet" href="/admin_assets/dist/css/adminlte.min.css">
    <link rel="icon" type="image/x-icon" href="/site_images/statics/favicon.jpg">
</head>

<style>
    .login-box,
    .register-box {
        width: 600px;
        max-width: 95%;
    }
</style>



@php

    $login_action_url = route('admin_panel.login.check');

    $user_type = 'Admin';

    $login_guide = "
                <p class='mt-4 mb-1'>
                    'username' => gymforest_admin
                </p>
                <p class='mb-1'>
                    'password' => 44RRAD890abc945
                </p>
                ";

    if (isset($panel_type) && $panel_type == 'member_panel') {
        $login_action_url = route('member_panel.login.check');
        $user_type = 'Member';

        // get a active member username
        $member_username = App\Models\Member::where('status', 'Active')->first()->phone_number ?? null;

        $login_guide = "
                <p class='mt-4 mb-1'>
                    'username' => {$member_username}
                </p>
                <p class='mb-1'>
                    'password' => 123456
                </p>
";
    }
    if (isset($panel_type) && $panel_type == 'trainer_panel') {
        $login_action_url = route('trainer_panel.login.check');
        $user_type = 'Trainer';

        // get a active trainer username
        $trainer_username = App\Models\Trainer::where('status', 'Active')->first()->phone_number ?? null;

        $login_guide = "
                <p class='mt-4 mb-1'>
                    'username' => {$trainer_username}
                </p>
                <p class='mb-1'>
                    'password' => 123456
                </p>
";
    }

@endphp





<body class="hold-transition login-page">
    <div class="login-box">

        <div class="login-logo">
            <a href="#"><b>{{$system_name}}</b> {{ $user_type }} Login</a>
        </div>

        <div class="card">

            @include('admin/partials/helpers/session_alert')

            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <form action="{{ $login_action_url }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" value="" placeholder="Username"
                            name="username">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" value="" placeholder="Password"
                            name="password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Log In</button>
                        </div>
                    </div>
                </form>

                @if (in_array(env('APP_ENV'), ['local', 'demo']))
                    {!! $login_guide !!}
                @endif

            </div>
           
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="/admin_assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="/admin_assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/admin_assets/dist/js/adminlte.min.js"></script>
</body>

</html>

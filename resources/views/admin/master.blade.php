<!DOCTYPE html>
<html lang="en">

@php
    $get_user_role = get_user_role();

    $system_logo = asset('/') . 'site_images/statics/system_logo.png';
    $system_icon = asset('/') . 'site_images/statics/system_icon.jpg';

    use App\Models\ManagementSiteSettings;
    $system_info = ManagementSiteSettings::select('system_icon', 'system_logo', 'system_name')->where('id', 1)->first();

    $system_info_img_folder = asset('/') . 'site_images/uploaded/system_info/';

    $system_logo = 
    $system_info->system_logo ? 
    $system_info_img_folder . $system_info->system_logo : 
    $system_logo;

    $system_icon = 
    $system_info->system_icon ? 
    $system_info_img_folder . $system_info->system_icon : 
    $system_icon;

@endphp

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $system_info->system_name }}</title>

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="icon" type="image/x-icon" href="{{$system_icon}}">

    <link rel="stylesheet" href="/admin_assets/dist/css/fw6/css/all.css">

    <link rel="stylesheet" href="/admin_assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="/admin_assets/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="/admin_assets/dist/css/custom.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('pagecss')
</head>




<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
    <div class="wrapper">
        <div class="preloader flex-column justify-content-center
        align-items-center">
            <img class="animation__shake" src="{{ $system_icon }}" alt="AdminLTELogo" height="60"
                width="60">
        </div>

        @include('admin/partials/topbar/topbar')

        @if ($get_user_role == 'admin' || $get_user_role == 'operator')
            @include('admin/partials/sidebar/sidebar')
        @endif
        @if ($get_user_role == 'member')
            @include('admin/partials/sidebar/member_sidebar')
        @endif
        @if ($get_user_role == 'trainer')
            @include('admin/partials/sidebar/trainer_sidebar')
        @endif
        @if ($get_user_role == 'developer')
            @include('admin/partials/sidebar/dev_sidebar')
        @endif

        <div class="content-wrapper">

            @yield('content')

        </div>

        @include('admin/partials/footer/footer')

    </div>

    <!-- jQuery -->
    <script src="/admin_assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="/admin_assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="/admin_assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/admin_assets/dist/js/adminlte.js"></script>

    <script src="/admin_assets/dist/js/menu_active.js"></script>

    <script src="/admin_assets/dist/js/custom.js"></script>

    @yield('pagejs')


</body>

</html>

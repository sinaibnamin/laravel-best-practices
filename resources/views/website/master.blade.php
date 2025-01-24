<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $system_name }}</title>
    <link rel="stylesheet" href="{{ asset('/website_assets/css/style.css') }}" />
    <link rel="manifest" href="{{ asset('/manifest.json') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('/site_images/statics/favicon.jpg') }}">
</head>

@php
    $d_system_logo = asset('/') . 'site_images/statics/system_logo.png';
    $home_bg = asset('/') . 'site_images/statics/home_page_bg.jpg';

    $system_info_img_folder = asset('/') . 'site_images/uploaded/system_info/';

    $d_system_logo = $system_logo ? $system_info_img_folder . $system_logo : $d_system_logo;

@endphp

<body style="background: url({{$home_bg}})">

    <div class="container">


        <img style="max-width: 100%; max-height:150px;" src="{{ $d_system_logo }}" alt="">
        <h1>Welcome to {{ $system_name }}</h1>

        <div class="buttons">
            <a href="/admin_panel/login" class="admin-login">Admin Login</a>
            <a href="/member_panel/login" class="member-login">Member Login</a>
            <a href="/trainer_panel/login" class="trainer-login">Trainer Login</a>
        </div>
    </div>

    <script>
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/sw.js', {
                    type: 'module'
                })
                .then(registration => {
                    console.log('Service Worker registered with scope:', registration.scope);
                })
                .catch(error => {
                    console.log('Service Worker registration failed:', error);
                });


            navigator.serviceWorker.ready.then(() => {
                console.log('Service Worker is active.');
            });
        }
    </script>

</body>

</html>

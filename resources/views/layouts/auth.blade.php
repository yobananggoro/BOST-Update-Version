<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- {{-- <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon"/> --}} -->
    <!-- {{-- <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/x-icon"/> --}} -->
    <link rel="shortcut icon" href="{{ asset('img/logo.png') }}" />
    <link rel="stylesheet" href="{{ asset('css/app.css', request()->isSecure()) }}">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <style>
        body.login-page {
            background-image: url('{{ asset('img/login_page.jpg') }}');
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            min-height: 50vh;
        }

        .login-box {
            background: rgba(255, 255, 255, 0.92);
            border-radius: 12px;
            box-shadow: 0 16px 50px rgba(0, 0, 0, 0.25);
        }
    </style>

    {{-- <title>@yield('title') :: {{ config('app.name') }}</title> --}}
    <title>@yield('title') :: Back Office</title>
</head>

<body class="login-page">
    <div class="login-box">
        <!-- <div class="login-logo">
            <img src="{{ asset('img/logo.png') }}" alt="" width="140" height="80">
        </div>

        @include('layouts.partials.message') -->

        <div class="card">
            <div class="card-body login-card-body">
                <!-- <h4 class="login-box-msg">{{ config('app.display_name') }}</h4> -->
                <!-- <h4 class="login-box-msg">@yield('title') - bjb Back Office</h4> -->
                <!-- <h4 class="login-box-msg">Selamat Datang</h4> -->
                <br>
                @yield('content')
            </div>

            <div class="card-footer text-center">
                <ul class="list-unstyled" style="font-size: 0.8em">
                    <li>Gunakan User ID dan Password Domain BANKJABAR</li>
                    <hr>
                    <li>Untuk reset password dapat menghubungi IT Help Desk di extension 5101 – 5119</li>
                </ul>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/app.js', request()->isSecure()) }}"></script>
</body>

</html>
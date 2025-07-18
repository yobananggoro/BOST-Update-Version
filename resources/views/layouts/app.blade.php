<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <base href="{{ config('app.url') }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon" />
    <link rel="stylesheet" href="{{ asset('css/app.css', request()->isSecure()) }}">
    <!-- <link rel="stylesheet" href="{{ asset('css/tempusdominus-bootstrap-4.min.css', request()->isSecure()) }}"> -->
    <!-- {!! Assets::Css() !!} -->
    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"> -->

    <title>@yield('title') :: {{ config('app.name') }}</title>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
    <div class="loading-page">
        <div class="loading-content">
            <div class="spinner"></div>
            <h5 class="text-center loading-text">Loading...</h5><br>
        </div>
    </div>
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            @include('layouts.partials.header')
        </nav>
        <aside class="main-sidebar sidebar-light-warning elevation-4">
            @include('layouts.partials.navbar')
        </aside>
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <!-- <h1 class="m-0 text-dark">@yield('title')</h1> -->
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">@yield('title')</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>
            <section class="content">
                <div class="container-fluid">
                    @include('layouts.partials.message')
                    @yield('content')
                </div>
            </section>
        </div>
        <footer class="main-footer">
            @include('layouts.partials.footer')
        </footer>
    </div>

    <script src="{{ asset('js/jquery/jquery.min.js', request()->isSecure()) }}"></script>
    <!-- <script>
        $(function() {
            window.onload = function() {
                let wrapper = document.querySelector('.content.wrapper');
                let zoomFactor = 0.8;
                let originalHeight = 752.047;

                wrapper.style.minHeight = (originalHeight / zoomFactor) + 'px';
            };
        });
    </script> -->
    <script src="{{ asset('js/app.js', request()->isSecure()) }}"></script>
    {!! Assets::js(); !!}
    <!-- <script src="{{ asset('js/manifest.js', request()->isSecure()) }}"></script>
    <script src="{{ asset('js/vendor.js', request()->isSecure()) }}"></script>
    <script src="{{ asset('js/notification.js', request()->isSecure()) }}"></script>
    <script src="{{ mix('js/link.js', request()->isSecure()) }}"></script>
    <script src="{{ asset('js/interbank.js', request()->isSecure()) }}"></script>
    <script src="{{ asset('js/checkDana.js', request()->isSecure()) }}"></script>
    <script src="{{ asset('js/plugins/bs-custom-file-input.js', request()->isSecure()) }}"></script>
    <script src="{{ asset('js/chartil.js/Chart.min.js', request()->isSecure()) }}"></script>
    <script src="{{ asset('js/jquery/jquery.min.js', request()->isSecure()) }}"></script>
    <script src="{{ asset('js/tempusdominus-bootstrap-4.min.js', request()->isSecure()) }}"></script> -->

</body>

</html>
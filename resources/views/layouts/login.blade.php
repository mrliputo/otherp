<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <div class="banner_w3lspvt" id="home">
        <div class="csslider infinity" id="slider1">
            <ul class="banner_slide_bg">
                <li class="csslider-login">
                    <div class="bg1">
                        <div>
                            <div class="banner-text">
                                <div class="container">
                                    <div class="login-box row">
                                        @yield('content')
                                        <div class="col-md-7 col-lg-7 col-sm-12 col-xs-12">
                                            <div class="login-right">
                                                <p>Sistem</p>
                                                <p>Informasi</p>
                                                <p>Monitoring</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</body>
</html>

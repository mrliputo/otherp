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
  <link rel="stylesheet" href="{{ asset('css/main.css') }}">

  <link rel="stylesheet" type="text/css" href="{{ asset('css/chart.css') }}">
  <script type="text/javascript" src="{{ asset('js/chart.js') }}"></script>
</head>
<body>
 <nav class="navbar navbar-midnight-blue">
  <ul class="left-nav">
    <li><a href="{{ route('dashboard') }}">HOME</a></li>
  </ul>
  @include('includes.left-nav')
</nav>

@yield('content')

<!-- Scripts -->
<script src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ asset('js/popper.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
@yield('scripts')
</body>
</html>

@extends('layouts.login')

@section('title', 'Login')

@section('content')
<div class="col-md-5 col-lg-5 col-sm-12 col-xs-12">

    <form method="POST" action="{{ route('login') }}" class="form login">
        @csrf

        <div class="login__header">
            <h3 class="login__title">Selamat Datang</h3>
        </div>

        <div class="login__body">
            <div class="form__field">
                <input id="username" name="username" type="text" placeholder="Username" required autocomplete="username" autofocus value="{{ old('username') }}">
            </div>
            <div class="form__field">
                <input class="no-top" id="password" type="password" placeholder="Password" name="password" required autocomplete="current-password">
            </div>

            @error('username')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror

            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror

        </div>

        <div class="login__footer">
            <input type="submit" value="Login">
            <p>Belum punya akun? <a class="toggle-link" id="sl" href="{{ route('register') }}">Daftar</a></p>
        </div>

    </form>

</div>
@endsection

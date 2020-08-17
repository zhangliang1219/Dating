@extends('layouts.auth')

@section('content')
<style>
    body{
        background-image: url("{{ asset('images/auth-bg.jpg')}}");
        background-position: bottom center;
        background-repeat: no-repeat;
        min-height: 100%;
        background-size: cover;
    }
    html{
        min-height: 100%;
    }
</style>
<div class="container">
    <div class="auth-card">
        <div class="row no-gutters">
            <div class="col-lg-6 auth-logo-part" style='background-image: url("{{ asset('images/auth-image.jpg')}}")'>
                <div class="logo">
                    <a href="{{route('home')}}">
                        <img src="{{ asset('images/logo.png')}}" alt="">
                    </a>
                </div>
                <a href="{{ route('register') }}" class="sign-up-btn">Sign Up</a>
                <div class="sociel-login">
                    <a class="btn btn-theme facebook-btn" href="#">
                        Login with Facebook
                    </a>
                    <a class="btn btn-theme google-btn" href="#">
                        Login with Google
                    </a>
                </div>
            </div>
            <div class="col-lg-6 auth-form-part">
                <div class="auth-form">
                    <h1>{{ trans('sentence.login')}}</h1>
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    @if (session()->has('success'))
                    <div class="alert alert-success" role="alert">
                        <h5>{{ session('success') }}</h5>
                    </div>
                    @endif
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
    
                        <div class="form-group">
                            <label for="email">{{  trans('sentence.email')}}</label>
                            <div class="input-group mb-3 input-group-icon">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                <div class="input-group-append ">
                                    <span class="input-group-text">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                </div>
                            </div>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
    
                        <div class="form-group">
                            <label for="password">{{  trans('sentence.password')}}</label>
                            <div class="input-group mb-3 input-group-icon">
                                <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="current-password">
                                <div class="input-group-append ">
                                    <span class="input-group-text">
                                        <i class="fas fa-unlock"></i>
                                    </span>
                                </div>
                            </div>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
    
                        <div class="form-group">
                            <button type="submit" class="btn btn-theme btn-block">
                                {{ trans('sentence.login')}}
                            </button>
                        </div>
                        <div class="form-group mb-0 text-center">
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{  trans('sentence.forgot_your_password')}}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
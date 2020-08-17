@extends('layouts.auth')
@php
    $gender = trans('sentence.gender');
    $preferred_age = config('constant.preferred_age');
    $ethnicity = config('constant.ethnicity');
    $height = config('constant.height');
    $weight = config('constant.weight');
    $build = trans('sentence.build_array');
    $relationship =  trans('sentence.relationship_array');
    $living_arrangement = trans('sentence.living_arrangement_array');
    $employment_status = trans('sentence.employment_status_array');
    $education = trans('sentence.education_array');
    $children = trans('sentence.children_array');
@endphp
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
@section('content')
<div class="container">
    <div class="auth-card">
        <div class="row no-gutters">
            <div class="col-lg-6 auth-logo-part" style='background-image: url("{{ asset('images/auth-image.jpg')}}")'>
                <div class="logo">
                    <a href="{{route('home')}}">
                        <img src="{{ asset('images/logo.png')}}" alt="">
                    </a>
                </div>
                <a href="{{ route('login') }}" class="sign-up-btn">Login</a>
                <div class="sociel-login">
                    <a class="btn btn-theme facebook-btn" href="{{ route('social-redirect','facebook') }}">
                        Login with Facebook
                    </a>
                    <a class="btn btn-theme google-btn" href="{{ route('social-redirect','google') }}">
                        Login with Google
                    </a>
                </div>
            </div>
            <div class="col-lg-6 auth-form-part">
                <div class="auth-form">
                    <h1>{{ trans('sentence.register')}}</h1>
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
                    <form method="POST" action="{{ route('front-register') }}" enctype="multipart/form-data" id="register_form">
                        @csrf
                        <h4>{{ trans('sentence.personal_info')}}</h4><br>
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="firstName">{{ trans('sentence.first_name')}}</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" value="{{old('first_name')}}"
                                       placeholder="{{ trans('sentence.enter').' '.trans('sentence.first_name')}}"  >
                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-6">
                                <label for="lastName">{{ trans('sentence.last_name')}}</label>
                                <input type="text" class="form-control" id="last_name" placeholder="{{ trans('sentence.enter').' '.trans('sentence.last_name')}}" 
                                       name="last_name" value="{{old('last_name')}}">
                                @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="dob">{{ trans('sentence.dob')}}</label>
                                <input type="text" class="form-control" id="dob" name="dob"  placeholder="{{ trans('sentence.enter').' '.trans('sentence.dob')}}" 
                                       value="{{old('dob')}}">
                                @error('dob')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-6">
                                <label for="email">{{ trans('sentence.email')}}</label>
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}"  autocomplete="email" placeholder="{{ trans('sentence.enter').' '.trans('sentence.email')}}">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label>{{trans('sentence.photo_id')}}</label>
                                <div class="input-group">
                                  <div class="custom-file">
                                      <input type="file" class="custom-file-input " id="photo_id" name="photo_id">
                                    <label class="custom-file-label" for="photo_id"  id="uploadedFileName">Choose file</label>
                                  </div>
                                </div>
                            </div>
                            <div class="form-group col-6">
                                <label for="gender" >{{trans('sentence.your_gender')}}</label>
                                <select name="gender" class="form-control">
                                    <option value="">{{ trans('sentence.select').' '.trans('sentence.your_gender')}}</option>
                                    @foreach($gender as $key => $val)
                                        <option value="{{$key}}" {{old('gender') == $key?'selected':''}}>{{$val}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('gender'))
                                    <div class="error">{{ $errors->first('gender') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="password" >{{trans('sentence.password')}}</label>
                                <input id="password" type="password" class="form-control" name="password"  autocomplete="new-password" value="{{ old('password') }}"
                                       placeholder="{{ trans('sentence.enter').' '.trans('sentence.password')}}">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group  col-6">
                                <label for="password-confirm"  >{{trans('sentence.confirm_password')}}</label>
                                    <input id="password-confirm" type="password" class="form-control "  placeholder="{{ trans('sentence.enter').' '.trans('sentence.confirm_password')}}"
                                           name="password_confirmation"  autocomplete="new-password"  value="{{ old('password_confirmation') }}">
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{trans('sentence.register')}}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('javascript')
<script type="text/javascript">
$(document).ready(function(){
    $('input[type="file"]').change(function(e){
            var fileName = e.target.files[0].name;
            $('#uploadedFileName').text(fileName);
    });
});
</script>

<script src="{{ asset('js/front_user.js') }}"></script>
@endsection
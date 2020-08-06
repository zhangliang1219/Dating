@extends('layouts.final')
@php
<<<<<<< HEAD
    $gender = trans('sentence.gender');
    $preferred_age = config('constant.preferred_age');
    $height = config('constant.height');
    $weight = config('constant.weight');
    $education = trans('sentence.education_array');
    $employment_status = trans('sentence.employment_status_array');
    $living_arrangement = trans('sentence.living_arrangement_array');
    $ethnicity = config('constant.ethnicity');
=======
$gender = trans('sentence.gender');
$preferred_age = config('constant.preferred_age');
$height = config('constant.height');
$weight = config('constant.weight');
>>>>>>> 4c5e87d62e4e89c53c8675f2d39128aab9cc21ea
@endphp
@section('content')
<div class="page-header-title">
    <div class="header-background"></div>
    <div class="inner-header">
        <div class="container">
            <div class="title-section">
                <h2>Profile</h2>
                <div class="breadcrumbs">
                    <ul>
                        <li><a href="">Home ></a></li>
                        <li>Profile</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="profile-header">
        <div class="profile-header-image" style="background-image:url('{{ asset('images/profile-default.jpg')}}')">
            <div class="edit-btn">
                <ion-icon name="create-outline"></ion-icon>
            </div>
            <div class="social-media">
                <a class="facebook" href="">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a class="twitter" href="">
                    <i class="fab fa-twitter"></i>
                </a>
                <a class="linkedin" href="">
                    <i class="fab fa-linkedin-in"></i>
                </a>
            </div>
        </div>
        <div class="profile-details">
            <div class="profile-user">
                <div class="user-image">
                    <img src="{{ asset('images/profile-default.jpg')}}" alt="">
                    <div class="edit-btn">Edit</div>
                </div>
                <div class="user-details">
                    <h3>Sarika Parmar</h3>
                    <h5>33 year old Woman</h5>
                    <h6><i class="fas fa-map-marker-alt"></i> Tokyo, Japan</h6>
                </div>
            </div>
            <div class="likes">
                <h3>121</h3>
                <h6>Number of Likes</h6>
            </div>
        </div>
        <div class="images-upload">
            <div class="profile-header-title">
                <h3>About Upload Photo</h3>
                <button>
                    <ion-icon name="create-outline"></ion-icon>
                </button>
            </div>
            <div class="images-slider">
                <div class="swiper-container swiper-container-1">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="slider-image">
                                <img src="{{ asset('images/profile/pexels-rafael-barros-1996887.jpg') }}" alt="">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="slider-image">
                                <img src="{{ asset('images/profile/pexels-rafael-barros-1996887.jpg') }}" alt="">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="slider-image">
                                <img src="{{ asset('images/profile/pexels-rafael-barros-1996887.jpg') }}" alt="">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="slider-image">
                                <img src="{{ asset('images/profile/pexels-rafael-barros-1996887.jpg') }}" alt="">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="slider-image">
                                <img src="{{ asset('images/profile/pexels-rafael-barros-1996887.jpg') }}" alt="">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="slider-image">
                                <img src="{{ asset('images/profile/pexels-rafael-barros-1996887.jpg') }}" alt="">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="slider-image">
                                <img src="{{ asset('images/profile/pexels-rafael-barros-1996887.jpg') }}" alt="">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="slider-image">
                                <img src="{{ asset('images/profile/pexels-rafael-barros-1996887.jpg') }}" alt="">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="slider-image">
                                <img src="{{ asset('images/profile/pexels-rafael-barros-1996887.jpg') }}" alt="">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="slider-image">
                                <img src="{{ asset('images/profile/pexels-rafael-barros-1996887.jpg') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"></div>
                <div class="card-body">
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
                    <form class="form-horizontal" method="post" action="{{route('viewSearchProfile')}}"
                        name="search_profile" id="search_profile">
                        @csrf
                        <div class="card-body">
                            <div class="form-group col-4">
                                <input type="text" name="age"  class="form-control"  placeholder="{{ trans('sentence.enter').' '.trans('sentence.age')}}">
                            </div>
                            <div class="form-group col-4">
                                <select name="height" class="form-control" >
                                    <option value="">{{ trans('sentence.height')}}</option>
                                    @foreach($height as $key => $val)
                                        <option value="{{$key}}">{{$val}}</option>
                                    @endforeach
                                </select> 
                            </div>
                            <div class="form-group col-4">
                                <select name="weight" class="form-control" >
                                    <option value="">{{ trans('sentence.weight')}}</option>
                                    @foreach($weight as $key => $val)
                                        <option value="{{$key}}">{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-4">
                                <input type="text" name="city"  class="form-control" placeholder="{{ trans('sentence.enter').' '.trans('sentence.city')}}">
                            </div>
                            <div class="form-group col-4">
                                <input type="text"   id="state" name="state" class="form-control"   placeholder="{{ trans('sentence.enter').' '.trans('sentence.state')}}">
                            </div>
                            <div class="form-group col-4">
                                <select name="country" class="form-control" >
                                    <option value="">{{ trans('sentence.country')}}</option>
                                    @foreach($country as $key => $val)
                                    <option value="{{$val->id}}">{{$val->country_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-4">
                                <select name="education" class="form-control">
                                    <option value="">{{trans('sentence.education')}}</option>
                                    @foreach($education as $key => $val)
                                        <option value="{{$key}}" >{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-4">
                                <select name="employment_status" class="form-control" >
                                    <option value="">{{trans('sentence.employee')}}</option>
                                    @foreach($employment_status as $key => $val)
                                        <option value="{{$key}}">{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-4">
                                <select name="ethnicity" class="form-control" id="ethnicity">
                                    <option value="">{{trans('sentence.ethnicity')}}</option>
                                    @foreach($ethnicity as $key => $val)
                                    <option value="{{$key}}" >{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-4">
                                <select name="living_arrangement" class="form-control">
                                    <option value="">{{trans('sentence.living_arrangement')}}</option>
                                    @foreach($living_arrangement as $key => $val)
                                        <option value="{{$key}}" >{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary" name="profile_search">
                                    {{ trans('sentence.find_your_partner')}}
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
<script src="{{ asset('js/front_contact_us.js') }}"></script>
@endsection
@extends('layouts.final')
@php
    $gender = trans('sentence.gender');
    $preferred_age = config('constant.preferred_age');
    $height = config('constant.height');
    $weight = config('constant.weight');
    $education = trans('sentence.education_array');
    $employment_status = trans('sentence.employment_status_array');
    $living_arrangement = trans('sentence.living_arrangement_array');
    $ethnicity = config('constant.ethnicity');
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
    <div class="row">
        <div class="col-md-8">
            <div class="profile-tabs">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Profile</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Matches</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Membership</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="contact1-tab" data-toggle="tab" href="#contact1" role="tab" aria-controls="contact1" aria-selected="false">Schedule Counseling</a>
                      </li>
                  </ul>
                  <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="profile-header-title">
                            <h3>About me</h3>
                            <button>
                                <ion-icon name="create-outline"></ion-icon>
                            </button>
                        </div>
                        <p>The Best Solution For Your Business Website. Creative & Interaction Design | Social Media Management | Software Development | Website Designing | Graphic Design | WordPress Theme | Logo Design + Branding | SEO | App Development (</p>
                        <div class="profile-header-title">
                            <h3>Basic general information</h3>
                            <button>
                                <ion-icon name="create-outline"></ion-icon>
                            </button>
                        </div>
                        <div class="row user-details-table">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-6">
                                        Gender
                                    </div>
                                    <div class="col-6">
                                        Female
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        Age
                                    </div>
                                    <div class="col-6">
                                        22 Years old
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        Country
                                    </div>
                                    <div class="col-6">
                                        France
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        City
                                    </div>
                                    <div class="col-6">
                                        Paris
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        Birthday
                                    </div>
                                    <div class="col-6">
                                        15 July 1997
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        Relationship
                                    </div>
                                    <div class="col-6">
                                        Single
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        Height
                                    </div>
                                    <div class="col-6">
                                        5.7
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        Weight
                                    </div>
                                    <div class="col-6">
                                        56
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-6">
                                        Gender
                                    </div>
                                    <div class="col-6">
                                        Female
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        Age
                                    </div>
                                    <div class="col-6">
                                        22 Years old
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        Country
                                    </div>
                                    <div class="col-6">
                                        France
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        City
                                    </div>
                                    <div class="col-6">
                                        Paris
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        Birthday
                                    </div>
                                    <div class="col-6">
                                        15 July 1997
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        Relationship
                                    </div>
                                    <div class="col-6">
                                        Single
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        Height
                                    </div>
                                    <div class="col-6">
                                        5.7
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        Weight
                                    </div>
                                    <div class="col-6">
                                        56
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="users-listing-card">
                                    <a class="link-profile" href="#"></a>
                                    <div class="image-section">
                                        <div class="user-img">
                                            <img src="{{ asset('images/profile-default.jpg')}}" alt="">
                                        </div>
                                        <div class="age-group">
                                            33 year old Woman
                                        </div>
                                        <div class="online"></div>
                                    </div>
                                    <div class="details-section">
                                        <h3>Sarika Parmar</h3>
                                        <h4>Bilaspur, India</h4>
                                        <h5>85% Match</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="users-listing-card">
                                    <a class="link-profile" href="#"></a>
                                    <div class="image-section">
                                        <div class="user-img">
                                            <img src="{{ asset('images/profile-default.jpg')}}" alt="">
                                        </div>
                                        <div class="age-group">
                                            33 year old Woman
                                        </div>
                                        <div class="online"></div>
                                    </div>
                                    <div class="details-section">
                                        <h3>Sarika Parmar</h3>
                                        <h4>Bilaspur, India</h4>
                                        <h5>85% Match</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="users-listing-card">
                                    <a class="link-profile" href="#"></a>
                                    <div class="image-section">
                                        <div class="user-img">
                                            <img src="{{ asset('images/profile-default.jpg')}}" alt="">
                                        </div>
                                        <div class="age-group">
                                            33 year old Woman
                                        </div>
                                        <div class="online"></div>
                                    </div>
                                    <div class="details-section">
                                        <h3>Sarika Parmar</h3>
                                        <h4>Bilaspur, India</h4>
                                        <h5>85% Match</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="users-listing-card">
                                    <a class="link-profile" href="#"></a>
                                    <div class="image-section">
                                        <div class="user-img">
                                            <img src="{{ asset('images/profile-default.jpg')}}" alt="">
                                        </div>
                                        <div class="age-group">
                                            33 year old Woman
                                        </div>
                                        <div class="online"></div>
                                    </div>
                                    <div class="details-section">
                                        <h3>Sarika Parmar</h3>
                                        <h4>Bilaspur, India</h4>
                                        <h5>85% Match</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pagination-container">
                            <ul class="pagination">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                        <ion-icon name="arrow-back-outline"></ion-icon>
                                    </a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item active" aria-current="page">
                                    <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#">
                                        <ion-icon name="arrow-forward-outline"></ion-icon>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
                    <div class="tab-pane fade" id="contact1" role="tabpanel" aria-labelledby="contact1-tab">...</div>
                  </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="custom-card">
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
                        <div class="form-group">
                            <input type="text" name="age"  class="form-control"  placeholder="{{ trans('sentence.enter').' '.trans('sentence.age')}}">
                        </div>
                        <div class="form-group">
                            <select name="height" class="form-control" >
                                <option value="">{{ trans('sentence.height')}}</option>
                                @foreach($height as $key => $val)
                                    <option value="{{$key}}">{{$val}}</option>
                                @endforeach
                            </select> 
                        </div>
                        <div class="form-group">
                            <select name="weight" class="form-control" >
                                <option value="">{{ trans('sentence.weight')}}</option>
                                @foreach($weight as $key => $val)
                                    <option value="{{$key}}">{{$val}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" name="city"  class="form-control" placeholder="{{ trans('sentence.enter').' '.trans('sentence.city')}}">
                        </div>
                        <div class="form-group">
                            <input type="text"   id="state" name="state" class="form-control"   placeholder="{{ trans('sentence.enter').' '.trans('sentence.state')}}">
                        </div>
                        <div class="form-group">
                            <select name="country" class="form-control" >
                                <option value="">{{ trans('sentence.country')}}</option>
                                @foreach($country as $key => $val)
                                <option value="{{$val->id}}">{{$val->country_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <select name="education" class="form-control">
                                <option value="">{{trans('sentence.education')}}</option>
                                @foreach($education as $key => $val)
                                    <option value="{{$key}}" >{{$val}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <select name="employment_status" class="form-control" >
                                <option value="">{{trans('sentence.employee')}}</option>
                                @foreach($employment_status as $key => $val)
                                    <option value="{{$key}}">{{$val}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <select name="ethnicity" class="form-control" id="ethnicity">
                                <option value="">{{trans('sentence.ethnicity')}}</option>
                                @foreach($ethnicity as $key => $val)
                                <option value="{{$key}}" >{{$val}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <select name="living_arrangement" class="form-control">
                                <option value="">{{trans('sentence.living_arrangement')}}</option>
                                @foreach($living_arrangement as $key => $val)
                                    <option value="{{$key}}" >{{$val}}</option>
                                @endforeach
                            </select>
                        </div>
                    <div class="form-group mb-0">
                        <button type="submit" class="btn btn-primary" name="profile_search">
                            {{ trans('sentence.find_your_partner')}}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('javascript')
<script src="{{ asset('js/front_contact_us.js') }}"></script>
@endsection
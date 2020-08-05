@extends('layouts.final')
@php
$gender = trans('sentence.gender');
$preferred_age = config('constant.preferred_age');
$height = config('constant.height');
$weight = config('constant.weight');
@endphp
@section('content')
<div class="page-header-title">
    <div class="header-background"></div>
    <div class="inner-header">
        <div class="container">
            <div class="title-section">
                <h2>My Profile</h2>
                <div class="breadcrumbs">
                    <ul>
                        <li><a href="">Home ></a></li>
                        <li>My Profile</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="single-user-profile">
        <div class="slider">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <img src="{{ asset('images/profile/pexels-rafael-barros-1996887.jpg') }}" alt="">
                    </div>
                    <div class="swiper-slide">
                        <img src="{{ asset('images/profile/pexels-rafael-barros-2130795.jpg') }}" alt="">
                    </div>
                    <div class="swiper-slide">
                        <img src="{{ asset('images/profile/pexels-rafael-barros-2608333.jpg') }}" alt="">
                    </div>
                </div>
                <div class="swiper-buttons">
                    <div class="btn-swiper-prev">
                        <ion-icon name="chevron-back-outline"></ion-icon>
                    </div>
                    <div class="btn-swiper-next">
                        <ion-icon name="chevron-forward-outline"></ion-icon>
                    </div>
                </div>
            </div>
        </div>
        <div class="user-details">
            <div class="user-header">
                <h2>Shalok Thakur , 22</h2>
                <h4>23 kilometers away</h4>
                <h5>Aurangābād , India</h5>
            </div>
            <div class="desc">
                I still fanboy over 5 seconds of Summer and Neighborhood. (Probably waiting for someone to sing 'Looks
                so
                perfect'me). Invests my time in sleeping intellectual/psychological mindfuck movies (watched
            </div>
            <div class="action">
                <a href="" class="btn btn-theme">Match</a>
                <a href="" class="btn btn-theme-outline">Messages</a>
            </div>
        </div>

    </div>
</div>
<div class="container">

</div>
@endsection
@section('javascript')
@endsection
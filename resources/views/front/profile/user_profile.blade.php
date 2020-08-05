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
        <div class="profile-header-image">
            <div class="image" style="background-image:url('{{ asset('css/images/profile-default.jpg')}}')">
                <div class="edit-btn">

                </div>
            </div>
            
        </div>
        <div class="profile-details">
            <div class="profile-user">
                <div class="user-image">
                    <img src="{{ asset('css/images/profile-default.jpg')}}" alt="">
                </div>
                <div class="user-details">
                    <h3>Sarika Parmar</h3>
                    <h5>33 year old Woman</h5>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    
</div>
@endsection
@section('javascript')
@endsection
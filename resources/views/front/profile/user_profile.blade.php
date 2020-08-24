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
                        <li><a href="{{route('home')}}">Home ></a></li>
                        <li>My Profile</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class='profile_detail'>
        @include('front.profile.single_user_profile_html')
    </div>
    <input type="hidden" class="searchIdArray" id='serachIdArray' value="{{json_encode($searchIdArray)}}">
</div>

@endsection
@section('javascript')
<script src="{{ asset('js/front_my_profile.js?'.time()) }}"></script>
@endsection
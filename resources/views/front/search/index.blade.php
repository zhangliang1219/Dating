@extends('layouts.final')
@php
$gender = trans('sentence.gender');
$preferred_age = config('constant.preferred_age');
@endphp
@section('content')
<div class="page-header-title">
    <div class="header-background"></div>
    <div class="inner-header">
        <div class="container">
            <form class="search-bar-form" action="{{url('search/profile')}}" method="get">
                <div class="search-bar">
                    <input type="text" placeholder="Search...." name='profile_search_text' value="{{$request->profile_search_text}}">
                    <button type="submit" value="1" name="profile_search">
                        <ion-icon name="search-outline"></ion-icon>
                    </button>
                </div>
                <button class="fliter-button">
                    <ion-icon name="filter-outline"></ion-icon>
                </button>
            </form>
        </div>
    </div>
</div>
<div class="container">
    <div class="serach-result-header">
        @if(isset($request->profile_search) && $request->profile_search_text != '')
            <h3 class="searched-text">Search text [{{$request->profile_search_text}}]</h3>
        @endif
    </div>
    <div class="result-sort-bar">
        <h5>
            @if(count($searchProfile)>0)
                Showing {{ $searchProfile->firstItem() }} to {{ $searchProfile->lastItem() }} of total {{$searchProfile->total()}} entries
            @endif
        </h5>
        <form >
            <select class="custom-select">
                <option selected>Search By Match%</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
            </select>
        </form>
    </div>
    <div class="row">
        @if(count($searchProfile)>0)
            @foreach($searchProfile as $val)
            <div class="col-md-4">
                <div class="users-listing-card">
                    <a class="link-profile" href="{{route('userProfile',$val->id)}}"></a>
                    <div class="image-section">
                        <div class="user-img">
                            <img src="{{($val->photo != '')?asset('images/profile/'.$val->photo):asset('images/profile-default.jpg')}}" alt="">
                        </div>
                        <div class="age-group">
                            {{$val->age}} year old {{($val->gender != '')?$gender[$val->gender]:''}}
                        </div>
                        @if($val->login_status == 1)
                            <div class="online"></div>
                        @endif
                    </div>
                    <div class="details-section">
                        <h3>{{$val->name}}</h3>
                        <h4>{{$val->state.($val->countryData?','.$val->countryData->country_name:'')}}</h4>
                        <h5>85% Match</h5>
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <h3>No Data Found</h3>
        @endif
    </div>
    @if($searchProfile && !empty($searchProfile))
        <div class="pagination-container">
            {!! $searchProfile->appends(\Request::except('page'))->render() !!}
        </div>
    @endif
    
</div>
@endsection
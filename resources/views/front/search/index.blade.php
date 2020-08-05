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
            <form class="search-bar-form" action="">
                <div class="search-bar">
                    <input type="text" placeholder="Search....">
                    <button type="submit">
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
        <h3 class="searched-text">Search text [Sarika Parmar]</h3>
    </div>
    <div class="result-sort-bar">
        <h5>Showing 1- 11 of 120 products</h5>
        <form action="">
            <select class="custom-select">
                <option selected>Open this select menu</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
            </select>
        </form>
    </div>
    <div class="row">
        <div class="col-md-4">
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
        <div class="col-md-4">
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
        <div class="col-md-4">
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
        <div class="col-md-4">
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
        <div class="col-md-4">
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
        <div class="col-md-4">
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
                    @if(count($searchProfile)>0)
                        <p class="mt-1">Showing {{ $searchProfile->firstItem() }} to {{ $searchProfile->lastItem() }} of total {{$searchProfile->total()}} entries</p>
                    @endif
                    <div class="row">
                        @if(count($searchProfile)>0)
                            @foreach($searchProfile as $val)
                                <div class="col-4">
                                    {{$val->name}}<br>
                                    {{$val->state.','.$val->country}}
                                </div>
                            @endforeach
                        @else
                        <h3>No Data Found</h3>
                        @endif
                    </div>
                    @if($searchProfile && !empty($searchProfile))
                        <div class="pt-4">{!! $searchProfile->appends(\Request::except('page'))->render() !!}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
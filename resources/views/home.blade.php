@extends('layouts.final')

@section('content')
    <div class="homepage-page">
        <div class="hero-section">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="header-img">
                            <img class="fluid-image" src="{{ asset('/images/homepage-header-hero.png') }}" alt="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="header-content">
                            <h4>awesome dating</h4>
                            <div class="main-heading">
                                <h2>Dating <b>Batter</b></h2>
                                <h2><b>Than Ever</b></h2>
                                <h2>Before</h2>
                            </div>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has
                                been the industry's standard dummy text ever since the 1500s, when an unknown printer took a
                                galley of type and scrambled it to make a type specimen book. </p>
                            <a href="#" class="btn btn-theme-outline">Details</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="home-search">
                <form class="form-inline justify-content-center">
                    <label class="mr-3 my-2">I am a</label>
                    <select class="custom-select my-2 mr-sm-2">
                        <option selected>Man Looking a woman</option>
                        <option value="1">Woman Looking a Man</option>
                    </select>
                    <label class="mr-3 my-2">Between Ages</label>
                    <div class="mr-3 my-4">
                        <input class="range-slider" type="hidden" value="20,30" />
                    </div>
                    <button type="submit" class="btn btn-theme-outline my-2">Take a Change</button>
                </form>
            </div>
        </div>
        <div class="container">
            <div class="home-headings">
                <h2>Welcome to this <b>great invention</b> of Doctor Love!</h2>
                <div class="divider">
                    <img src="{{ asset('/images/divider.png') }}" alt="">
                </div>
                <p>This theme extends default WordPress profiles. User can edit profile fields, upload photos, add
                    favorites, view gifts and read messages, edit privacy settings without even seeing .
                </p>
            </div>
            <div class="love-calculater-container">
                <div class="love-calculater">
                    <div class="form-group">
                        <label>Your Name</label>
                        <input type="text" class="form-control" placeholder="">
                    </div>
                    <div class="divider-first"></div>
                    <div class="calc-circle">
                        <div class="calc-circle-inner">
                            <h2>95%</h2>
                        </div>
                    </div>
                    <div class="divider-second"></div>
                    <div class="form-group">
                        <label>Your Crush</label>
                        <input type="text" class="form-control" placeholder="">
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-theme-outline">Calculate love</button>
                </div>

            </div>
        </div>
        <div class="container mb-5">
            <div class="home-headings">
                <h2>Welcome <b>To Long</b> Life</h2>
                <div class="divider">
                    <img src="{{ asset('/images/divider.png') }}" alt="">
                </div>
                <p>This theme extends default WordPress profiles. User can edit profile fields, upload photos, add
                    favorites, view gifts and read messages, edit privacy settings without even seeing .
                </p>
            </div>
            <div class="row mt-2">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="feture-card">
                        <img src="{{ asset('/images/home-icon-1.png') }}" alt="">
                        <h3>32,786</h3>
                        <h2>Members in total</h2>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="feture-card">
                        <img src="{{ asset('/images/home-icon-2.png') }}" alt="">
                        <h3>2507</h3>
                        <h2>Active Members </h2>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="feture-card">
                        <img src="{{ asset('/images/home-icon-3.png') }}" alt="">
                        <h3>2507</h3>
                        <h2>Women</h2>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="feture-card">
                        <img src="{{ asset('/images/home-icon-4.png') }}" alt="">
                        <h3>2507</h3>
                        <h2>Men</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('javascript')
    <style>
        body {
            background-image: url('../images/homepage-bg.png');
            background-color: #fffdfd;
            background-size: 100%;
            padding-top: 100px;
            background-repeat: repeat;
        }
        @media screen and (max-width:991px) {
            body{
                background-image: none;
            }
        }
    </style>
    <script>
        $('.range-slider').jRange({
            from: 0,
            to: 75,
            step: 1,
            //scale: [0, 25, 50, 75, 100],
            format: '%s',
            width: 300,
            showLabels: true,
            isRange: true
        });

    </script>
@endsection

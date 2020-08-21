@extends('layouts.final')
@php
    $gender = trans('sentence.gender');
    $state = trans('sentence.state');
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
    $user_info_privacy = trans('sentence.user_info_privacy');
     
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
            <div class="profile-header-image" style="background-image:url('{{ isset($userInfo->profile_banner)?asset('images/profile_banner/'.$userInfo->profile_banner):asset('images/profile-default.jpg')}}')">
                <input type="file" name="user-banner-img" class="user-banner-img" style="display:none;" id="user-banner-img" accept='image/*'>
                <div class="edit-btn edit-user-banner">
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
                        <img src="{{isset($user->photo) && ($user->photo != '')? asset('images/profile/'.$user->photo):asset('images/profile-default.jpg')}}" alt="" id="profile_img">
                        <input type="file" name="user-profile-img" class="user-profile-img" style="display:none;" id="user-profile-img" accept='image/*'>
                    <div class="edit-btn" id="editUserProfile">Edit</div>
                </div>
                <div class="user-details">
                    <h3>{{(Auth::user()?Auth::user()->first_name.' '.Auth::user()->last_name:'')}}</h3>
                    <h5>{{Auth::user()?Auth::user()->age:''}} year old {{Auth::user() && Auth::user()->gender != '' ?$gender[Auth::user()->gender]:''}}</h5>
                    <h6><i class="fas fa-map-marker-alt"></i> {{Auth::user()?(Auth::user()->city.(Auth::user()->country != ''?', '.$country[Auth::user()->country]->country_name:'')):''}}</h6>
                </div>
            </div>
            <div class="likes">
                @php
                    $percentages = 0;
                    $percentages = ((Auth::user()->id_verify != '')?config('constant.id_verification'):0)+ 
                                    ((Auth::user()->email_verify != '')?config('constant.email_verification'):0) +
                                    ((Auth::user()->phone_verify != '')?config('constant.phone_verification'):0)+
                                    ((Auth::user()->wish_to_meet != '')?config('constant.profile_verification'):0)
                @endphp
                <h3>{{$percentages.'%'}}</h3>
                <h6>Profile Verified</h6>
            </div>
            <div class="likes">
                <h3>00</h3>
                <h6>Number of Likes</h6>
            </div>
        </div> 
        <div class="images-upload">
            <div class="profile-header-title">
                <h3>{{ trans('sentence.about_upload_photo')}}</h3>
                <button class='profile_photos' id='profile_photos'>
                    <ion-icon name="create-outline"></ion-icon>
                </button>
            </div>
            <div class="images-slider">
                <div class="swiper-container swiper-container-1">
                    <div class="swiper-wrapper">
                        @if(count($userPhoto)>0)
                            @foreach($userPhoto as $val)
                                <div class="swiper-slide">
                                    <div class="slider-image">
                                        <img src="{{ asset('images/profile_gallery_photo/'.$val['photo_name']) }}" alt="">
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div><h5>No Photos</h5></div>
                        @endif
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
                      <a class="nav-link {{(isset($request->page) && $request->page != '')?'':'active'}}" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">
                          {{ trans('sentence.profile')}}</a>
                    </li>
                    @if(Auth::user() && Auth::user()->id_verify == 1 && Auth::user()->email_verify == 1 && Auth::user()->phone_verify == 1)
                        <li class="nav-item">
                          <a class="nav-link  {{(isset($request->page) && $request->page != '')?'active':''}}" id="match-tab" data-toggle="tab" href="#match" role="tab" aria-controls="match" aria-selected="false">
                              {{ trans('sentence.matches')}}</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">
                              {{ trans('sentence.membership')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="contact1-tab" data-toggle="tab" href="#contact1" role="tab" aria-controls="contact1" aria-selected="false">
                                {{ trans('sentence.schedule_counseling')}}</a>
                        </li>
                    @else
                        <li class="nav-item">
                          <a class="nav-link" id="phone-verify-tab" data-toggle="tab" href="#phone_verify" role="tab" aria-controls="phone_verify" aria-selected="false">
                              {{ trans('sentence.phone_verification')}}</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="doc-tab" data-toggle="tab" href="#document_verify" role="tab" aria-controls="document_verify" aria-selected="false">
                              {{ trans('sentence.doc_verification')}}</a>
                        </li>
                    @endif
                  </ul>
                  <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade {{(isset($request->page) && $request->page != '')?'':' show active'}}" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class='about_me'>
                            <div class="profile-header-title">
                                <h3>{{ trans('sentence.about_me')}}</h3>
                                <button id="about_me_edit">
                                    <ion-icon name="create-outline"></ion-icon>
                                </button>
                            </div>
                            <div class="profile_about_me_wrap"  style="display: none">
                                    <form method="POST" action="{{route('profileAboutMeUpload')}}" name="about_me_form">
                                    @csrf
                                    <textarea name="profile_about_me_txt" id="profile_about_me_txt" class="profile_about_me_txt" rows="5" cols="80"
                                              placeholder="please Enter About Me Text...">{{isset($userInfo->about_me)?$userInfo->about_me:''}} </textarea>
                                    <button type="submit" value="about_me_submit" class="btn btn-primary" >Submit</button> 
                                </form>
                            </div>
                            <p class="profile_about_me_text">{{isset($userInfo->about_me)?$userInfo->about_me:'please Enter About Me Text Here...'}}</p>
                            <br>
                        </div>
                                        
                        <div class="profile-header-title">
                            <h3>{{ trans('sentence.basic_general_information')}}</h3>
                            <button class="general_info_edit">
                                <ion-icon name="create-outline"></ion-icon>
                            </button>
                        </div>
                        <div class="row user-details-table">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-6">
                                       {{trans('sentence.your_gender')}}
                                    </div>
                                    <div class="col-6">
                                        {{($user && $user->gender != '')?$gender[$user->gender]:'-'}} 
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        {{trans('sentence.age')}}
                                    </div>
                                    <div class="col-6">
                                        {{($user && $user->age != '')?$user->age .' Years old':'-'}} 
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        {{trans('sentence.country')}}
                                    </div>
                                    <div class="col-6">
                                       {{($user && $user->country != '')?$country[$user->country]->country_name:'-'}} 
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        {{trans('sentence.city')}}
                                    </div>
                                    <div class="col-6">
                                        {{($user && $user->city != '')?$user->city:'-'}} 
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        {{trans('sentence.birthday')}}
                                    </div>
                                    <div class="col-6">
                                        {{($user && $user->dob != '')?date("d-M-Y", strtotime($user->dob)):''}} 
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        {{trans('sentence.relationship')}}
                                    </div>
                                    <div class="col-6">
                                        {{($user && $user->relationship != '')?$relationship[$user->relationship]:'-'}} 
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        {{trans('sentence.height')}}
                                    </div>
                                    <div class="col-6">
                                        {{($user && $user->height != '')?$height["$user->height"]:'-'}} 
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        {{trans('sentence.weight')}}
                                    </div>
                                    <div class="col-6">
                                        {{($user && $user->weight != '')?$user->weight:'-'}} 
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        {{trans('sentence.preferred_height')}}
                                    </div>
                                    <div class="col-6">
                                        {{($userInfo)?$userInfo->preferred_min_height.'-'.$userInfo->preferred_max_height.' ft':'-'}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-6">
                                        {{trans('sentence.education')}}
                                    </div>
                                    <div class="col-6">
                                       {{($user && $user->education != '')?$education[$user->education]:'-'}} 
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        {{trans('sentence.wish_to_meet')}}
                                    </div>
                                    <div class="col-6">
                                        {{($user && $user->wish_to_meet != '')?$gender[$user->wish_to_meet]:'-'}} 
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        {{trans('sentence.living_arrangement')}}
                                    </div>
                                    <div class="col-6">
                                        {{($user && $user->living_arrangement != '')?$living_arrangement[$user->living_arrangement]:'-'}}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        {{trans('sentence.employee')}}
                                    </div>
                                    <div class="col-6">
                                        {{($user && $user->employment_status != '')?$employment_status[$user->employment_status]:'-'}}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        {{trans('sentence.children')}}
                                    </div>
                                    <div class="col-6">
                                        {{($user && $user->children != '')?$children[$user->children]:'-'}}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        {{trans('sentence.ethnicity')}}
                                    </div>
                                    <div class="col-6">
                                        {{($user && $user->ethnicity != '')?($user->ethnicity == 10?$user->ethnicity_other:$ethnicity[$user->ethnicity]):'-'}}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        {{trans('sentence.build')}}
                                    </div>
                                    <div class="col-6">
                                        {{($user && $user->build != '')?($user->build == 4?$user->build_other:$ethnicity[$user->build]):'-'}}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        {{trans('sentence.preferred_age')}}
                                    </div>
                                    <div class="col-6">
                                        {{($userInfo)?$userInfo->preferred_min_age.'-'.$userInfo->preferred_max_age:'-'}}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        {{trans('sentence.preferred_weight')}}
                                    </div>
                                    <div class="col-6">
                                        {{($userInfo)?$userInfo->preferred_min_weight.'-'.$userInfo->preferred_max_weight.' kg':'-'}}
                                    </div>
                                </div>
                            </div>
                            <button type="submit" value="general_info_submit" class="btn btn-primary" style="display: none;" id='general_info_submit'>Submit</button>
                        </div>
                    </div>
                    <div class="tab-pane fade {{(isset($request->page) && $request->page != '')?' show active':''}}" id="match" role="tabpanel" aria-labelledby="match-tab">
                        <div class="row">
                            @if(count($matchedProfile['matchProfile'])>0)
                            @foreach($matchedProfile['matchProfile'] as $val)
                                <div class="col-md-6">
                                    <div class="users-listing-card">
                                        <a class="link-profile" href="{{route('userProfile',[$val->id])}}"></a>
                                        <div class="image-section">
                                            <div class="user-img">
                                                <img src="{{ asset('images/profile/'.$val->photo)}}" alt="">
                                            </div>
                                            <div class="age-group">
                                                {{$val->age}} year old {{$gender[$val->gender]}}
                                            </div>
                                            @if($val->login_status == 1)
                                                <div class="online"></div>
                                            @endif
                                        </div>
                                        <div class="details-section">
                                            <h3>{{$val->name}}</h3>
                                            <h4>{{$val->state.($val->countryData?','.$val->countryData->country_name:'')}}</h4>
                                            <h5>{{$matchedProfile['matchProfileWithPerc'][$val->id].'% Match'}}</h5>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @else
                            <h3>No Matches Found!</h3>
                            @endif
                        </div>
                        @if(count($matchedProfile['matchProfile'])>0)
                        <div class="pagination-container">
                            {!! $matchedProfile['matchProfile']->appends(\Request::except('page'))->render() !!}
                        </div>
                        @endif
                    </div>
                    <div class="tab-pane fade" id="phone_verify" role="tabpanel" aria-labelledby="phone-verify-tab">
                        <form action="{{route('phoneVerification')}}" id="phoneVerification" method="post">
                            @csrf
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="phoneNumber">{{ trans('sentence.phone_number')}}
                                        @if(in_array(1,$userPrivacySetting))
                                            <input type="checkbox" class="phone_number_privacy user_info_privacy" name="user_info_privacy[1]" value="1" {{in_array(1,$userInfoPrivacy)?'checked':''}}>  
                                        @endif
                                    </label>
                                    <input type="text" class="form-control" id="phoneNumber" placeholder="{{ trans('sentence.enter').' '.trans('sentence.phone_number')}}" 
                                           name="phoneNumber" value="{{old('phoneNumber')!=''?old('phoneNumber'):$user->phone}}">
                                </div>
                                @error('phoneNumber')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        `   </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{trans('sentence.send')}}
                                    </button>
                                    <button type="button" class="btn btn-secondary" onclick="location.href='{{url('/profile')}}'">
                                        {{trans('sentence.cancel')}}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="document_verify" role="tabpanel" aria-labelledby="doc-tab">
                        @if(count($userDoc)>0 && Auth::user()->id_verify != 1)
                          <div class="alert alert-warning" role="alert">
                              <h6>Your documents are under verification.</h6>
                          </div>
                        @elseif (Auth::user()->id_verify == 1)
                          <div class="alert alert-success" role="alert">
                              <h6>Your documents are verified.</h6>
                          </div>
                        @elseif (count($userDoc) == 0)
                            <form action="{{route('docVerification')}}" id="docVerification" method="post"  enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                 <div class="form-group col-6">
                                     <label for="doc">{{ trans('sentence.doc_upload')}}</label>
                                     <div class="input-group">
                                         <div class="custom-file">
                                             <input type="file" class="custom-file-input" id="doc_upload" name="doc_upload[]"
                                                    accept="image/TIFF,image/PNG,image/JPG,image/JPEG,image/GIF,application/PDF" multiple="multiple">
                                             <label class="custom-file-label" for="doc_upload" id="doc_upload_label">Choose file</label>
                                         </div>
                                     </div>
                                     <small id="doc_upload-error" class="error"></small>
                                     <div>(TIFF, JPEG, JPG, GIF, PNG, PDF )</div>
                                 </div>
                                 @error('doc_upload')
                                     <span class="invalid-feedback" role="alert">
                                         <strong>{{ $message }}</strong>
                                     </span>
                                 @enderror
                         `   </div>
                                <div class="form-group row mb-0">
                                 <div class="col-md-6 offset-md-4">
                                     <button type="submit" class="btn btn-primary">
                                         {{trans('sentence.send')}}
                                     </button>
                                     <button type="button" class="btn btn-secondary" onclick="location.href='{{url('/profile')}}'">
                                         {{trans('sentence.cancel')}}
                                     </button>
                                 </div>
                             </div>
                            </form>
                        @endif
                    </div>
                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
                    <div class="tab-pane fade" id="contact1" role="tabpanel" aria-labelledby="contact1-tab">...</div>
                  </div>
            </div>
        </div>
        @if(Auth::user() && Auth::user()->id_verify == 1 && Auth::user()->email_verify == 1 && Auth::user()->phone_verify == 1)
        <div class="col-md-4">
            <div class="custom-card">
                <form class="form-horizontal" method="post" action="{{route('viewSearchProfile')}}"  name="search_profile" id="search_profile">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <div class=" ">
                                <label class=" ">{{ trans('sentence.select').' '.trans('sentence.age')}}</label>
                                <input type="text" id="age_range" readonly class="search_range" name="age"  >
                            </div>
                            <div id="age-slider-range"></div>
                        </div>
                        <div class="form-group">
                            <div class=" ">
                                <label class=" ">{{ trans('sentence.select').' '.trans('sentence.height')}}</label>
                                <input type="text" id="height_range" readonly class="search_range" name="height"  style="display: none;">
                                <input type="text" id="height_range_hidden" class="search_range" name="height_range_hidden"  >
                            </div>
                            <div id="height-slider-range"></div>
                        </div>
                        <div class="form-group">
                            <div class=" ">
                                <label class=" ">{{ trans('sentence.select').' '.trans('sentence.weight')}}</label>
                                <input type="text" id="weight_range" readonly class="search_range" name="weight"  style="display: none;">
                                <input type="text" id="weight_range_hidden" class="search_range" name="weight_range_hidden"  >
                            </div>
                            <div id="weight-slider-range"></div>
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="city[]" id="search_city" multiple="multiple" ></select>
                        </div>
                        <div class="form-group">
                            <select class="form-control " name="state[]" id="search_state" multiple="multiple" ></select>
                            
                        </div>
                        <div class="form-group">
                            <select name="country[]" class="form-control"  multiple="multiple" id="search_country">
                                @foreach($country as $key => $val)
                                <option value="{{$val->id}}">{{$val->country_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <select name="education[]" class="form-control" id="search_education"  multiple="multiple">
                                @foreach($education as $key => $val)
                                    <option value="{{$key}}" >{{$val}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <select name="employment_status[]" class="form-control"  id="search_employment_status"  multiple="multiple">
                                @foreach($employment_status as $key => $val)
                                    <option value="{{$key}}">{{$val}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <select name="ethnicity[]" class="form-control" id="ethnicity"  multiple="multiple">
                                @foreach($ethnicity as $key => $val)
                                <option value="{{$key}}" >{{$val}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <select name="living_arrangement[]" class="form-control" id="search_living_arrangement"  multiple="multiple">
                                @foreach($living_arrangement as $key => $val)
                                    <option value="{{$key}}" >{{$val}}</option>
                                @endforeach
                            </select>
                        </div>
                    <div class="form-group mb-0">
                        <button type="submit" class="btn btn-primary" name="profile_search" value="1">
                            {{ trans('sentence.find_your_partner')}}
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="location.href='{{url('/profile')}}'">
                            {{trans('sentence.cancel')}}
                        </button>
                    </div>
                </div>
            </form>
            </div>
            <div class="custom-card pt-5">
                @if(count($matchedProfile['topMatchedProfile'])>0)
                    @foreach($matchedProfile['topMatchedProfile'] as $val)
                        <div class="col-md-6">
                            <div class="users-listing-card">
                                <a class="link-profile" href="{{route('userProfile',[$val->id])}}"></a>
                                <div class="image-section">
                                    <div class="user-img">
                                        <img src="{{ asset('images/profile/'.$val->photo)}}" alt="">
                                    </div>
                                    <div class="age-group">
                                        {{$val->age}} year old {{$gender[$val->gender]}}
                                    </div>
                                    @if($val->login_status == 1)
                                        <div class="online"></div>
                                    @endif
                                </div>
                                <div class="details-section">
                                    <h3>{{$val->name}}</h3>
                                    <h4>{{$val->state.($val->countryData?','.$val->countryData->country_name:'')}}</h4>
                                    <h5>{{$matchedProfile['matchProfileWithPerc'][$val->id].'% Match'}}</h5>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        @endif
</div>
@include('front.profile.modal.edit_general_info')
@include('front.profile.modal.manage_profile_photo')
@endsection
  
@section('javascript')
<script src="{{ asset('js/front_profile.js?'.time()) }}"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $("#search_city").select2({
            placeholder: "{{ trans('sentence.enter').' '.trans('sentence.city')}}",
            tags: true
        });
        $("#search_state").select2({
            placeholder: "{{ trans('sentence.enter').' '.trans('sentence.state')}}",
            tags: true
        });$("#search_country").select2({
            placeholder: "{{ trans('sentence.country')}}",
            tags: true
        });
        $("#search_education").select2({
            placeholder: "{{ trans('sentence.education')}}",
            tags: true
        });
        $("#search_employment_status").select2({
            placeholder: "{{ trans('sentence.employee')}}",
            tags: true
        });                      
        $("#ethnicity").select2({
            placeholder: "{{ trans('sentence.ethnicity')}}",
            tags: true
        });
        $("#search_living_arrangement").select2({
            placeholder: "{{ trans('sentence.living_arrangement')}}",
            tags: true
        });
    });
</script>
@endsection
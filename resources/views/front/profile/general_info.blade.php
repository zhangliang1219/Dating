@extends('layouts.final')
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
    $user_info_privacy = trans('sentence.user_info_privacy');
@endphp

@section('content')
<div class="container">
    <div class="row ">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ trans('sentence.register')}}</div>
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
                    <form method="POST" action="{{ route('generalProfileInfoStore') }}"   id="general_info_form">
                        @csrf
                        <input type="hidden" name="user_id" value="{{Auth::user()->id}}" id="user_id">
                        <h4>{{trans('sentence.i_am_looking_for')}}</h4><br>
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="wish_to_meet" >{{trans('sentence.wish_to_meet')}}</label>
                                <select name="wish_to_meet" class="gender form-control">
                                    <option value=""></option>
                                    @foreach($gender as $key => $val)
                                    <option value="{{$key}}" {{old('wish_to_meet') == $key?'selected':''}}>{{$val}}</option>
                                    @endforeach
                                </select>
                                @error('wish_to_meet')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-6">
                                <label for="preferred_age" >{{trans('sentence.preferred_age')}}</label>
                                <select name="preferred_age[]" class="form-control select2" multiple="multiple">
                                    @foreach($preferred_age as $key => $val)
                                    <option value="{{$key}}" {{old('preferred_age') == $key?'selected':''}}>{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="preferred_height" >{{trans('sentence.preferred_height')}}</label>
                                <select name="preferred_height[]" class="form-control select2" multiple="multiple">
                                    @foreach($height as $key => $val)
                                    <option value="{{$key}}" {{old('preferred_height') == $key?'selected':''}}>{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-6">
                                <label for="preferred_weight" >{{trans('sentence.preferred_weight')}}</label>
                                <select name="preferred_weight[]" class="form-control select2" multiple="multiple">
                                    @foreach($weight as $key => $val)
                                    <option value="{{$key}}" {{old('preferred_weight') == $key?'selected':''}}>{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <h4>About Me</h4><br>
                        
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="phoneNumber">{{ trans('sentence.phone_number')}}
                                    @if(in_array(1,$userPrivacySetting))
                                        <select name="user_info_privacy[1]" class="phone_number_privacy user_info_privacy">
                                            <option></option>
                                            @foreach($user_info_privacy as $key => $val)
                                                <option value="{{$key}}" {{$key == 2 ?'selected':''}}>{{$val}}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                </label>
                                <input type="text" class="form-control" id="phoneNumber" placeholder="{{ trans('sentence.enter').' '.trans('sentence.phone_number')}}" name="phoneNumber" value="{{old('phoneNumber')}}">
                            </div>
                            @error('phoneNumber')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <div class="form-group col-6">
                                <label for="relationship" >{{trans('sentence.relationship')}}
                                    @if(in_array(2,$userPrivacySetting))
                                    <select name="user_info_privacy[2]" class="relationship_privacy user_info_privacy">
                                        <option></option>
                                        @foreach($user_info_privacy as $key => $val)
                                        <option value="{{$key}}" {{$key == 2 ?'selected':''}}>{{$val}}</option>
                                        @endforeach
                                    </select>
                                    @endif
                                </label>
                                <select name="relationship" class="form-control">
                                    <option value=""></option>
                                    @foreach($relationship as $key => $val)
                                        <option value="{{$key}}" {{old('relationship') == $key?'selected':''}}>{{$val}}</option>
                                    @endforeach
                                </select>
                                @error('relationship')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="height" >{{trans('sentence.height')}}
                                @if(in_array(3,$userPrivacySetting))
                                <select name="user_info_privacy[3]" class="height_privacy user_info_privacy">
                                    <option></option>
                                    @foreach($user_info_privacy as $key => $val)
                                    <option value="{{$key}}" {{$key == 2 ?'selected':''}}>{{$val}}</option>
                                    @endforeach
                                </select>
                                @endif
                                </label>
                                <select name="height" class="form-control">
                                    <option value=""></option>
                                    @foreach($height as $key => $val)
                                        <option value="{{$key}}" {{old('height') == $key?'selected':''}}>{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-6">
                                <label for="weight" >{{trans('sentence.weight')}}
                                    @if(in_array(4,$userPrivacySetting))
                                    <select name="user_info_privacy[4]" class="weight_privacy user_info_privacy">
                                        <option></option>
                                        @foreach($user_info_privacy as $key => $val)
                                        <option value="{{$key}}" {{$key == 2 ?'selected':''}}>{{$val}}</option>
                                        @endforeach
                                    </select>
                                    @endif
                                </label>
                                <select name="weight" class="form-control">
                                    <option value=""></option>
                                    @foreach($weight as $key => $val)
                                        <option value="{{$key}}" {{old('weight') == $key?'selected':''}}>{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="living_arrangement" >{{trans('sentence.living_arrangement')}}
                                    @if(in_array(5,$userPrivacySetting))
                                    <select name="user_info_privacy[5]" class="living_arrangement_privacy user_info_privacy">
                                        <option></option>
                                        @foreach($user_info_privacy as $key => $val)
                                        <option value="{{$key}}" {{$key == 2 ?'selected':''}}>{{$val}}</option>
                                        @endforeach
                                    </select>
                                    @endif
                                </label>
                                <select name="living_arrangement" class="form-control">
                                    <option value=""></option>
                                    @foreach($living_arrangement as $key => $val)
                                        <option value="{{$key}}" {{old('living_arrangement') == $key?'selected':''}}>{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-6">
                                <label for="city" >{{trans('sentence.city')}}
                                    @if(in_array(6,$userPrivacySetting))
                                    <select name="user_info_privacy[6]" class="city_arrangement_privacy user_info_privacy">
                                        <option></option>
                                        @foreach($user_info_privacy as $key => $val)
                                        <option value="{{$key}}" {{$key == 2 ?'selected':''}}>{{$val}}</option>
                                        @endforeach
                                    </select>
                                    @endif
                                </label>
                                <input type="text" value="{{old('city')}}" id="city" name="city" class="form-control"  placeholder="{{ trans('sentence.enter').' '.trans('sentence.city')}}">
                               
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="state" >{{trans('sentence.state')}}
                                    @if(in_array(7,$userPrivacySetting))
                                    <select name="user_info_privacy[7]" class="state_arrangement_privacy user_info_privacy">
                                        <option></option>
                                        @foreach($user_info_privacy as $key => $val)
                                        <option value="{{$key}}" {{$key == 2 ?'selected':''}}>{{$val}}</option>
                                        @endforeach
                                    </select>
                                    @endif
                                </label>
                                <input type="text" value="{{old('state')}}" id="state" name="state" class="form-control"   placeholder="{{ trans('sentence.enter').' '.trans('sentence.state')}}">
                            </div>
                            <div class="form-group col-6">
                                <label for="country" >{{trans('sentence.country')}}
                                    @if(in_array(8,$userPrivacySetting))
                                    <select name="user_info_privacy[8]" class="country_arrangement_privacy user_info_privacy">
                                        <option></option>
                                        @foreach($user_info_privacy as $key => $val)
                                        <option value="{{$key}}" {{$key == 2 ?'selected':''}}>{{$val}}</option>
                                        @endforeach
                                    </select>
                                    @endif
                                </label>
                                <select name="country" class="form-control">
                                    <option value=""></option>
                                    @foreach($country as $key => $val)
                                        <option value="{{$val->id}}" {{old('country') == $val->id?'selected':''}}>{{$val->country_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="favorite_sport" >{{trans('sentence.favorite_sport')}}
                                    @if(in_array(9,$userPrivacySetting))
                                    <select name="user_info_privacy[9]" class="favorite_sport_privacy user_info_privacy">
                                        <option></option>
                                        @foreach($user_info_privacy as $key => $val)
                                        <option value="{{$key}}" {{$key == 2 ?'selected':''}}>{{$val}}</option>
                                        @endforeach
                                    </select>
                                    @endif
                                </label>
                                <input type="text" value="{{old('favorite_sport')}}" name="favorite_sport" class="form-control"   placeholder="{{ trans('sentence.enter').' '.trans('sentence.favorite_sport')}}">
                            </div>
                            <div class="form-group col-6">
                                <label for="high_school_attended" >{{trans('sentence.high_school_attended')}}
                                    @if(in_array(10,$userPrivacySetting))
                                    <select name="user_info_privacy[10]" class="high_school_privacy user_info_privacy">
                                        <option></option>
                                        @foreach($user_info_privacy as $key => $val)
                                        <option value="{{$key}}" {{$key == 2 ?'selected':''}}>{{$val}}</option>
                                        @endforeach
                                    </select>
                                    @endif
                                </label>
                                <input type="text"  name="high_school_attended" class="form-control" value="{{old('high_school_attended')}}"
                                         placeholder="{{ trans('sentence.enter').' '.trans('sentence.high_school_attended')}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="collage" >{{trans('sentence.college')}}
                                    @if(in_array(11,$userPrivacySetting))
                                    <select name="user_info_privacy[11]" class="college_privacy user_info_privacy">
                                        <option></option>
                                        @foreach($user_info_privacy as $key => $val)
                                        <option value="{{$key}}" {{$key == 2 ?'selected':''}}>{{$val}}</option>
                                        @endforeach
                                    </select>
                                    @endif
                                </label>
                                <input type="text" value="{{old('collage')}}" name="collage" class="form-control" 
                                         placeholder="{{ trans('sentence.enter').' '.trans('sentence.college')}}">
                            </div>
                            <div class="form-group col-6">
                                <label for="employment_status" >{{trans('sentence.employee')}}
                                    @if(in_array(12,$userPrivacySetting))
                                    <select name="user_info_privacy[12]" class="employment_status_privacy user_info_privacy">
                                        <option></option>
                                        @foreach($user_info_privacy as $key => $val)
                                        <option value="{{$key}}" {{$key == 2 ?'selected':''}}>{{$val}}</option>
                                        @endforeach
                                    </select>
                                    @endif
                                </label>
                                <select name="employment_status" class="form-control" >
                                    <option value=""></option>
                                    @foreach($employment_status as $key => $val)
                                        <option value="{{$key}}" {{old('employment_status') == $key?'selected':''}}>{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="education" >{{trans('sentence.education')}}
                                    @if(in_array(13,$userPrivacySetting))
                                    <select name="user_info_privacy[13]" class="education_privacy user_info_privacy">
                                        <option></option>
                                        @foreach($user_info_privacy as $key => $val)
                                        <option value="{{$key}}" {{$key == 2 ?'selected':''}}>{{$val}}</option>
                                        @endforeach
                                    </select>
                                    @endif
                                </label>
                                <select name="education" class="form-control">
                                    <option value=""></option>
                                    @foreach($education as $key => $val)
                                        <option value="{{$key}}" {{old('education') == $key?'selected':''}}>{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-6">
                                <label for="children" >{{trans('sentence.children')}}
                                    @if(in_array(14,$userPrivacySetting))
                                    <select name="user_info_privacy[14]" class="children_privacy user_info_privacy">
                                        <option></option>
                                        @foreach($user_info_privacy as $key => $val)
                                        <option value="{{$key}}" {{$key == 2 ?'selected':''}}>{{$val}}</option>
                                        @endforeach
                                    </select>
                                    @endif
                                </label>
                                <select name="children" class="form-control">
                                    <option value=""></option>
                                    @foreach($children as $key => $val)
                                        <option value="{{$key}}" {{old('children') == $key?'selected':''}}>{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12">
                                <label for="describe_perfect_date" >{{trans('sentence.describe_perfect_date')}}
                                    @if(in_array(15,$userPrivacySetting))
                                    <select name="user_info_privacy[15]" class="describe_perfect_date_privacy user_info_privacy">
                                        <option></option>
                                        @foreach($user_info_privacy as $key => $val)
                                        <option value="{{$key}}" {{$key == 2 ?'selected':''}}>{{$val}}</option>
                                        @endforeach
                                    </select>
                                    @endif
                                </label>
                                <textarea  row="2" col="2" name="describe_perfect_date" class="form-control"
                                         placeholder="{{ trans('sentence.enter').' '.trans('sentence.describe_perfect_date')}}" id="describe_perfect_date"></textarea>
                                
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="ethnicity" >{{trans('sentence.ethnicity')}}
                                    @if(in_array(16,$userPrivacySetting))
                                    <select name="user_info_privacy[16]" class="ethnicity_privacy user_info_privacy">
                                        <option></option>
                                        @foreach($user_info_privacy as $key => $val)
                                        <option value="{{$key}}" {{$key == 2 ?'selected':''}}>{{$val}}</option>
                                        @endforeach
                                    </select>
                                    @endif
                                </label>
                                <select name="ethnicity" class="form-control" id="ethnicity">
                                    <option value=""></option>
                                    @foreach($ethnicity as $key => $val)
                                    <option value="{{$key}}" {{old('ethnicity') == $key?'selected':''}}>{{$val}}</option>
                                    @endforeach
                                </select>
                                @error('ethnicity')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-6">
                                <label for="build" >{{trans('sentence.build')}}
                                @if(in_array(17,$userPrivacySetting))
                                    <select name="user_info_privacy[17]" class="build_privacy user_info_privacy">
                                        <option></option>
                                        @foreach($user_info_privacy as $key => $val)
                                        <option value="{{$key}}" {{$key == 2 ?'selected':''}}>{{$val}}</option>
                                        @endforeach
                                    </select>
                                @endif
                                </label>
                                <select name="build" class="build form-control" id="build">
                                    <option value=""></option>
                                    @foreach($build as $key => $val)
                                        <option value="{{$key}}" {{old('build') == $key?'selected':''}}>{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <input type="text" class="form-control" name="ethnicity_other" id="ethnicity_other" style="display: none;">
                            </div>
                            <div class="form-group col-6">
                                <input type="text" class="form-control" name="build_other" id="build_other" style="display: none;">
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{trans('sentence.save')}}
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
<script src="{{ asset('js/front_user.js') }}"></script>
@endsection
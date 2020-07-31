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
                    <form method="POST" action="{{ route('front-register') }}" enctype="multipart/form-data" id="register_form">
                        @csrf
                        <h4>{{ trans('sentence.personal_info')}}</h4><br>
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="firstName">{{ trans('sentence.first_name')}}</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" value="{{old('first_name')}}"
                                       placeholder="{{ trans('sentence.enter').' '.trans('sentence.first_name')}}"  >
                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-6">
                                <label for="lastName">{{ trans('sentence.last_name')}}</label>
                                <input type="text" class="form-control" id="last_name" placeholder="{{ trans('sentence.enter').' '.trans('sentence.last_name')}}" 
                                       name="last_name" value="{{old('last_name')}}">
                                @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="dob">{{ trans('sentence.dob')}}</label>
                                <input type="text" class="form-control" id="dob" name="dob"  placeholder="{{ trans('sentence.enter').' '.trans('sentence.dob')}}" 
                                       value="{{old('dob')}}">
                                @error('dob')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-6">
                                <label for="phoneNumber">{{ trans('sentence.phone_number')}}</label>
                                <input type="text" class="form-control" id="phoneNumber" placeholder="{{ trans('sentence.enter').' '.trans('sentence.phone_number')}}" name="phoneNumber" value="{{old('phoneNumber')}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="email">{{ trans('sentence.email')}}</label>
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}"  autocomplete="email" placeholder="{{ trans('sentence.enter').' '.trans('sentence.email')}}">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-6">
                                <label>{{trans('sentence.photo_id')}}</label>
                                <div class="input-group">
                                  <div class="custom-file">
                                      <input type="file" class="custom-file-input " id="photo_id" name="photo_id">
                                    <label class="custom-file-label" for="photo_id"  id="uploadedFileName">Choose file</label>
                                  </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="password" >{{trans('sentence.password')}}</label>
                                <input id="password" type="password" class="form-control" name="password"  autocomplete="new-password" value="{{ old('password') }}"
                                       placeholder="{{ trans('sentence.enter').' '.trans('sentence.password')}}">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group  col-6">
                                <label for="password-confirm"  >{{trans('sentence.confirm_password')}}</label>
                                    <input id="password-confirm" type="password" class="form-control "  placeholder="{{ trans('sentence.enter').' '.trans('sentence.confirm_password')}}"
                                           name="password_confirmation"  autocomplete="new-password"  value="{{ old('password_confirmation') }}">
                            </div>
                        </div>
                        <h4>{{trans('sentence.i_am_looking_for')}}</h4><br>
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="wish_to_meet" >{{trans('sentence.wish_to_meet')}}</label>
                                <select name="wish_to_meet" class="gender form-control">
                                    <option value="">{{ trans('sentence.select').' '.trans('sentence.wish_to_meet')}}</option>
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
                                    <option value="">{{ trans('sentence.select').' '.trans('sentence.preferred_age')}}</option>
                                    @foreach($preferred_age as $key => $val)
                                    <option value="{{$key}}" {{old('preferred_age') == $key?'selected':''}}>{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <h4>About Me</h4><br>
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="ethnicity" >{{trans('sentence.ethnicity')}}</label>
                                <select name="ethnicity" class="form-control">
                                    <option value="">{{ trans('sentence.select').' '.trans('sentence.ethnicity')}}</option>
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
                                <label for="height" >{{trans('sentence.height')}}</label>
                                <select name="height" class="form-control">
                                    <option value="">{{ trans('sentence.select').' '.trans('sentence.height')}}</option>
                                    @foreach($height as $key => $val)
                                        <option value="{{$key}}" {{old('height') == $key?'selected':''}}>{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="weight" >{{trans('sentence.weight')}}</label>
                                <select name="weight" class="form-control">
                                    <option value="">{{ trans('sentence.select').' '.trans('sentence.weight')}}</option>
                                    @foreach($weight as $key => $val)
                                        <option value="{{$key}}" {{old('weight') == $key?'selected':''}}>{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-6">
                                <label for="build" >{{trans('sentence.build')}}</label>
                                <select name="build" class="build form-control">
                                    <option value="">{{ trans('sentence.select').' '.trans('sentence.build')}}</option>
                                    @foreach($build as $key => $val)
                                        <option value="{{$key}}" {{old('build') == $key?'selected':''}}>{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="relationship" >{{trans('sentence.relationship')}}</label>
                                <select name="relationship" class="form-control">
                                    <option value="">{{ trans('sentence.select').' '.trans('sentence.relationship')}}</option>
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
                            <div class="form-group col-6">
                                <label for="living_arrangement" >{{trans('sentence.living_arrangement')}}</label>
                                <select name="living_arrangement" class="form-control">
                                    <option value="">{{ trans('sentence.select').' '.trans('sentence.living_arrangement')}}</option>
                                    @foreach($living_arrangement as $key => $val)
                                        <option value="{{$key}}" {{old('living_arrangement') == $key?'selected':''}}>{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="city" >{{trans('sentence.city')}}</label>
                                <input type="text" value="{{old('city')}}" id="city" name="city" class="form-control"  placeholder="{{ trans('sentence.enter').' '.trans('sentence.city')}}">
                               
                            </div>
                            <div class="form-group col-6">
                                <label for="state" >{{trans('sentence.state')}}</label>
                                <input type="text" value="{{old('state')}}" id="state" name="state" class="form-control"   placeholder="{{ trans('sentence.enter').' '.trans('sentence.state')}}">
                                
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="country" >{{trans('sentence.country')}}</label>
                                <select name="country" class="form-control">
                                    <option value="">{{ trans('sentence.select').' '.trans('sentence.country')}}</option>
                                    @foreach($country as $key => $val)
                                        <option value="{{$val->id}}" {{old('country') == $val->id?'selected':''}}>{{$val->country_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-6">
                                <label for="favorite_sport" >{{trans('sentence.favorite_sport')}}</label>
                                <input type="text" value="{{old('favorite_sport')}}" name="favorite_sport" class="form-control"   placeholder="{{ trans('sentence.enter').' '.trans('sentence.favorite_sport')}}">
                              
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="high_school_attended" >{{trans('sentence.high_school_attended')}}</label>
                                <input type="text"  name="high_school_attended" class="form-control" value="{{old('high_school_attended')}}"
                                         placeholder="{{ trans('sentence.enter').' '.trans('sentence.high_school_attended')}}">
                            </div>
                            <div class="form-group col-6">
                                <label for="collage" >{{trans('sentence.college')}}</label>
                                <input type="text" value="{{old('collage')}}" name="collage" class="form-control" 
                                         placeholder="{{ trans('sentence.enter').' '.trans('sentence.college')}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="employment_status" >{{trans('sentence.employee')}}</label>
                                <select name="employment_status" class="form-control" >
                                    <option value="">{{ trans('sentence.select').' '.trans('sentence.employee')}}</option>
                                    @foreach($employment_status as $key => $val)
                                        <option value="{{$key}}" {{old('employment_status') == $key?'selected':''}}>{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-6">
                                <label for="education" >{{trans('sentence.education')}}</label>
                                <select name="education" class="form-control">
                                    <option value="">{{ trans('sentence.select').' '.trans('sentence.education')}}</option>
                                    @foreach($education as $key => $val)
                                        <option value="{{$key}}" {{old('education') == $key?'selected':''}}>{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="children" >{{trans('sentence.children')}}</label>
                                <select name="children" class="form-control">
                                    <option value="">{{ trans('sentence.select').' '.trans('sentence.children')}}</option>
                                    @foreach($children as $key => $val)
                                        <option value="{{$key}}" {{old('children') == $key?'selected':''}}>{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-6">
                                <label for="describe_perfect_date" >{{trans('sentence.describe_perfect_date')}}</label>
                                <input type="text" value="{{old('describe_perfect_date')}}" name="describe_perfect_date" class="form-control"
                                         placeholder="{{ trans('sentence.enter').' '.trans('sentence.describe_perfect_date')}}" id="describe_perfect_date">
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{trans('sentence.register')}}
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <a href="{{ route('social-redirect','facebook') }}" class="btn btn-facebook" class="btn btn-facebook"><i class="fa fa-facebook"></i> Facebook</a>
                            <a href="{{ route('social-redirect','google') }}" class="btn btn-google" class="btn btn-google"><i class="fa fa-google"></i> Google</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('javascript')
<script type="text/javascript">
$(document).ready(function(){
    $('input[type="file"]').change(function(e){
            var fileName = e.target.files[0].name;
            $('#uploadedFileName').text(fileName);
    });
});
</script>

<script src="{{ asset('js/front_user.js') }}"></script>
@endsection
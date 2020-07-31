@extends('admin.layout.final')
@section('title')
    Edit User
@endsection
@section('pageTitle')
    Edit User
@endsection
@php
    $user_status = config('constant.user_status');
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
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h3>Edit User</h3>
          </div>
          <div class="col-sm-6"></div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                @if (Session::has('error'))
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">&times;</button> 
                    <strong>{!!session('error')!!}</strong>
                </div>
                {{Session::forget('error')}}
                @endif 
                <div class="card card-info">
                    <div class="card-header">
                      <h3 class="card-title">Edit User</h3>
                    </div>
                    <form class="form-horizontal" method="post" action="{{route('updateUser',$user->id)}}" name="user_update" id="user_update" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="userId" value="{{$user->id}}">
                        <div class="card-body">
                            <h4>Personal Info</h4><hr>
                            <div class='row'>
                                <div class="form-group col-4">
                                    <label for="name">First Name</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter first name" 
                                           value="{{old('first_name')!=''?old('first_name'):$user->first_name}}">
                                    @if ($errors->has('first_name'))
                                        <div class="error">{{ $errors->first('first_name') }}</div>
                                    @endif
                                </div>
                                <div class="form-group col-4">
                                    <label for="name">Last Name</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter last name" 
                                           value="{{old('last_name')!=''?old('last_name'):$user->last_name}}">
                                    @if ($errors->has('last_name'))
                                        <div class="error">{{ $errors->first('last_name') }}</div>
                                    @endif
                                </div>
                                <div class="form-group col-4">
                                    <label for="dob">DOB</label>
                                    <input type="text" class="form-control" id="dob" name="dob"  placeholder="Enter DOB" 
                                           value="{{isset($user->dob)?date("Y/m/d", strtotime($user->dob)):old('dob')}}">
                                    @if ($errors->has('dob'))
                                        <div class="error">{{ $errors->first('dob') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-4">
                                    <label for="email">Email address</label>
                                    <input type="text" class="form-control" id="email" name="email" placeholder="Enter email" value="{{old('email')!=''?old('email'):$user->email}}">
                                    @if ($errors->has('email'))
                                        <div class="error">{{ $errors->first('email') }}</div>
                                    @endif
                                </div>
                                <div class="form-group col-4">
                                    <label for="phone">Phone Number</label>
                                    <input type="text" class="form-control" id="phoneNumber" name="phoneNumber" placeholder="Enter phone"  value="{{old('phoneNumber')!=''?old('phoneNumber'):$user->phone}}">
                                    @if ($errors->has('phoneNumber'))
                                        <div class="error">{{ $errors->first('phoneNumber') }}</div>
                                    @endif
                                </div>
                                <div class="form-group col-4">
                                    <label for="customFile">Photo ID</label> 
                                    <div class="custom-file">
                                      <input type="file" class="custom-file-input" id="photo_id" name='photo_id'>
                                      <label class="custom-file-label" for="photo_id"  id="uploadedFileName">Choose file</label>
                                    </div>
                                    @if ($errors->has('photo_id'))
                                        <div class="error">{{ $errors->first('photo_id') }}</div>
                                    @endif
                                    <div class='col-6 profile_photo'>
                                        <img src='{{url('images/profile/'.$user->photo)}}' title="Profile Photo">
                                    </div>
                                </div>
                            </div>
                            <h4>I am Looking For</h4><hr>
                            <div class='row'>
                                <div class="form-group col-4">
                                    <label for="wish_to_meet" >Wish to Meet</label>
                                    <select name="wish_to_meet" class="gender form-control">
                                        <option value="">Select Wish to Meet</option>
                                        @foreach($gender as $key => $val)
                                        <option value="{{$key}}" {{(old('wish_to_meet') == $key || $user->wish_to_meet == $key)?'selected':''}}>{{$val}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('wish_to_meet'))
                                        <div class="error">{{ $errors->first('wish_to_meet') }}</div>
                                    @endif
                                </div>
                                <div class="form-group col-4">
                                    <label for="preferred_age" >Preferred Age</label>
                                    <select name="preferred_age[]" class="form-control select2" multiple="multiple">
                                        <option value="">Select Preferred Age</option>
                                        @foreach($preferred_age as $key => $val)
                                        <option value="{{$key}}" {{(old('preferred_age') == $key || in_array($key,json_decode($user->preferred_age)))?'selected':''}}>{{$val}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <br><h4>About Me</h4><hr>
                            <div class="row">
                                <div class="form-group col-4">
                                    <label for="ethnicity" >Ethnicity</label>
                                    <select name="ethnicity" class="form-control">
                                        <option value="">Select Ethnicity</option>
                                        @foreach($ethnicity as $key => $val)
                                        <option value="{{$key}}" {{old('ethnicity') == $key || $user->ethnicity == $key?'selected':''}}>{{$val}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('ethnicity'))
                                        <div class="error">{{ $errors->first('ethnicity') }}</div>
                                    @endif
                                </div>
                                <div class="form-group col-4">
                                    <label for="height" >Height</label>
                                    <select name="height" class="form-control">
                                        <option value="">Select Height</option>
                                        @foreach($height as $key => $val)
                                            <option value="{{$key}}" {{old('height') == $key|| $user->height == $key?'selected':''}}>{{$val}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-4">
                                    <label for="weight" >Weight</label>
                                    <select name="weight" class="form-control">
                                        <option value="">Select weight</option>
                                        @foreach($weight as $key => $val)
                                            <option value="{{$key}}" {{old('weight') == $key|| $user->weight == $key?'selected':''}}>{{$val}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class='row'>
                                <div class="form-group col-4">
                                    <label for="build" >Build</label>
                                    <select name="build" class="build form-control">
                                        <option value="">Select Build</option>
                                        @foreach($build as $key => $val)
                                            <option value="{{$key}}" {{old('build') == $key|| $user->build?'selected':''}}>{{$val}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-4">
                                    <label for="relationship" >Relationship</label>
                                    <select name="relationship" class="form-control">
                                        <option value="">Select Relationship</option>
                                        @foreach($relationship as $key => $val)
                                            <option value="{{$key}}" {{old('relationship') == $key || $user->relationship == $key?'selected':''}}>{{$val}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('relationship'))
                                        <div class="error">{{ $errors->first('relationship') }}</div>
                                    @endif
                                </div>
                                <div class="form-group col-4">
                                    <label for="living_arrangement" >Living Arrangement</label>
                                    <select name="living_arrangement" class="form-control">
                                        <option value="">Select Living Arrangement</option>
                                        @foreach($living_arrangement as $key => $val)
                                            <option value="{{$key}}" {{old('living_arrangement') == $key ||  $user->living_arrangement == $key?'selected':''}}>{{$val}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class='row'>
                                <div class="form-group col-4">
                                    <label for="city" >City</label>
                                    <input type="text" value="{{isset($user->city)?$user->city:old('city')}}" id="city" name="city" class="form-control"  placeholder="Enter City">
                                </div>
                                <div class="form-group col-4">
                                    <label for="state" >State/Province</label>
                                    <input type="text" value="{{isset($user->state)?$user->state:old('state')}}" id="state" name="state" class="form-control"   placeholder="Enter State">
                                </div>
                                <div class="form-group col-4">
                                    <label for="country" >Country</label>
                                    <select name="country" class="form-control">
                                        <option value="">Select Country</option>
                                        @foreach($country as $key => $val)
                                            <option value="{{$val->id}}" {{old('country') == $val->id || $user->country == $val->id?'selected':''}}>{{$val->country_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class='row'>
                                <div class="form-group col-4">
                                    <label for="favorite_sport" >Favorite Sport</label>
                                    <input type="text" value="{{isset($user->favorite_sport)?$user->favorite_sport:old('favorite_sport')}}" name="favorite_sport" class="form-control"   placeholder="Enter Favorite Sport">
                                </div>
                                <div class="form-group col-4">
                                    <label for="high_school_attended" >High School Attended </label>
                                    <input type="text"  name="high_school_attended" class="form-control" value="{{isset($user->high_school_attended)?$user->high_school_attended:old('high_school_attended')}}"
                                             placeholder="Enter High School Attended ">
                                </div>
                                <div class="form-group col-4">
                                    <label for="collage" >College/University Attended</label>
                                    <input type="text" value="{{isset($user->collage)?$user->collage:old('collage')}}" name="collage" class="form-control"  
                                             placeholder="Enter College">
                                </div>
                            </div>
                            <div class='row'>
                                <div class="form-group col-4">
                                    <label for="employment_status" >Employment Status</label>
                                    <select name="employment_status" class="form-control" >
                                        <option value="">Enter Employee</option>
                                        @foreach($employment_status as $key => $val)
                                            <option value="{{$key}}" {{old('employment_status') == $key || $user->employment_status == $key?'selected':''}}>{{$val}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-4">
                                    <label for="education" >Education</label>
                                    <select name="education" class="form-control">
                                        <option value="">Select Education</option>
                                        @foreach($education as $key => $val)
                                            <option value="{{$key}}" {{old('education') == $key ||$user->education == $key ?'selected':''}}>{{$val}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-4">
                                    <label for="children" >Children</label>
                                    <select name="children" class="form-control">
                                        <option value="">Enter Children</option>
                                        @foreach($children as $key => $val)
                                            <option value="{{$key}}" {{old('children') == $key ||$user->children == $key ?'selected':''}}>{{$val}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-4">
                                    <label for="describe_perfect_date" >Describe Perfect Date </label>
                                    <input type="text" value="{{isset($user->describe_perfect_date)?date("Y/m/d", strtotime($user->describe_perfect_date)):old('describe_perfect_date')}}" name="describe_perfect_date" class="form-control"
                                             placeholder="Enter Describe Perfect Date " id="describe_perfect_date">
                                </div>
                            </div>
                            
                            <br><h4>General</h4><hr>
                            <div class="row ">
                                <div class="form-group col-4">
                                        <label for="status">Status</label>
                                        <select id="status" class="form-control" name="status">
                                            @foreach($user_status as $key => $val)
                                            <option value="{{$key}}"  {{(old('status') == $key ?'checked':($user->status == $key?'selected':''))}}>{{$val}}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('status'))
                                            <div class="error">{{ $errors->first('status') }}</div>
                                        @endif
                                </div>
                            </div>
                            <div class='row'>
                                <div class="form-group col-4">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="email_verification" 
                                               name='email_verification'  {{(old('email_verify') == 1 ?'checked':($user->email_verify == 1?'checked':''))}}>
                                        <label class="custom-control-label" for="email_verification">Email Verification</label>
                                    </div>
                                </div>
                                <div class="form-group col-4">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="phone_verification" 
                                               name='phone_verification' {{(old('phone_verification') == 1 ?'checked':($user->phone_verify == 1?'checked':''))}}>
                                        <label class="custom-control-label" for="phone_verification">Phone Verification</label>
                                    </div>
                                </div>
                                <div class="form-group col-4">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="id_verification" 
                                               name='id_verification' {{(old('id_verification') == 1 ?'checked':($user->id_verify == 1?'checked':''))}}>
                                        <label class="custom-control-label" for="id_verification">ID Verification</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{route('userListing')}}"><button type="button" value="Cancel" class="btn btn-info btn-secondary">Cancel</button></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
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
@endsection
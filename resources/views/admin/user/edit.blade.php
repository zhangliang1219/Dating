@extends('admin.layout.final')
@section('title')
    Edit User
@endsection
@section('pageTitle')
    Edit User
@endsection
@php
    $user_status = config('constant.user_status');
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
                            <div class='row'>
                                <div class="form-group col-6">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" value="{{old('name')!=''?old('name'):$user->name}}">
                                    @if ($errors->has('name'))
                                        <div class="error">{{ $errors->first('name') }}</div>
                                    @endif
                                </div>
                                <div class="form-group col-6">
                                    <label for="email">Email address</label>
                                    <input type="text" class="form-control" id="email" name="email" placeholder="Enter email" value="{{old('email')!=''?old('email'):$user->email}}">
                                    @if ($errors->has('email'))
                                        <div class="error">{{ $errors->first('email') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class='row'>
                                <div class="form-group col-6">
                                    <label for="phone">Phone</label>
                                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter phone"  value="{{old('phone')!=''?old('phone'):$user->phone}}">
                                    @if ($errors->has('phone'))
                                        <div class="error">{{ $errors->first('phone') }}</div>
                                    @endif
                                </div>
                                <div class="form-group gender_group col-6">
                                    <label for="gender">Gender</label><br>
                                    <div class="gender_opt">
                                       <div class="custom-control custom-radio custom-radio1">
                                           <input class="custom-control-input" type="radio" id="male"  name='gender' value="1"  {{(old('gender') == 1 ?'checked':($user->gender == 1?'checked':''))}}>
                                         <label for="male" class="custom-control-label">Male</label>
                                       </div>
                                       <div class="custom-control custom-radio custom-radio2">
                                         <input class="custom-control-input" type="radio" id="female" name='gender' value='2' {{(old('gender') == 2 ?'checked':($user->gender == 2?'checked':''))}}>
                                         <label for="female" class="custom-control-label">Female</label>
                                       </div>
                                    </div>
                                    @if ($errors->has('gender'))
                                        <div class="error">{{ $errors->first('gender') }}</div>
                                    @endif
                               </div>
                            </div>
                            <div class='row'>
                                <div class="form-group col-6">
                                    <label for="Age">Age</label>
                                    <input type="text" class="form-control" id="age" name="age" placeholder="Enter age"  value="{{old('age')!=''?old('age'):$user->age}}">
                                    @if ($errors->has('age'))
                                        <div class="error">{{ $errors->first('age') }}</div>
                                    @endif
                                </div>
                                <div class="form-group col-6">
                                    <div class="form-group">
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
                                <div class="form-group col-6">
                                    <label for="customFile">Profile Photo</label> 
                                    <div class="custom-file">
                                      <input type="file" class="custom-file-input" id="profile_photo" name='profile_photo'>
                                      <label class="custom-file-label" for="profile_photo"  id="uploadedFileName">Choose file</label>
                                    </div>
                                    @if ($errors->has('profile_photo'))
                                        <div class="error">{{ $errors->first('profile_photo') }}</div>
                                    @endif
                                </div>
                                <div class='col-6 profile_photo'>
                                    <img src='{{url('images/profile/'.$user->photo)}}' title="Profile Photo">
                                </div>
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
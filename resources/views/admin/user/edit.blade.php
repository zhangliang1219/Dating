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
                <div class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-title">Edit User</h3>
                    </div>
                    <form class="form-horizontal" method="post" action="{{route('updateUser',$user->id)}}" name="user_update" id="user_update">
                        @csrf
                        <input type="hidden" name="userId" value="{{$user->id}}">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" value="{{$user->name}}">
                                @if ($errors->has('name'))
                                    <div class="error">{{ $errors->first('name') }}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input type="text" class="form-control" id="email" name="email" placeholder="Enter email" value="{{$user->email}}">
                                @if ($errors->has('email'))
                                    <div class="error">{{ $errors->first('email') }}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter phone"  value="{{$user->phone}}">
                                @if ($errors->has('phone'))
                                    <div class="error">{{ $errors->first('phone') }}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select id="status" class="form-control" name="status">
                                    @foreach($user_status as $key => $val)
                                    <option value="{{$key}}"  {{$user->status == $key?'selected':''}}>{{$val}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('status'))
                                    <div class="error">{{ $errors->first('status') }}</div>
                                @endif
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

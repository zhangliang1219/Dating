@extends('admin.layout.final')
@section('title')
    User Listing
@endsection
@section('pageTitle')
    User Listing
@endsection
@php
$user_status = config('constant.user_status');
@endphp
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h3>User Management</h3>
          </div>
          <div class="col-sm-6"></div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                @if (Session::has('success'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">&times;</button> 
                    <strong>{!!session('success')!!}</strong>
                </div>
                {{Session::forget('success')}}
                @endif    

                @if (Session::has('error'))
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">&times;</button> 
                    <strong>{!!session('error')!!}</strong>
                </div>
                {{Session::forget('error')}}
                @endif 
                <div class="card">
                    <div class="card-body">
                        <p class="mt-1">Showing {{ $userList->firstItem() }} to {{ $userList->lastItem() }} of total {{$userList->total()}} entries</p>
                        <div class="table-responsive-md">
                            @if(count($userList)>0)
                            <table id="user_listing" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>@sortablelink('name','Name')</th>
                                        <th>@sortablelink('email','Email')</th>
                                        <th>@sortablelink('phone','Phone')</th>
                                        <th>@sortablelink('email_verify','Email Verification')</th>
                                        <th>@sortablelink('phone_verify','Phone Verification')</th>
                                        <th>@sortablelink('id_verify','ID Verification')</th>
                                        <th>@sortablelink('status','Status')</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $j = $userList->firstItem();
                                    @endphp 
                                    @foreach($userList as $val)
                                    <tr id="{{$val->id}}">
                                        <td>{{$j}}</td>
                                        <td>{{$val->name}}</td>
                                        <td>{{$val->email}}</td>
                                        <td>{{$val->phone}}</td>
                                        <td>{{($val->email_verify == 0)?'Unverified':'Verified'}}</td>
                                        <td>{{($val->phone_verify == 0)?'Unverified':'Verified'}}</td>
                                        <td>{{($val->id_verify == 0)?'Unverified':'Verified'}}</td>
                                        <td>{{$user_status[$val->status]}}</td>
                                        <td>
                                            <a href="{{url('admin/user/edit/'.$val->id)}}" title='Edit User' data-id='{{$val->id}}' class='edit_user'><i class="fa fa-edit"></i></a>
                                            <a href="javascript:void(0);" title='Delete User' class='delete_user' data-id='{{$val->id}}'><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    @php
                                        $j++;
                                    @endphp 
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                            <div class="border-top">
                                <h4 align="center" style="padding : 20px;">No record found.</h4>
                            </div>
                            @endif
                        </div>
                        
                            <?php // echo "<pre>";print_R($userList);exit;?>
                        @if($userList && !empty($userList))
                            <div class="pt-4">{!! $userList->appends(\Request::except('page'))->render() !!}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@extends('admin.layout.final')
@section('title')
    User Listing
@endsection
@section('pageTitle')
    User Listing
@endsection
@php
$user_status = config('constant.user_status');
$verify_status = config('constant.verify_status');
$gender = config('constant.gender');
@endphp
@section('content')
<?php 
 $search_class = "";
 ?>
 @if(Request::get('search_submit'))
    <?php 
        $search_class = "show";
    ?>
@endif
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
         <div id="accordion">
             <div class="card">
                    <div class="card-header bg-dark collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false">
                        <h3 class="card-title">User Search</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-chevron-down"></i></button>
                        </div>
                    </div>
                    <div id="collapseOne" class="panel-collapse in collapse <?php echo $search_class;?>" style="">
                        <form class="form-horizontal" method="get" action="{{url('admin/user')}}" name="search_filter" id="search_filter">
                            <div class="card-body">
                                <div class="row">
                                   <div class="form-group col-lg col-md-3 col-sm-3">
                                        <label class="">User</label>
                                          <select class="select2 form-control custom-select" style="width: 100%; height:36px;" name="search_by_user" id="search_by_user">
                                            <option value="">All</option>
                                            @foreach($userName as $key => $val)
                                            <option value="{{$key}}" {{($request->search_by_user == $key)?'selected':''}}>{{$val}}</option>
                                            @endforeach
                                            
                                        </select>  
                                    </div>
                                    <div class="form-group col-lg col-md-3 col-sm-3">
                                        <label>Email</label>
                                        <input type="text" name='search_by_email' class="search_by_email form-control" placeholder="Enter Email" 
                                         value="{{isset($request->search_by_email) && $request->search_by_email != ''?$request->search_by_email:''}}">
                                    </div>
                                    <div class="form-group col-lg col-md-3 col-sm-3">
                                        <label class="">Status</label>
                                            <select class="select2 form-control custom-select" style="width: 100%; height:36px;" name="search_by_status" id="search_by_status">
                                                <option value="">All</option>
                                                @foreach($user_status as $key => $val)
                                                <option value="{{$key}}" {{($request->search_by_status == $key)?'selected':''}}>{{$val}}</option>
                                                @endforeach
                                            </select>
                                    </div>
                                    <div class="form-group col-lg col-md-3 col-sm-3">
                                        <label class="">Gender</label>
                                        <select class="select2 form-control custom-select" style="width: 100%; height:36px;" name="search_by_gender" id="search_by_gender">
                                            <option value="">All</option>
                                            @foreach($gender as $key => $val)
                                            <option value="{{$key}}" {{($request->search_by_gender == $key)?'selected':''}}>{{$val}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg col-md-3 col-sm-3">
                                        <label class="">Email Verification</label>
                                          <select class="select2 form-control custom-select" style="width: 100%; height:36px;" name="search_by_email_verify" id="search_by_email_verify">
                                            <option value="">All</option>
                                            @foreach($verify_status as $key => $val)
                                            <option value="{{$key}}" {{($request->search_by_email_verify == $key)?'selected':''}}>{{$val}}</option>
                                            @endforeach
                                            
                                        </select>  
                                    </div>
                                    <div class="form-group col-lg col-md-3 col-sm-3">
                                        <label class="">Phone Verification</label>
                                          <select class="select2 form-control custom-select" style="width: 100%; height:36px;" name="search_by_phone_verify" id="search_by_phone_verify">
                                            <option value="">All</option>
                                            @foreach($verify_status as $key => $val)
                                            <option value="{{$key}}" {{($request->search_by_phone_verify == $key)?'selected':''}}>{{$val}}</option>
                                            @endforeach
                                            
                                        </select>  
                                    </div>
                                    <div class="form-group col-lg col-md-3 col-sm-3">
                                        <label class="">ID Verification</label>
                                          <select class="select2 form-control custom-select" style="width: 100%; height:36px;" name="search_by_id_verify" id="search_by_id_verify">
                                            <option value="">All</option>
                                            @foreach($verify_status as $key => $val)
                                            <option value="{{$key}}" {{($request->search_by_id_verify == $key)?'selected':''}}>{{$val}}</option>
                                            @endforeach
                                            
                                        </select>  
                                    </div>
                                    <div class="form-group col-lg col-md-3 col-sm-3"></div>
                                </div>
                            </div>
                            <input type="hidden" value="{{(isset($request->page_range))?$request->page_range:''}}" name="page_range" id="page_range">
                            <div class="card-footer">
                               <button name="search_submit" type="submit" class="btn btn-primary btn-dark" value="1">
                                   Search
                               </button>
                               <button name="search_reset" type="button" class="btn btn-info btn-secondary" onclick="location.href='{{url('admin/user')}}'">
                                   Reset
                               </button>
                           </div>
                        </form>
                   </div>
            </div>
        </div>
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
                        @if(count($userList)>0)
                            <p class="mt-1">Showing {{ $userList->firstItem() }} to {{ $userList->lastItem() }} of total {{$userList->total()}} entries</p>
                        @endif
                        <div class="table-responsive-md table-responsive">
                            @if(count($userList)>0)
                            <table id="user_listing" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>@sortablelink('name','Name')</th>
                                        <th>@sortablelink('email','Email')</th>
                                        <th>@sortablelink('phone','Phone')</th>
                                        <th>@sortablelink('age','Age')</th>
                                        <th>@sortablelink('gender','Gender')</th>
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
                                        <td>{{$val->age}}</td>
                                        <td>{{$gender[$val->gender]}}</td>
                                        <td>{{$verify_status[$val->email_verify]}}</td>
                                        <td>{{$verify_status[$val->phone_verify]}}</td>
                                        <td>{{$verify_status[$val->id_verify]}}</td>
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

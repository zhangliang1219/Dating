@extends('admin.layout.final')
@section('title')
    User Info privacy
@endsection
@section('pageTitle')
    User Info privacy
@endsection
@php
    $userInfoFieldList = config('constant.userInfo_field_list');
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
                <div class="card card-info">
                    <div class="card-header">
                      <h6 class="card-title">User Info privacy</h6>
                    </div>
                    <form class="form-horizontal" method="post" action="{{route('storeUserInfoPrivacy')}}" name="add_user_info_privacy" id="add_user_info_privacy">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-lg col-md-6 col-sm-6">
                                    <label for="field_name">Field Name</label>
                                    <select class="form-control select2" name="field_name[]" multiple="mutiple">
                                        @foreach($userInfoFieldList as $key => $fieldName)
                                            <option value="{{$key}}" {{(count($userInfoPrivacy)>0 && in_array($key,$userInfoPrivacy))?'selected':''}}>{{$fieldName}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-lg col-md-6 col-sm-6"></div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{route('userInfoPrivacyView')}}">
                                <button type="button" value="Cancel" class="btn btn-info btn-secondary">Cancel</button>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('javascript')
<script src="{{ asset('js/admin_subscription.js') }}"></script>
@endsection
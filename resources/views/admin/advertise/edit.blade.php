@extends('admin.layout.final')
@section('title')
    Edit Advertise
@endsection
@section('pageTitle')
    Edit Advertise
@endsection
@php
    $language = config('constant.language');
    $ad_category = config('constant.ad_category');
    $ad_status = config('constant.ad_status');
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
            <h3>Edit Advertise</h3>
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
                <div class="card card-info">
                    <div class="card-header">
                      <h3 class="card-title">Edit Advertise</h3>
                    </div>
                    <form class="form-horizontal" method="post" action="{{route('updateAdvertise',$getAds[0]->id)}}" name="edit_ads" id="edit_ads" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" class="totalLanguage" id="totalLanguage" value="{{count($language)}}">
                        <div class="card-body">
                            @include('admin.advertise.edit_form_html')
                            @if(count($language) !=  count($getAds))
                            <button type="button" class="btn btn-success float-left add_in_another_lang">
                                <i class="fas fa-plus"></i> Add In Another language
                            </button><br>
                            @endif
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{route('advertiseListing')}}"><button type="button" value="Cancel" class="btn btn-info btn-secondary">Cancel</button></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('javascript')
<script src="{{ asset('js/admin_advertise.js') }}"></script>
@endsection
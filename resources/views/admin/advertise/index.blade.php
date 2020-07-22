@extends('admin.layout.final')
@section('title')
    Advertise Listing
@endsection
@section('pageTitle')
    Advertise Listing
@endsection

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
            <h3>Advertise Management</h3>
          </div>
            <div class="col-sm-6">
                <a href="{{route('addAdvertise')}}" title="add_advertise">
                    <button type="button" class="btn btn-primary add_ads_button">Add Advertise</button>
                </a>
            </div>
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
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@extends('admin.layout.final')
@section('title')
    Add Advertise
@endsection
@section('pageTitle')
    Add Advertise
@endsection
@php
    $language = config('constant.language');
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
            <h3>Add Advertise</h3>
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
                      <h3 class="card-title">Edit User</h3>
                    </div>
                    <form class="form-horizontal" method="post" action="{{route('storeAdvertise')}}" name="add_ads" id="add_ads" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-group col-12">
                                <label for="lang">Language</label>
                                <select id="language" class="form-control" name="language" readonly>
                                    <option value=" ">Select Language</option>
                                    @foreach($language as $key => $val)
                                    <option value="{{$key}}" {{($key == 1?'selected':'')}}>{{$val}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('language'))
                                    <div class="error">{{ $errors->first('language') }}</div>
                                @endif
                            </div>
                            <div class="form-group col-12">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title">
                                @if ($errors->has('title'))
                                    <div class="error">{{ $errors->first('title') }}</div>
                                @endif
                            </div>
                            <div class="form-group col-12">
                                <label for="desc">Description</label>
                                <textarea class="form-control" rows="4" placeholder="Enter Description..." id='desc' name='desc'></textarea>
                                @if ($errors->has('desc'))
                                    <div class="error">{{ $errors->first('desc') }}</div>
                                @endif
                            </div>
                            <div class="form-group col-12">
                                <label for="file">Image / Video Upload</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="ads_file" name='ads_file'>
                                    <label class="custom-file-label" for="ads_file"  id="ads_file_name">Choose file</label>
                                </div>
                                <?php // echo "<pre>";print_R($errors->all());exit;?>
                                @if ($errors->has('ads_file'))
                                    <div class="error">{{ $errors->first('ads_file') }}</div>
                                @endif
                            </div>
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

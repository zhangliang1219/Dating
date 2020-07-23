@extends('admin.layout.final')
@section('title')
    Advertise Listing
@endsection
@section('pageTitle')
    Advertise Listing
@endsection
@php
    $ad_type = config('constant.ad_type');
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
        <div id="accordion">
             <div class="card">
                <div class="card-header bg-dark collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false">
                    <h3 class="card-title">Advertise Search</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-chevron-down"></i></button>
                    </div>
                </div>
                <div id="collapseOne" class="panel-collapse in collapse <?php echo $search_class;?>" style="">
                    <form class="form-horizontal" method="get" action="{{url('admin/advertise')}}" name="search_filter" id="search_filter">
                        <div class="card-body">
                            <div class="row">
                               <div class="form-group col-lg col-md-3 col-sm-3">
                                    <label class="">Title</label>
                                    <input type='text' name="search_by_title" id="search_by_title" class="form-control"
                                         value="{{isset($request->search_by_title) && $request->search_by_title != ''?$request->search_by_title:''}}">
                                </div>
                                <div class="form-group col-lg col-md-3 col-sm-3">
                                    <div class="form-group col-lg col-md-3 col-sm-3">
                                        <label class="">Ad Type</label>
                                        <select class="select2 form-control custom-select" style="width: 100%; height:36px;" name="search_by_ad_type" id="search_by_ad_type">
                                            <option value="">All</option>
                                            @foreach($ad_type as $key => $val)
                                            <option value="{{$key}}" {{($request->search_by_ad_type == $key)?'selected':''}}>{{$val}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-lg col-md-3 col-sm-3">
                                    <div class="form-group col-lg col-md-3 col-sm-3">
                                        <label class="">Ad Status</label>
                                        <select class="select2 form-control custom-select" style="width: 100%; height:36px;" name="search_by_ad_status" id="search_by_ad_status">
                                            <option value="">All</option>
                                            @foreach($ad_status as $key => $val)
                                            <option value="{{$key}}" {{($request->search_by_ad_status == $key)?'selected':''}}>{{$val}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-lg col-md-3 col-sm-3"></div>
                            </div>
                        </div>
                        <input type="hidden" value="{{(isset($request->page_range))?$request->page_range:''}}" name="page_range" id="page_range">
                        <div class="card-footer">
                           <button name="search_submit" type="submit" class="btn btn-primary btn-dark" value="1">
                               Search
                           </button>
                           <button name="search_reset" type="button" class="btn btn-info btn-secondary" onclick="location.href='{{url('admin/advertise')}}'">
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
                        @if(count($getAdvertise)>0)
                            <p class="mt-1">Showing {{ $getAdvertise->firstItem() }} to {{ $getAdvertise->lastItem() }} of total {{$getAdvertise->total()}} entries</p>
                        @endif
                        <div class="table-responsive-md  table-responsive">
                            @if(count($getAdvertise)>0)
                            <table id="advertise_listing" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>@sortablelink('title','Title')</th>
                                        <th>@sortablelink('ad_type','Ad Type')</th>
                                        <th>@sortablelink('ad_status','Ad Status')</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $j = $getAdvertise->firstItem();
                                    @endphp 
                                    @foreach($getAdvertise as $val)
                                    <tr id="{{$val->id}}">
                                        <td>{{$j}}</td>
                                        <td>{{$val->title}}</td>
                                        <td>{{$ad_type[$val->ad_type]}}</td>
                                        <td>{{$ad_status[$val->ad_status]}}</td>
                                        <td>
                                            <a href="{{url('admin/advertise/edit/'.$val->id)}}" title='Edit Advertise' data-id='{{$val->id}}' class='edit_advertise'><i class="fa fa-edit"></i></a>
                                            <a href="javascript:void(0);" title='Delete Advertise' class='delete_advertise' data-id='{{$val->id}}'><i class="fa fa-trash"></i></a>
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
                        @if($getAdvertise && !empty($getAdvertise))
                            <div class="pt-4">{!! $getAdvertise->appends(\Request::except('page'))->render() !!}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('javascript')
<script src="{{ asset('js/admin_advertise.js') }}"></script>
@endsection
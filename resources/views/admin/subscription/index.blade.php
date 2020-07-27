@extends('admin.layout.final')
@section('title')
    Subscription Listing
@endsection
@section('pageTitle')
    Subscription Listing
@endsection
@php
    $status = config('constant.status');
    $gender = config('constant.gender');
    $recurring_payment_opt = config('constant.recurring_payment_opt');
    $subscription_feature = config('constant.subscription_feature');
    $subscription_currency = config('constant.subscription_currency');
    $subscription_period_1 = config('constant.subscription_period_1');
    $subscription_period_2 = config('constant.subscription_period_2');
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
            <h3>Subscription Management</h3>
          </div>
            <div class="col-sm-6">
                <a href="{{route('addSubscription')}}" title="add_subscription">
                    <button type="button" class="btn btn-primary add_ads_button">Add Subscription</button>
                </a>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div id="accordion">
            <div class="card">
                <div class="card-header bg-dark collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false">
                    <h3 class="card-title">Subscription Search</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-chevron-down"></i></button>
                    </div>
                </div>
                <div id="collapseOne" class="panel-collapse in collapse <?php echo $search_class;?>" style="">
                    <form class="form-horizontal" method="get" action="{{url('admin/subscription')}}" name="search_filter" id="search_filter">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-lg col-md-4 col-sm-4">
                                    <label class="">Title</label>
                                    <input type='text' name="search_by_title" id="search_by_title" class="form-control"
                                         value="{{isset($request->search_by_title) && $request->search_by_title != ''?$request->search_by_title:''}}">
                                </div>
                                <div class="form-group col-lg col-md-4 col-sm-4">
                                    <label class="">Recurring Payment</label>
                                    <select  class="form-control" name="search_by_recurring_payment" >
                                        <option value="">Select Recurring Payment</option>
                                        @foreach($recurring_payment_opt as $rKey => $rVal)
                                            <option value="{{$rKey}}" {{($request->search_by_recurring_payment == $rKey)?'selected':''}}>{{$rVal}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-lg col-md-4 col-sm-4">
                                    <label class="">Status</label>
                                    <select  class="form-control" name="search_by_status" >
                                        <option value="">Select Status</option>
                                        @foreach($status as $sKey => $sVal)
                                            <option value="{{$sKey}}"  {{($request->search_by_status == $sKey)?'selected':''}}>{{$sVal}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-lg col-md-4 col-sm-4">
                                    <label class="">Subscribe By Default</label>
                                    <select  class="form-control" name="saerch_by_subscribe_by_default" >
                                        <option value="">Select Feature</option>
                                        @foreach($status as $sKey => $sVal)
                                            <option value="{{$sKey}}"   {{($request->saerch_by_subscribe_by_default == $sKey)?'selected':''}}>{{$sVal}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" value="{{(isset($request->page_range))?$request->page_range:''}}" name="page_range" id="page_range">
                        <div class="card-footer">
                           <button name="search_submit" type="submit" class="btn btn-primary btn-dark" value="1">
                               Search
                           </button>
                           <button name="search_reset" type="button" class="btn btn-info btn-secondary" onclick="location.href='{{url('admin/subscription')}}'">
                               Reset
                           </button>
                       </div>
                    </form>
                </div>
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
                        <div class="card">
                            <div class="card-body">
                                @if(count($subscriptionList)>0)
                                    <p class="mt-1">Showing {{ $subscriptionList->firstItem() }} to {{ $subscriptionList->lastItem() }} of total {{$subscriptionList->total()}} entries</p>
                                @endif
                                <div class="table-responsive-md  table-responsive">
                                    @if(count($subscriptionList)>0)
                                    <table id="subscription_listing" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>@sortablelink('title','Title')</th>
                                                <th>@sortablelink('description','Description')</th>
                                                <th>price</th>
                                                <th>@sortablelink('recurring_payment','Recurring Payment')</th>
                                                <th>@sortablelink('subscribe_by_default','Subscribe By Default')</th>
                                                <th>@sortablelink('status','Status')</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $j = $subscriptionList->firstItem();
                                            @endphp 
                                            @foreach($subscriptionList as $val)
                                                @php
                                                    $price = array();   
                                                @endphp
                                                @if(count($val->subscriptionPrice)>0)
                                                    @foreach($val->subscriptionPrice as $k => $v)
                                                        @php
                                                            $period = ' ';
                                                            if($v->currency == 1 || $v->currency == 3){
                                                                $period = $subscription_period_1[$v->period];
                                                            }elseif($v->currency == 2 || $v->currency == 4){
                                                                $period = $subscription_period_2[$v->period];
                                                            }
                                                            $price[] = $subscription_currency[$v->currency].' '.$v->price.'('.$period .')';
                                                        @endphp
                                                    @endforeach
                                                @endif
                                            <tr id="{{$val->id}}">
                                                <td>{{$j}}</td>
                                                <td>{{$val->title}}</td>
                                                <td>{{$val->description}}</td>
                                                <td>{{(count($price)>0)?implode(", ",$price):''}}</td>
                                                <td>{{$recurring_payment_opt[$val->recurring_payment]}}</td>
                                                <td>{{($val->subscribe_by_default == 1 && $val->subscribe_by_default != '')?'Enable':'Disable'}}</td>
                                                <td>{{$status[$val->status]}}</td>
                                                <td>
                                                    <a href="{{url('admin/subscription/edit/'.$val->id)}}" title='Edit Advertise' data-id='{{$val->id}}' class='edit_subscription'><i class="fa fa-edit"></i></a>
                                                    <a href="javascript:void(0);" title='Delete Advertise' class='delete_subscription' data-id='{{$val->id}}'><i class="fa fa-trash"></i></a>
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
                                @if($subscriptionList && !empty($subscriptionList))
                                    <div class="pt-4">{!! $subscriptionList->appends(\Request::except('page'))->render() !!}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</section>
@endsection
@section('javascript')
<script src="{{ asset('js/admin_subscription.js') }}"></script>
@endsection
@extends('admin.layout.final')
@section('title')
    Edit Subscription Plan
@endsection
@section('pageTitle')
    Edit  Subscription Plan
@endsection
@php
    $language = config('constant.language');
    $status = config('constant.status');
    $gender = config('constant.gender');
    $recurring_payment_opt = config('constant.recurring_payment_opt');
    $recurring_payment_opt = config('constant.recurring_payment_opt');
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
                      <h6 class="card-title">Edit Subscription Plan</h6>
                    </div>
                    <form class="form-horizontal" method="post" action="{{route('updateSubscription',$getSubscription[0]->id)}}" name="edit_subscription_plan" id="edit_subscription_plan">
                        @csrf
                        <input type="hidden" class="totalLanguage" id="totalLanguage" value="{{count($language)}}">
                        
                        <div class="card-body">
                            @include('admin.subscription.edit_subscription_plan_html')
                            <div class="row ">
                                @include('admin.subscription.edit_subscription_price_html')
                            </div>
                            <div class="row">
                                <div class="form-group col-lg col-md-6 col-sm-6">
                                    <label for="gender">Free For Gender</label>
                                    <select  class="form-control select2" name="free_for_gender[]" multiple="mutiple">
                                        <option value="">Select The Option</option>
                                        @foreach($gender as $gKey => $gVal)
                                        <option value="{{$gKey}}" {{(in_array($gKey,json_decode($getSubscription[0]->free_gender)))?'selected':''}}>{{$gVal}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('free_for_gender'))
                                        <div class="error">{{ $errors->first('free_for_gender') }}</div>
                                    @endif
                                </div>
                                <div class="form-group col-lg col-md-6 col-sm-6">
                                    <label for="rec">Recurring Payment</label>
                                    <select  class="form-control" name="recurring_payment" >
                                        <option value="">Select Recurring Payment</option>
                                        @foreach($recurring_payment_opt as $rKey => $rVal)
                                            <option value="{{$rKey}}" {{($getSubscription[0]->recurring_payment == $rKey)?'selected':''}}>{{$rVal}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('recurring_payment'))
                                        <div class="error">{{ $errors->first('recurring_payment') }}</div>
                                    @endif                                   
                                </div>
                            </div>
                            <div class="row pt-3">
                                <div class="form-group col-lg col-md-4 col-sm-4">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="status"  name='status' {{($getSubscription[0]->status == 1)?'checked':''}} value='1'>
                                        <label class="custom-control-label" for="status" >Subscription Plan Status</label>
                                        @if ($errors->has('status'))
                                            <div class="error">{{ $errors->first('status') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group col-lg col-md-4 col-sm-4">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="subscribe_by_default"  name='subscribe_by_default' 
                                               value="1" {{($getSubscription[0]->subscribe_by_default == 1)?'checked':''}}>
                                        <label class="custom-control-label" for="subscribe_by_default" >Subscribe By Default</label>
                                        @if ($errors->has('subscribe_by_default'))
                                            <div class="error">{{ $errors->first('subscribe_by_default') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div><br>
                            <h3><span>Feature List</span></h3>
                            @php $qtyValArray = array();@endphp
                            @if($getSubscription[0]->subscriptionFeatureQty)
                                @foreach($getSubscription[0]->subscriptionFeatureQty as $qtyKey => $qtyVal)
                                    @php $qtyValArray[$qtyVal->subscription_feature] = $qtyVal->quantity;@endphp
                                @endforeach
                            @endif
                            <div class="row pt-3">
                                <div class="row swipe_with_like_dislike_wrap pl-2">
                                    <div class="form-group col-lg col-md-6 col-sm-6">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="swipe_with_like_dislike"  name='feature[]' 
                                                   value="1" {{($getSubscription[0]->swipe_with_like_dislike == 1)?'checked':''}}>
                                            <label class="custom-control-label swipe_with_like_dislike_label" for="swipe_with_like_dislike" >Number of users they can swipe through (Like or Dislike)</label>
                                        </div>
                                    </div>
                                    @if($getSubscription[0]->swipe_with_like_dislike == 1)
                                        <input type="text" class="form-control col-3 ml-5" placeholder="Quantity" 
                                               name="like_dislike_qty" id="like_dislike_qty" value="{{(count($qtyValArray)>0?$qtyValArray[1]:'')}}"> 
                                    @endif
                                </div>
                            </div>
                            <div class="row pt-3">
                                <div class="form-group col-lg col-md-6 col-sm-6 ">
                                    <span class="who_viewed_me_wrap">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="who_viewed_me"  name='feature[]' value="7"  
                                                   {{($getSubscription[0]->who_viewed_me == 1)?'checked':''}}>
                                            <label class="custom-control-label" for="who_viewed_me" >Who viewed Me?</label>
                                        </div>
                                        @if($getSubscription[0]->who_viewed_me == 1)
                                        <input type="text" class="form-control col-3 ml-5" placeholder="Quantity" name="who_viewed_me_qty"
                                                id="who_viewed_me_qty"  value="{{(count($qtyValArray)>0?$qtyValArray[7]:'')}}"> 
                                        @endif
                                    </span>
                                    <label id="who_viewed_me_qty-error" class="error" for="who_viewed_me_qty"></label>
                                </div>
                                <div class="form-group col-lg col-md-6 col-sm-6 ">
                                    <span class="photo_upload_wrap">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="photo_upload"  name='feature[]' value="2"
                                                   {{($getSubscription[0]->photo_upload == 1)?'checked':''}}>
                                            <label class="custom-control-label" for="photo_upload" >Number of photo user can upload</label>
                                        </div>
                                        @if($getSubscription[0]->photo_upload == 1)
                                        <input type="text" class="form-control col-3 ml-5" placeholder="Quantity" 
                                               name="photo_upload_qty" id="photo_upload_qty"  value="{{(count($qtyValArray)>0?$qtyValArray[2]:'')}}">
                                        @endif
                                    </span>
                                    <label id="photo_upload_qty-error" class="error" for="photo_upload_qty"></label>
                                </div>
                            </div>
                            <div class='row pt-3'>
                                <div class="form-group col-lg col-md-6 col-sm-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="send_mail"  name='feature[]'   value="3"
                                               {{($getSubscription[0]->send_mail == 1)?'checked':''}}>
                                        <label class="custom-control-label" for="send_mail" >Send Mail to other Members</label>
                                    </div>
                                </div>
                                <div class="form-group col-lg col-md-6 col-sm-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="instant_message"   name='feature[]'  value="4"
                                               {{($getSubscription[0]->instant_message == 1)?'checked':''}}>
                                        <label class="custom-control-label" for="instant_message" >Instant Messaging Capability </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row pt-3">
                                <div class="form-group col-lg col-md-6 col-sm-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="live_video_chat"  name='feature[]' value="5"
                                               {{($getSubscription[0]->live_video_chat == 1)?'checked':''}}>
                                        <label class="custom-control-label" for="live_video_chat" >Live Video Chat</label>
                                    </div>
                                </div>
                                <div class="form-group col-lg col-md-6 col-sm-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="coaching"  name='feature[]' value="6"
                                               {{($getSubscription[0]->coaching == 1)?'checked':''}}>
                                        <label class="custom-control-label" for="coaching" >Coaching </label>
                                    </div>
                                </div>
                            </div><br class='remove'>
                            @if(count($language) !=  count($getSubscription))
                            <button type="button" class="btn btn-success float-left add_subscri_plan_in_another_lang">
                                <i class="fas fa-plus"></i> Add In Another language
                            </button>
                            @endif
                            <br class='remove'>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{route('subscriptionListing')}}">
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
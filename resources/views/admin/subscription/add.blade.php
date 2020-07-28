@extends('admin.layout.final')
@section('title')
    Add Subscription Plan
@endsection
@section('pageTitle')
    Add  Subscription Plan
@endsection
@php
    $language = config('constant.language');
    $status = config('constant.status');
    $gender = config('constant.gender');
    $recurring_payment_opt = config('constant.recurring_payment_opt');
    $subscription_currency = config('constant.subscription_currency');
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
                      <h6 class="card-title">Add Subscription Plan</h6>
                    </div>
                    <form class="form-horizontal" method="post" action="{{route('storeSubscription')}}" name="add_subscription_plan" id="add_subscription_plan">
                        @csrf
                        <input type="hidden" class="totalLanguage" id="totalLanguage" value="{{count($language)}}">
                        <div class="card-body">
                            @include('admin.subscription.add_subscription_plan_html')
                            <div class="row ">
                                @include('admin.subscription.subscription_price_html')
                            </div>
                            
                            <div class="row">
                                <div class="form-group col-lg col-md-6 col-sm-6">
                                    <label for="gender">Free For Gender</label>
                                    <select  class="form-control select2" name="free_for_gender[]" multiple="mutiple">
                                        <option value="">Select The Option</option>
                                        @foreach($gender as $gKey => $gVal)
                                            <option value="{{$gKey}}">{{$gVal}}</option>
                                        @endforeach
                                    </select>
                                    <label id="free_for_gender[]-error" class="error" for="free_for_gender[]"></label>
                                    @if ($errors->has('free_for_gender'))
                                        <div class="error">{{ $errors->first('free_for_gender') }}</div>
                                    @endif
                                </div>
                                <div class="form-group col-lg col-md-6 col-sm-6">
                                    <label for="rec">Recurring Payment</label>
                                    <select  class="form-control" name="recurring_payment" >
                                        <option value="">Select Recurring Payment</option>
                                        @foreach($recurring_payment_opt as $rKey => $rVal)
                                            <option value="{{$rKey}}">{{$rVal}}</option>
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
                                        <input type="checkbox" class="custom-control-input" id="status"  name='status' checked value='1'>
                                        <label class="custom-control-label" for="status" >Subscription Plan Status</label>
                                        @if ($errors->has('status'))
                                            <div class="error">{{ $errors->first('status') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group col-lg col-md-4 col-sm-4">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="subscribe_by_default"  name='subscribe_by_default' value="1">
                                        <label class="custom-control-label" for="subscribe_by_default" >Subscribe By Default</label>
                                        @if ($errors->has('subscribe_by_default'))
                                            <div class="error">{{ $errors->first('subscribe_by_default') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div><br>
                            <h3><span>Feature List</span></h3>
                            <div class='row'>
                                @if ($errors->has('feature[]'))
                                    <div class="error">{{ $errors->first('feature[]') }}</div>
                                @endif
                                <label id="feature[]-error" class="error" for="feature[]"></label>
                            </div>
                            <div class="row pt-3">
                                <div class="form-group col-lg col-md-4 col-sm-4 pr-3">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="swipe_with_like_dislike"  name='feature[]' value="1">
                                        <label class="custom-control-label swipe_with_like_dislike_label" for="swipe_with_like_dislike" >Number of users they can swipe through (Like or Dislike)</label>
                                    </div>
                                </div>
                                <div class="form-group col-lg col-md-4 col-sm-4">
                                        <div class="row">
                                            <div class="form-group col-lg col-md-4 col-sm-4  swipe_with_like_dislike_wrap"> </div>
                                            <div class="form-group col-lg col-md-4 col-sm-4"></div>
                                            <div class="form-group col-lg col-md-4 col-sm-4"></div>
                                        </div>
                                    </div>
                            </div>
                            <div class="row pt-3">
                                <div class="form-group col-lg col-md-4 col-sm-4 ">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="who_viewed_me"  name='feature[]' value="7">
                                        <label class="custom-control-label" for="who_viewed_me" >Who viewed Me?</label>
                                    </div>
                                </div>
                                <div class="form-group col-lg col-md-4 col-sm-4">
                                    <div class="row">
                                        <div class="form-group col-lg col-md-4 col-sm-4  who_viewed_me_wrap"> </div>
                                        <div class="form-group col-lg col-md-4 col-sm-4"></div>
                                        <div class="form-group col-lg col-md-4 col-sm-4"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row pt-3">
                                <div class="form-group col-lg col-md-4 col-sm-4 ">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="photo_upload"  name='feature[]' value="2">
                                        <label class="custom-control-label" for="photo_upload" >Number of photo user can upload</label>
                                    </div>
                                </div>
                                <div class="form-group col-lg col-md-4 col-sm-4">
                                    <div class="row">
                                        <div class="form-group col-lg col-md-4 col-sm-4  photo_upload_wrap"> </div>
                                        <div class="form-group col-lg col-md-4 col-sm-4"></div>
                                        <div class="form-group col-lg col-md-4 col-sm-4"></div>
                                    </div>
                                </div>
                            </div>
                            <div class='row pt-3'>
                                <div class="form-group col-lg col-md-4 col-sm-4">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="send_mail"  name='feature[]'   value="3">
                                        <label class="custom-control-label" for="send_mail" >Send Mail to other Members</label>
                                    </div>
                                </div>
                                <div class="form-group col-lg col-md-4 col-sm-4">
                                    <div class="row">
                                        <div class="form-group col-lg col-md-4 col-sm-4"></div>
                                        <div class="form-group col-lg col-md-4 col-sm-4"></div>
                                        <div class="form-group col-lg col-md-4 col-sm-4"> </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row pt-3">
                                <div class="form-group col-lg col-md-4 col-sm-4">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="instant_message"   name='feature[]'  value="4">
                                        <label class="custom-control-label" for="instant_message" >Instant Messaging Capability </label>
                                    </div>
                                </div>
                                <div class="form-group col-lg col-md-4 col-sm-4">
                                    <div class="row">
                                        <div class="form-group col-lg col-md-4 col-sm-4"> </div>
                                        <div class="form-group col-lg col-md-4 col-sm-4"> </div>
                                        <div class="form-group col-lg col-md-4 col-sm-4"> </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row pt-3">
                                <div class="form-group col-lg col-md-4 col-sm-4">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="live_video_chat"  name='feature[]' value="5">
                                        <label class="custom-control-label" for="live_video_chat" >Live Video Chat</label>
                                    </div>
                                </div>
                                <div class="form-group col-lg col-md-4 col-sm-4">
                                    <div class="row">
                                        <div class="form-group col-lg col-md-4 col-sm-4"> </div>
                                        <div class="form-group col-lg col-md-4 col-sm-4"> </div>
                                        <div class="form-group col-lg col-md-4 col-sm-4"> </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row pt-3">
                                <div class="form-group col-lg col-md-4 col-sm-4">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="coaching"  name='feature[]' value="6">
                                        <label class="custom-control-label" for="coaching" >Coaching </label>
                                    </div>
                                </div>
                                <div class="form-group col-lg col-md-4 col-sm-4">
                                    <div class="row">
                                        <div class="form-group col-lg col-md-4 col-sm-4"> </div>
                                        <div class="form-group col-lg col-md-4 col-sm-4"> </div>
                                        <div class="form-group col-lg col-md-4 col-sm-4"> </div>
                                    </div>
                                </div>
                            </div>
                            <br class='remove'>
                            <button type="button" class="btn btn-success float-left add_subscri_plan_in_another_lang">
                                <i class="fas fa-plus"></i> Add In Another language
                            </button><br class='remove'>
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
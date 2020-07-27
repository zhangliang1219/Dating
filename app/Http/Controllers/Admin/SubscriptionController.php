<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\SubscriptionPlans;
use App\SubscriptionFeaturesQuantity;
use App\SubscriptionPrices;


class SubscriptionController  extends Controller
{
    public function subscriptionListing(Request $request) {
        $page_limit = ($request['page_range'])?$request['page_range']:config('constant.recordPerPage');
        $dataQuery = SubscriptionPlans::with('subscriptionPrice')
                        ->whereNull('subscription_plans.parent_id')->select('subscription_plans.*');
        
        if ($request->has('search_submit') && $request->search_submit != '') {
            if ($request->has('search_by_title') && $request->search_by_title != '') {
                $dataQuery->where('subscription_plans.title','LIKE','%'.$request->search_by_title.'%');
            }
            if ($request->has('search_by_recurring_payment') && $request->search_by_recurring_payment != '') {
                $dataQuery->where('subscription_plans.recurring_payment',$request->search_by_recurring_payment);
            }  
            if ($request->has('search_by_status') && $request->search_by_status != '') {
                $dataQuery->where('subscription_plans.status',$request->search_by_status);
            } 
            if ($request->has('search_by_subscribe_by_default') && $request->search_by_subscribe_by_default!= '') {
                $dataQuery->where('subscription_plans.subscribe_by_default',$request->search_by_subscribe_by_default);
            } 
        }
        if ($request->has('sort') && $request->input('sort') != '') {
            $subscriptionList = $dataQuery->sortable()->orderBy($request->input('sort'), $request->input('direction'))->paginate($page_limit);
        } else {
            $subscriptionList = $dataQuery->sortable()->orderBy('subscription_plans.id', 'desc')->paginate($page_limit);
        }
        return view('admin.subscription.index',compact('subscriptionList','request'));
    }
    
    public function addSubscriptionPlan(Request $request) {
        return view('admin.subscription.add');
    }
    
    public function subscriptionPriceHtml($rowNumber) { 
        $subscription_currency = config('constant.subscription_currency'); 
        return view('admin.subscription.subscription_price_html',compact('rowNumber','subscription_currency'));
    }
    
    public function subscriptionPeriod($rowNum ,$currency_id) { 
        $rowNumber = $rowNum;
        $subscription_period = array();
        $subscription_period_1 = config('constant.subscription_period_1');
        $subscription_period_2 = config('constant.subscription_period_2');
        if($currency_id == 1 || $currency_id == 3){
            $subscription_period = $subscription_period_1;
        }elseif($currency_id  == 2 || $currency_id == 4){
            $subscription_period = $subscription_period_2;
        }
        return $subscription_period;
    }
    
    public function subscriptionAddLangTextHtml($langRowNumber) {
        $language = config('constant.language');
        return view('admin.subscription.add_subscription_plan_html',compact('langRowNumber','language'));
    }
    
    public function storeSubscriptionPlan(Request $request) {
        try{
            $parent_id = NULL;
            if(count($request->language)>0){
                foreach($request->language as $key => $val){
                    $subscriptionPlans = new SubscriptionPlans();
                    $subscriptionPlans->parent_id = ($key == 0)?NULL:$parent_id;
                    $subscriptionPlans->title = $request->title[$key];
                    $subscriptionPlans->description = $request->short_desc[$key];
                    $subscriptionPlans->language_id = $request->language[$key];
                    $subscriptionPlans->free_gender = (isset($request->free_for_gender)?json_encode($request->free_for_gender):'');
                    $subscriptionPlans->recurring_payment = $request->recurring_payment;
                    $subscriptionPlans->status = (isset($request->status)?1:0);
                    $subscriptionPlans->subscribe_by_default = (isset($request->subscribe_by_default)?1:0);
                    $subscriptionPlans->swipe_with_like_dislike = (isset($request->feature)?(in_array (1,$request->feature)?1:0):0);
                    $subscriptionPlans->photo_upload = (isset($request->feature)?(in_array (2,$request->feature)?1:0):0);
                    $subscriptionPlans->send_mail = (isset($request->feature)?(in_array (3,$request->feature)?1:0):0);
                    $subscriptionPlans->instant_message =(isset($request->feature)?(in_array (4,$request->feature)?1:0):0);
                    $subscriptionPlans->live_video_chat = (isset($request->feature)?(in_array (5,$request->feature)?1:0):0);
                    $subscriptionPlans->coaching = (isset($request->feature)?(in_array (6,$request->feature)?1:0):0);
                    $subscriptionPlans->who_viewed_me = (isset($request->feature)?(in_array (7,$request->feature)?1:0):0);
                    $subscriptionPlans->created_by = Auth::user()->id;
                    $subscriptionPlans->save();
                    if(count($request->price)>0){
                        foreach($request->price as $priceKey => $priceVal){
                            $subscriptionPrices  = new SubscriptionPrices();
                            $subscriptionPrices->subscription_id  = $subscriptionPlans->id;
                            $subscriptionPrices->price  = $request->price[$priceKey];
                            $subscriptionPrices->period  = $request->period[$priceKey];
                            $subscriptionPrices->currency  = $request->currency[$priceKey];
                            $subscriptionPrices->save();
                        }
                    }
                    if(isset($request->like_dislike_qty) && $request->like_dislike_qty != ''){
                        $subscriptionFeatureQty  = new SubscriptionFeaturesQuantity();
                        $subscriptionFeatureQty->subscription_id         = $subscriptionPlans->id;
                        $subscriptionFeatureQty->subscription_feature  = 1;
                        $subscriptionFeatureQty->quantity             = $request->like_dislike_qty;
                        $subscriptionFeatureQty->save();
                    }
                    if(isset($request->who_viewed_me_qty) && $request->who_viewed_me_qty != ''){
                        $subscriptionFeatureQty  = new SubscriptionFeaturesQuantity();
                        $subscriptionFeatureQty->subscription_id         = $subscriptionPlans->id;
                        $subscriptionFeatureQty->subscription_feature  = 7;
                        $subscriptionFeatureQty->quantity             = $request->who_viewed_me_qty;
                        $subscriptionFeatureQty->save();
                    }
                    if(isset($request->photo_upload_qty) && $request->photo_upload_qty != ''){
                        $subscriptionFeatureQty  = new SubscriptionFeaturesQuantity();
                        $subscriptionFeatureQty->subscription_id         = $subscriptionPlans->id;
                        $subscriptionFeatureQty->subscription_feature  = 2;
                        $subscriptionFeatureQty->quantity             = $request->photo_upload_qty;
                        $subscriptionFeatureQty->save();
                    }
                    if($key == 0 ){
                        $parent_id = $subscriptionPlans->id;
                    }
                }
            }
            Session::flash('success', 'Subscription Plan added successfully.');
            return redirect(url('/admin/subscription' ));
        }catch(Exception $e){
            Session::flash('error',  'Something is wrong.Please try again!');
            return Redirect::to('');;
        }
    }
    public function subscriptionDelete(Request $request) {
        try{
            $subscriptionPlan = SubscriptionPlans::find($request->subscriptionId);
            $diffLangSubscriptionPlan = SubscriptionPlans::where('parent_id',$request->subscriptionId)->pluck('id');
            if($subscriptionPlan){
                $subscriptionPlanPrice = SubscriptionPrices::where('subscription_id',$request->subscriptionId)->pluck('id');
                if($subscriptionPlanPrice){
                    SubscriptionPrices::whereIn('id',$subscriptionPlanPrice)->delete();
                }
                $subscriptionPlan->delete();
            }
            if(count($diffLangSubscriptionPlan)>0){
                $diffLangSubscriptionPlanPrice = SubscriptionPrices::whereIn('subscription_id',$diffLangSubscriptionPlan)->pluck('id');
                if($diffLangSubscriptionPlanPrice){
                    SubscriptionPrices::whereIn('id',$diffLangSubscriptionPlanPrice)->delete();
                }
                SubscriptionPlans::whereIn('id',$diffLangSubscriptionPlan)->delete();
            }
            return Response::json(array('message'=>'Subscription Plan Deleted Successfully','status'=>'success'));
        }catch(Exception $e){
            return Response::json(array('message'=>'Something is wrong.Please try again!','status'=>'error'));
        }
    }
    
    public function editSubscriptionPlan(Request $request,$id) {
        $getSubscription = SubscriptionPlans::with(['subscriptionPrice','subscriptionFeatureQty'])
                        ->where('subscription_plans.id',$id)->orWhere('subscription_plans.parent_id',$id)->get();
        return view('admin.subscription.edit',compact('getSubscription'));
    }
    
    public function updateSubscription(Request $request,$id) {
        try{
            $parent_id = NULL;
            if(count($request->language)>0){
                foreach($request->language as $key => $val){
                    $subscriptionPlans = SubscriptionPlans::find($request->subscriptionId[$key]);
                    $subscriptionPlans->title = $request->title[$key];
                    $subscriptionPlans->description = $request->short_desc[$key];
                    $subscriptionPlans->language_id = $val;
                    $subscriptionPlans->free_gender = (isset($request->free_for_gender)?json_encode($request->free_for_gender):'');
                    $subscriptionPlans->recurring_payment = $request->recurring_payment;
                    $subscriptionPlans->status = (isset($request->status)?1:0);
                    $subscriptionPlans->subscribe_by_default = (isset($request->subscribe_by_default)?1:0);
                    $subscriptionPlans->swipe_with_like_dislike = (isset($request->feature)?(in_array (1,$request->feature)?1:0):0);
                    $subscriptionPlans->photo_upload = (isset($request->feature)?(in_array (2,$request->feature)?1:0):0);
                    $subscriptionPlans->send_mail = (isset($request->feature)?(in_array (3,$request->feature)?1:0):0);
                    $subscriptionPlans->instant_message =(isset($request->feature)?(in_array (4,$request->feature)?1:0):0);
                    $subscriptionPlans->live_video_chat = (isset($request->feature)?(in_array (5,$request->feature)?1:0):0);
                    $subscriptionPlans->coaching = (isset($request->feature)?(in_array (6,$request->feature)?1:0):0);
                    $subscriptionPlans->who_viewed_me = (isset($request->feature)?(in_array (7,$request->feature)?1:0):0);
                    $subscriptionPlans->save();

                    if(count($request->price)>0){
                        SubscriptionPrices::where('subscription_id',$request->subscriptionId[$key])->delete();
                        foreach($request->price as $priceKey => $priceVal){
                            $subscriptionPrices  =  new SubscriptionPrices();
                            $subscriptionPrices->subscription_id  = $request->subscriptionId[$key];
                            $subscriptionPrices->price  = $request->price[$priceKey];
                            $subscriptionPrices->period  = $request->period[$priceKey];
                            $subscriptionPrices->currency  = $request->currency[$priceKey];
                            $subscriptionPrices->save();
                        }
                    }
                    if(isset($request->like_dislike_qty) && $request->like_dislike_qty != ''){
                        $subscriptionFeatureQty  = SubscriptionFeaturesQuantity::where('subscription_id',$request->subscriptionId[$key])
                                                                               ->where('subscription_feature',1)->first();
                        if(!$subscriptionFeatureQty){
                            $subscriptionFeatureQty = new SubscriptionFeaturesQuantity();
                            $subscriptionFeatureQty->subscription_id       = $request->subscriptionId[$key];
                            $subscriptionFeatureQty->subscription_feature  = 1;
                        }
                        $subscriptionFeatureQty->quantity             = $request->like_dislike_qty;
                        $subscriptionFeatureQty->save();
                    }else{
                        SubscriptionFeaturesQuantity::where('subscription_id',$request->subscriptionId[$key])
                                                                               ->where('subscription_feature',1)->delete();
                    }
                    
                    if(isset($request->who_viewed_me_qty) && $request->who_viewed_me_qty != ''){
                        $subscriptionFeatureQty  = SubscriptionFeaturesQuantity::where('subscription_id',$request->subscriptionId[$key])
                                                                               ->where('subscription_feature',7)->first();
                        if(!$subscriptionFeatureQty){
                            $subscriptionFeatureQty = new SubscriptionFeaturesQuantity();
                            $subscriptionFeatureQty->subscription_id       = $request->subscriptionId[$key];
                            $subscriptionFeatureQty->subscription_feature  = 7;
                        }
                        $subscriptionFeatureQty->quantity             = $request->who_viewed_me_qty;
                        $subscriptionFeatureQty->save();
                    }else{
                        SubscriptionFeaturesQuantity::where('subscription_id',$request->subscriptionId[$key])
                                                                               ->where('subscription_feature',7)->delete();
                    }
                    
                    if(isset($request->photo_upload_qty) && $request->photo_upload_qty != ''){
                        $subscriptionFeatureQty  = SubscriptionFeaturesQuantity::where('subscription_id',$request->subscriptionId[$key])
                                                                               ->where('subscription_feature',2)->first();
                        if(!$subscriptionFeatureQty){
                            $subscriptionFeatureQty = new SubscriptionFeaturesQuantity();
                            $subscriptionFeatureQty->subscription_id       = $request->subscriptionId[$key];
                            $subscriptionFeatureQty->subscription_feature  = 2;
                        }
                        $subscriptionFeatureQty->quantity             = $request->photo_upload_qty;
                        $subscriptionFeatureQty->save();
                    }else{
                        SubscriptionFeaturesQuantity::where('subscription_id',$request->subscriptionId[$key])
                                                                               ->where('subscription_feature',2)->delete();
                    }
                    
                }
            }
            Session::flash('success', 'Subscription Plan updated successfully.');
            return redirect(url('/admin/subscription' ));
        }catch(Exception $e){
            Session::flash('error',  'Something is wrong.Please try again!');
            return Redirect::to('');;
        }
    }
    
    
    public function deleteSubscriptionPrice(Request $request) {
        try{
            $subscriptionPlanPrice = SubscriptionPrices::find($request->data_subscr_price_id);
            if($subscriptionPlanPrice){
                $subscriptionPlanPrice->delete();
            }
            return Response::json(array('message'=>'Subscription Plan Price Deleted Successfully','status'=>'success'));
        }catch(Exception $e){
            return Response::json(array('message'=>'Something is wrong.Please try again!','status'=>'error'));
        }
    }
    
}


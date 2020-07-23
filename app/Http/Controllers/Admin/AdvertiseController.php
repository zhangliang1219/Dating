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
use App\Advertise;


class AdvertiseController  extends Controller
{
    public function advertiseListing(Request $request) {
        $page_limit = ($request['page_range'])?$request['page_range']:config('constant.recordPerPage');
        $dataQuery = Advertise::whereNull('parent_id');
        
        if ($request->has('search_submit') && $request->search_submit != '') {
            if ($request->has('search_by_title') && $request->search_by_title != '') {
                $dataQuery->where('title','LIKE','%'.$request->search_by_title.'%');
            }
            if ($request->has('search_by_ad_type') && $request->search_by_ad_type != '') {
                $dataQuery->where('ad_type',$request->search_by_ad_type);
            }
            if ($request->has('search_by_ad_status') && $request->search_by_ad_status != '') {
                $dataQuery->where('ad_status',$request->search_by_ad_status);
            }
        }
            
        if ($request->has('sort') && $request->input('sort') != '') {
            $getAdvertise = $dataQuery->sortable()->orderBy($request->input('sort'), $request->input('direction'))->paginate($page_limit);
        } else {
            $getAdvertise = $dataQuery->sortable()->orderBy('id', 'desc')->paginate($page_limit);
        }
        return view('admin.advertise.index',compact('getAdvertise','request'));
    }
    
    public function addAdvertise() {
        return view('admin.advertise.add');
    }
    
    public function storeAdvertise(Request $request) {
        try{
            
            $validator = Validator::make($request->all(), [
                'title_name.*' => 'required',
                'ad_type.*' => 'required',
                'ads_file.*' => 'required|mimes:mp4,mov,ogg,gif,ief,jpeg,png,avi',
            ]);
            if($validator->fails()){
                return redirect('admin/advertise/add')
                            ->withErrors($validator)
                            ->withInput();
            }
            $ads_file_name = $file_type = $parent_id = '';
            if(count($request->file('ads_file'))>0){
                foreach($request->file('ads_file') as $key => $val){
                    $ads_file = $val;
                    $getMimeType = explode("/",$ads_file->getMimeType());
                    $file_type = $getMimeType[0];
                    $ads_file_name = time().'_'.$request->language[$key].'.'.$ads_file->getClientOriginalExtension();
                    $destinationPath = public_path('/images/advertise');
                    $ads_file->move($destinationPath, $ads_file_name);
                    
                    $ads = new Advertise();
                    $ads->title          = $request->title_name[$key];
                    $ads->parent_id      = ($key == 0)?NULL:$parent_id;
                    $ads->ad_type        = $request->ad_type[$key];
                    $ads->ad_status      = $request->ad_status[$key];
                    $ads->language_id    = $request->language[$key];
                    $ads->file_type      = $file_type;
                    $ads->file_name	 = $ads_file_name;
                    $ads->created_by     =  Auth::user()->id;
                    $ads->save();
                    if($key == 0 ){
                        $parent_id = $ads->id;
                    }
                }
            }
            Session::flash('success', 'Advertise added successfully.');
            return redirect(url('/admin/advertise' ));
            
       }catch(Exception $e){
            Session::flash('error',  'Something is wrong.Please try again!');
            return Redirect::to('');;
        }
    }
    
    public function addAdvertiseForm($ads_form_last_id) {
        $language = config('constant.language');
        $ad_type = config('constant.ad_type');
        $ad_status = config('constant.ad_status');
        $id = $ads_form_last_id + 1;
        return view('admin.advertise.add_form_html',compact('language','ad_type','id','ad_status'));
    }
    
    public function editAdvertise(Request $request,$id) {
        $getAds = Advertise::where('advertise.id',$id)->orWhere('parent_id',$id)->get();
        return view('admin.advertise.edit',compact('getAds'));
    }
    
    public function updateAdvertise(Request $request,$id) {
        try{
            
            $validator = Validator::make($request->all(), [
                'title_name.*' => 'required',
                'ad_type.*' => 'required',
                'ads_file.*' => 'mimes:mp4,mov,ogg,gif,ief,jpeg,png,avi',
            ]);
            if($validator->fails()){
                return redirect('admin/advertise/edit/'.$id)
                            ->withErrors($validator)
                            ->withInput();
            }

            if(count($request->language) > 0){
                foreach($request->language as $key => $val){
                    if(isset($request->ads_file) && array_key_exists($key,$request->ads_file)){
                        $ads_file = $request->file('ads_file')[$key];
                        $getMimeType = explode("/",$ads_file->getMimeType());
                        $file_type = $getMimeType[0];
                        $ads_file_name = time().'_'.$val.'.'.$ads_file->getClientOriginalExtension();
                        $destinationPath = public_path('/images/advertise');
                        $ads_file->move($destinationPath, $ads_file_name);
                    }
                    
                    if(isset($request->adsId) && array_key_exists($key,$request->adsId)){
                        $ads   = Advertise::find($val);
                    }else{
                        $ads   = new Advertise();
                        $ads->parent_id  = $request->adsId[0];
                    }
                    $ads->title          = $request->title_name[$key];
                    $ads->ad_type        = $request->ad_type[$key];
                    $ads->ad_status      = $request->ad_status[$key];
                    $ads->language_id    = $val;
                    if(isset($request->ads_file) && array_key_exists($key,$request->ads_file)){
                        $ads->file_type      = $file_type;
                        $ads->file_name      = $ads_file_name;
                    }
                    $ads->save();
                }
            }
             Session::flash('success', 'Advertise updated successfully.');
            return redirect(url('/admin/advertise' ));
        }catch(Exception $e){
            Session::flash('error',  'Something is wrong.Please try again!');
            return Redirect::to('');;
        }
    }
    
    public function deleteAdvertise(Request $request) {
        try{
            $advertise = Advertise::find($request->advertiseId);
            $diffLangAdvertise = Advertise::where('parent_id',$request->advertiseId)->pluck('id');
            if($advertise){
                $advertise->delete();
            }
            if(count($diffLangAdvertise)>0){
                foreach($diffLangAdvertise as $val){
                    Advertise::find($val)->delete();
                }
            }
            return Response::json(array('message'=>'Advertise Deleted Successfully','status'=>'success'));
        }catch(Exception $e){
            return Response::json(array('message'=>'Something is wrong.Please try again!','status'=>'error'));
        }
    }
}


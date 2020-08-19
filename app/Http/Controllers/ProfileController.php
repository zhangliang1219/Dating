<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;
use App\SocialIdentity;
use App\Country;
use Illuminate\Support\Facades\Redirect;
use App\SearchHistory;
use App\UserPrivacySetting;
use App\UserInfoPrivacy;
use App\UserInfo;
use App\UserPhotos;
use App\UserDoc;

class ProfileController  extends Controller
{
    public function profileInfo() {
        $country = Country::all();
        $userInfo = UserInfo::where('user_id',Auth::user()->id)->first();
        $user = User::find(Auth::user()->id);
        $userPrivacySetting = UserPrivacySetting::where('privacy_option',1)->pluck('field_id')->toArray();
        $userInfoPrivacy = UserInfoPrivacy::where('privacy_option',1)->where('user_id',Auth::user()->id)->pluck('field_id')->toArray();
        $userPhoto = UserPhotos::where('user_id',Auth::user()->id)->get()->toArray();
        $userDoc = UserDoc::where('user_id',Auth::user()->id)->get()->toArray();
        return view('front.profile.index',compact('country','userInfo','user','userPrivacySetting','userInfoPrivacy','userPhoto','userDoc')); 
  }
  
    public function userProfile(Request $request,$id) {
        $userInfo = User::with('countryData')->where('users.id',$id)->first();
        return view('front.profile.user_profile',compact('userInfo'));
    }
  
    public function viewSearchProfile(Request $request){
        if(Auth::user() && Auth::user()->id_verify == 1 && Auth::user()->email_verify == 1 && Auth::user()->phone_verify == 1){
            $page_limit = ($request['page_range'])?$request['page_range']:config('constant.recordPerPage');
            $page_limit = 2;
            $searchProfile = array();
            if($request->age == '' && $request->height == ''&& $request->weight == ''&& $request->city == ''&& $request->country == ''
                    && $request->education == '' && $request->employment_status == '' && $request->ethnicity == ''&& $request->living_arrangement == ''){
                return view('front.search.index',compact('searchProfile','request')); 
            }
            $dataQuery = User::with('countryData')->where('users.id','!=',Auth::user()->id)->where('users.is_admin',0)->where('users.status',2);
            if(isset($request->age) || $request->age != ''){
                $age = explode(" - ",$request->age);
                if(count($age)>0){
                    $dataQuery->where('users.age','>=',trim($age[0]))->where('users.age','<=',trim($age[1]));
                }
            }
            if(isset($request->height) || $request->height != ''){
                $height = explode(" - ",$request->height);
                if(count($height)>0){
                    $dataQuery->where('users.height', '>=', trim($height[0]))->where('users.height','<=',trim($height[1]));
                }
            }
            if(isset($request->weight) || $request->weight != ''){
                $weight = explode(" - ",$request->weight);
                if(count($weight)>0){
                    $dataQuery->where('users.weight', '>=', trim($weight[0]))->where('users.weight','<=',trim($weight[1]));
                }
            }
            if(isset($request->city)){
                $city = $request->city;
                $dataQuery->where(function($dataQuery)use($city){
                    foreach($city as $val){
                        $dataQuery->Orwhere('users.city','LIKE','%'.$val.'%');
                    }
                });
            }if(isset($request->state)){
                $state = $request->state;
                $dataQuery->where(function($dataQuery)use($state){
                    foreach($state as $val){
                        $dataQuery->Orwhere('users.state','LIKE','%'.$val.'%');
                    }
                });
            }if(isset($request->country)){
                $country = $request->country;
                $dataQuery->whereIn('users.country',$country);
            }if(isset($request->education)){
                $dataQuery->whereIn('users.education',$request->education);
            }if(isset($request->employment_status) ){
                $dataQuery->whereIn('users.employment_status',$request->employment_status);
            }if(isset($request->ethnicity) ){
                $dataQuery->whereIn('users.ethnicity',$request->ethnicity);
            }if(isset($request->living_arrangement)){
                $dataQuery->whereIn('users.living_arrangement',$request->living_arrangement);
            }
            
            if(isset($request->profile_search) && isset($request->profile_search_text) && $request->profile_search_text != ''){
                $dataQuery->where('users.name','LIKE','%'.$request->profile_search_text.'%');
            }
            $userData = clone $dataQuery;
            $userData = $userData->get();
            
            $getData = SearchHistory::where('user_id',Auth::user()->id)->get()->count();
            if(count($userData)>0){
                if($getData == 10){
                    SearchHistory::where('user_id',Auth::user()->id)->orderBy("id", "ASC")->take(1)->forceDelete();
                }
                $searchHistory = New SearchHistory();
                $searchHistory->user_id = Auth::user()->id;
                $searchHistory->search_data = json_encode($userData);
                $searchHistory->save();        
            }
            
            if ($request->has('sort') && $request->input('sort') != '') {
                $searchProfile = $dataQuery->sortable()->orderBy($request->input('sort'), $request->input('direction'))->paginate($page_limit);
            } else {
                $searchProfile = $dataQuery->sortable()->orderBy('users.id', 'desc')->paginate($page_limit);
            }            
            return view('front.search.index',compact('searchProfile','request')); 
        }else{
            return redirect('/profile')->with('success',"You'll need to complete your profile and verify your phone number,identity.");
        }
    }
    
    public function matchedProfile() {
        if(Auth::user() && Auth::user()->id_verify == 1 && Auth::user()->email_verify == 1 && Auth::user()->phone_verify == 1){
            $user = Auth::user();
            $matchProfile =  User::leftJoin('users as u','u.id','users.id')
                            ->where(function ($q)use($user) {
                                $q->where('u.gender',$user->wish_to_meet)
                                    ->where('u.wish_to_meet',$user->gender);
                            })
                            ->where(function ($q1)use($user) {
                                $q1->where(function ($q2)use($user) {
                                    foreach(explode(',',$user->preferred_age) as $val){
                                        $q2->orWhereRaw('FIND_IN_SET("'.$val.'",u.age)');
                                    }
                                })
                                ->whereRaw('FIND_IN_SET('.$user->age.',u.preferred_age)');
                            })
                            ->where(function ($q3)use($user) {
                                $q3->where(function ($q4)use($user) {
                                    foreach(explode(',',$user->preferred_height) as $val){
                                        $q4->orWhereRaw('FIND_IN_SET("'.$val.'",u.height)');
                                    }
                                })
                                ->whereRaw('FIND_IN_SET('.$user->height.',u.preferred_height)');
                            })
                            ->where(function ($q5)use($user) {
                                $q5->where(function ($q6)use($user) {
                                    foreach(explode(',',$user->preferred_weight) as $val){
                                        $q6->orWhereRaw('FIND_IN_SET("'.$val.'",u.weight)');
                                    }
                                })
                                ->whereRaw('FIND_IN_SET('.$user->weight.',u.preferred_weight)');
                            })
                        ->where('users.id','!=',Auth::user()->id)->where('is_admin',0)->where('status',2)->get();
        }else{
            return redirect('/profile')->with('success',"You'll need to complete your profile and verify your phone number,identity.");
        }
         
    }
  
    public function profileBannerUpload(Request $request) {
        if($request->file !=  ''){
            $profile_photo = $request->file;
            $profile_name = time().'.'.$profile_photo->getClientOriginalExtension();
            $destinationPath = public_path('/images/profile_banner');
            $profile_photo->move($destinationPath, $profile_name);
            
            $userInfo = UserInfo::where('user_id',Auth::user()->id)->first();
            if($userInfo === null){
                $userInfo = new UserInfo();
            }else{
                unlink( $destinationPath.'/'.$userInfo->profile_banner );
            }
            $userInfo->user_id = Auth::user()->id;
            $userInfo->profile_banner = $profile_name;
            $userInfo->save();
        }
    }
    public function profileImageUpload(Request $request) {
        if($request->file !=  ''){
            $profile_photo = $request->file;
            $profile_name = time().'.'.$profile_photo->getClientOriginalExtension();
            $destinationPath = public_path('/images/profile');
            $profile_photo->move($destinationPath, $profile_name);
            
            $user = User::find(Auth::user()->id);
            $user->photo = $profile_name;
            $user->save();
        }
    }
    
    public function profileAboutMeUpload(Request $request) {
        $validator =  Validator::make($request->all(), [
            'profile_about_me_txt' => 'required'
        ]); 
        if ($validator->fails()) {
            return redirect('/profile')
                        ->withErrors($validator)
                        ->withInput();
        }
        $userInfo = UserInfo::where('user_id',Auth::user()->id)->first();
        if($userInfo === null){
            $userInfo = new UserInfo();
        }
        $userInfo->about_me = $request->profile_about_me_txt;
        $userInfo->save();
        return redirect('/profile');
    }
    
    public function editProfile(Request $request,$id){
        try{
            $validator =  Validator::make($request->all(), [
                'wish_to_meet' => 'required',
                'preferred_age' => 'required',
                'wish_to_meet'=>'required', 
                'height'=> 'required',
                'weight'=> 'required',
                'living_arrangement' => 'required',         
                'city'=> 'required',         
                'state' => 'required',       
                'country' => 'required',          
                'favorite_sport' => 'required',          
                'high_school_attended' => 'required',          
                'collage'=> 'required',      
                'employment_status' => 'required',        
                'education' => 'required',      
                'build' =>'required',        
                'children' => 'required',          
                'ethnicity'=>'required',     
                'relationship'=>'required',     
                'describe_perfect_date'=>'required|max: 1000', 
            ]); 
            if ($validator->fails()) {
                return redirect('/profile')
                            ->withErrors($validator)
                            ->withInput();
            }
            $user = User::find($id);
            $user->ethnicity = (isset($request->ethnicity)?($request->ethnicity):NULL);
            $user->ethnicity_other = (isset($request->ethnicity_other)?($request->ethnicity_other):NULL);
            $user->height = (isset($request->height)?$request->height:NULL);
            $user->weight = (isset($request->weight)?$request->weight:NULL);
            $user->build = (isset($request->build)?$request->build:NULL);
            $user->build_other = (isset($request->build_other)?$request->build_other:NULL);
            $user->relationship = (isset($request->relationship)?$request->relationship:NULL);
            $user->living_arrangement = (isset($request->living_arrangement)?$request->living_arrangement:NULL);
            $user->city = (isset($request->city)?$request->city:NULL);
            $user->state = (isset($request->state)?$request->state:NULL);
            $user->country = (isset($request->country)?$request->country:NULL);
            $user->favorite_sport = (isset($request->favorite_sport)?$request->favorite_sport:NULL);
            $user->high_school_attended = (isset($request->high_school_attended)?$request->high_school_attended:NULL);
            $user->collage = (isset($request->collage)?$request->collage:NULL);
            $user->employment_status = (isset($request->employment_status)?$request->employment_status:NULL);
            $user->education = (isset($request->education)?$request->education:NULL);
            $user->children = (isset($request->children)?$request->children:NULL);
            $user->describe_perfect_date = (isset($request->describe_perfect_date)?$request->describe_perfect_date:NULL);
            $user->save();
            
            $userInfo = UserInfo::where('user_id',$id)->first();
            if($userInfo === null){
                $userInfo = new UserInfo();
            }
            $userInfo->wish_to_meet = (isset($request->wish_to_meet)?$request->wish_to_meet:NULL);
            $preferred_age = explode(" - ",$request->preferred_age);
            if(count($preferred_age)>0){
                $userInfo->preferred_min_age = $preferred_age[0];
                $userInfo->preferred_max_age = $preferred_age[1];
            }
            $preferred_height = explode(" - ",$request->preferred_height);
            if(count($preferred_height)>0){
                $userInfo->preferred_min_height = $preferred_height[0];
                $userInfo->preferred_max_height = $preferred_height[1];
            }
            $preferred_weight = explode(" - ",$request->preferred_weight);
            if(count($preferred_weight)>0){
                $userInfo->preferred_min_weight = $preferred_weight[0];
                $userInfo->preferred_max_weight = $preferred_weight[1];
            }
            $userInfo->save();
            
            if(isset($request->user_info_privacy) && count($request->user_info_privacy)>0){
                foreach($request->user_info_privacy as $key => $val){
                    UserInfoPrivacy::where('user_id',$user->id)->where('field_id',$key)->forceDelete();
                    $userInfoPrivacy = new UserInfoPrivacy();
                    $userInfoPrivacy->user_id = $user->id;
                    $userInfoPrivacy->field_id =  $key;
                    $userInfoPrivacy->privacy_option =  $val;
                    $userInfoPrivacy->save();
                }
            }
            Session::flash('success', 'General Information Updated successfully.');
            return redirect(url('/profile' ));
        }catch(Exception $e){
            Session::flash('error', 'Something is wrong.Please try again!');
            return Redirect::to('');
        }
    }
    
    public function galleryPhotosUpload(Request $request) {
        $totalCount = $request->totalCount;
        if($totalCount != 0){
            $profile_name = '';
            for($i=0;$i<$totalCount;$i++){
                $fileData = 'fileData_'.$i;
                $filePrivacy = 'filePrivacy_'.$i;
                if($request->$fileData != '' && $request->$filePrivacy != ''){
                    $profile_photo = $request->$fileData;
                    $profile_name = time().'_'.$i.'.'.$profile_photo->getClientOriginalExtension();
                    $destinationPath = public_path('/images/profile_gallery_photo');
                    $profile_photo->move($destinationPath, $profile_name);

                    $userPhotos = new UserPhotos();
                    $userPhotos->user_id            = Auth::user()->id;
                    $userPhotos->photo_name  	= $profile_name;
                    $userPhotos->privacy_option	= $request->$filePrivacy;
                    $userPhotos->save();
                }
            }
        }
    }
    public function galleryPhotosDelete($id) {
        UserPhotos::where('id',$id)->delete();
    }
    
    public function galleryPhotosPrivacyUpdate($id,$checked) {
        $userPhotos = UserPhotos::find($id);
        $userPhotos->privacy_option	= $checked;
        $userPhotos->save();
    }
    public function phoneVerification(Request $request){
        $validator = Validator::make($request->all(), [
            'phoneNumber' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return redirect('/profile')
                        ->withErrors($validator)
                        ->withInput();
        }
        $user = User::find(Auth::user()->id);
        $user->phone = $request->phoneNumber;
        $user->save();
        return redirect('/profile')->with('success','OTP is sent to Your Mobile Number');
    }
    
    public function docVerification(Request $request){
        $validator = Validator::make($request->all(), [
            'doc_upload.*' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect('/profile')
                        ->withErrors($validator)
                        ->withInput();
        }
        $files = $request->doc_upload;
        if(count($files)>0){
            $doc_name = $doc_type = '';
            foreach ($files as $key => $file) { 
                $ext = $file->getClientOriginalExtension();
                $doc_type = 'application';
                if(in_array($ext,array('TIFF','JPEG','GIF','PNG','PDF'))){
                    $doc_type = 'image';
                }
                
                $doc_name = time().'_'.$key.'.'.$file->getClientOriginalExtension();
                $destinationPath = public_path('/user_doc');
                $file->move($destinationPath, $doc_name);
                
                $userDoc = new UserDoc();
                $userDoc->user_id = Auth::user()->id;
                $userDoc->doc_name = $doc_name;
                $userDoc->doc_type = $doc_type;
                $userDoc->save();
            }
        }
        return redirect('/profile')->with('success',"Your documents upload successfully and it's under verification.");
    }
}


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

class ProfileController  extends Controller
{
    public function profileInfo() {
    if(Auth::user() && Auth::user()->id_verify == 1 && Auth::user()->email_verify == 1 && Auth::user()->phone_verify == 1){
        $country = Country::all();
        $userInfo = UserInfo::where('user_id',Auth::user()->id)->first();
        $user = User::find(Auth::user()->id);
        return view('front.profile.index',compact('country','userInfo','user')); 
    }else{
        return redirect()->to('/general/info/'.Auth::user()->id);
    }
  }
  
    public function userProfile(Request $request,$id) {
    if(Auth::user() && Auth::user()->id_verify == 1 && Auth::user()->email_verify == 1 && Auth::user()->phone_verify == 1){
        $userInfo = User::with('countryData')->where('users.id',$id)->first();
        return view('front.profile.user_profile',compact('userInfo'));
    }else{
        return redirect()->to('/general/info/'.Auth::user()->id);
    }
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
                $dataQuery->where('users.age',$request->age);
            }if(isset($request->height) || $request->height != ''){
                $dataQuery->where('users.height',$request->height);
            }if(isset($request->weight) || $request->weight != ''){
                $dataQuery->where('users.weight',$request->weight);
            }if(isset($request->city) || $request->city != ''){
                $dataQuery->where('users.city','LIKE','%'.$request->city.'%');
            }if(isset($request->state) || $request->state != ''){
                $dataQuery->where('users.state','LIKE','%'.$request->state.'%');
            }if(isset($request->country) || $request->country != ''){
                $dataQuery->where('users.country',$request->country);
            }if(isset($request->education) || $request->education != ''){
                $dataQuery->where('users.education',$request->education);
            }if(isset($request->employment_status) || $request->employment_status != ''){
                $dataQuery->where('users.employment_status',$request->employment_status);
            }if(isset($request->ethnicity) || $request->ethnicity != ''){
                $dataQuery->where('users.ethnicity',$request->ethnicity);
            }if(isset($request->living_arrangement) || $request->living_arrangement != ''){
                $dataQuery->where('users.living_arrangement',$request->living_arrangement);
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
            return redirect()->to('/general/info/'.Auth::user()->id);
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
            return redirect()->to('/general/info/'.Auth::user()->id);
        }
         
    }
    
    public function generalProfileInfo(Request $request,$id){
        if(Auth::user() && Auth::user()->email_verify == 1 && Auth::user()->id_verify != 1 && Auth::user()->phone_verify != 1 ){
            $country = Country::all();
            $userPrivacySetting = UserPrivacySetting::where('privacy_option',1)->pluck('field_id')->toArray();
            return view('front.profile.general_info',compact('country','userPrivacySetting')); 
        }else{
           Session::flash('error', 'You do not have permission to perform this action!');
           return Redirect::to('/'); 
        }
    }
    
    public function generalProfileInfoStore(Request $request) {
        $validator =  Validator::make($request->all(), [
            'wish_to_meet'   => 'required',
            'phoneNumber' => 'required',
            'ethnicity'=> 'required',
            'relationship'=> 'required',
            'describe_perfect_date'=>'max: 1000',  
        ]); 
        if ($validator->fails()) {
            return redirect('/general/info/'.$request->user_id)
                        ->withErrors($validator)
                        ->withInput();
        }
        
        $user = User::find($request->user_id);
        $user->phone = (isset($request->phoneNumber)?$request->phoneNumber:NULL);
        $user->wish_to_meet = (isset($request->wish_to_meet)?$request->wish_to_meet:NULL);
        $user->preferred_age = (isset($request->preferred_age)? implode(",", $request->preferred_age):NULL);
        $user->preferred_height = (isset($request->preferred_height)? implode(",", $request->preferred_height):NULL);
        $user->preferred_weight = (isset($request->preferred_weight)? implode(",", $request->preferred_weight):NULL);
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
        return redirect('/home')->with('success','Your Profile Info saved successfully.');
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
        $userInfo = UserInfo::where('user_id',Auth::user()->id)->first();
        if($userInfo === null){
            $userInfo = new UserInfo();
        }
        $userInfo->about_me = $request->profile_about_me_txt;
        $userInfo->save();
        return redirect('/profile');
    }
}

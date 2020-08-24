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
use App\UserLikeDislike;

class ProfileController  extends Controller
{
    public function profileInfo(Request $request) {
        $country = Country::all();
        $userInfo = UserInfo::where('user_id',Auth::user()->id)->first();
        $user = User::find(Auth::user()->id);
        $userPrivacySetting = UserPrivacySetting::where('privacy_option',1)->pluck('field_id')->toArray();
        $userInfoPrivacy = UserInfoPrivacy::where('privacy_option',1)->where('user_id',Auth::user()->id)->pluck('field_id')->toArray();
        $userPhoto = UserPhotos::where('user_id',Auth::user()->id)->get();
        $userDoc = UserDoc::where('user_id',Auth::user()->id)->get()->toArray();
        $matchedProfile = $this->matchedProfile($request);
        if(count($matchedProfile['matchProfileWithPerc'])>0){
            session(['searchProfileIdArray' => array_keys($matchedProfile['matchProfileWithPerc'])]);
        }
        return view('front.profile.index',compact('country','userInfo','user','userPrivacySetting','userInfoPrivacy','userPhoto','userDoc',
                'matchedProfile','request')); 
    }
    
    public function userDislikedProfile(){
        $dislikedId = UserLikeDislike::where('user_id',Auth::user()->id)->where('user_like',2)->pluck('profile_id')->toArray();
        $dislikedId1 = UserLikeDislike::where('profile_id',Auth::user()->id)->where('user_like',2)->pluck('user_id')->toArray();
        $dislikedId2 = UserLikeDislike::where('user_id',Auth::user()->id)->where('profile_user_like',2)->pluck('profile_id')->toArray();
        $dislikedId3 = UserLikeDislike::where('profile_id',Auth::user()->id)->where('profile_user_like',2)->pluck('user_id')->toArray();
        $result =  $dislikedId + $dislikedId1 + $dislikedId2 + $dislikedId3;
        return $result;
    }

    public function userProfile($id) {
        if(!in_array($id,$this->userDislikedProfile())){
            $searchIdArray = session('searchProfileIdArray');
            $userInfo = User::with(['countryData','userInfoData'])->where('users.id',$id)->first();
            $userPhoto = UserPhotos::where('user_id',$id)->where('privacy_option',2)->get();
            $userLikeDislike = UserLikeDislike::where('user_id',$id)->get();
            return view('front.profile.user_profile',compact('userInfo','userPhoto','searchIdArray','userLikeDislike'));
        }else{
            return redirect('/home')->with('success',"Something is wrong.Please try again!");
        }
    }
    
    public function slideUserProfile($id) {
        $searchIdArray = session('searchProfileIdArray');
        $userInfo = User::with(['countryData','userInfoData'])->where('users.id',$id)->first();
        $userPhoto = UserPhotos::where('user_id',$id)->where('privacy_option',2)->get();
        $userLikeDislike = UserLikeDislike::where('user_id',$id)->get();
        return view('front.profile.single_user_profile_html',compact('userInfo','userPhoto','searchIdArray','userLikeDislike'));
    }
    
    public function likeDislikeStatus($userId,$profileId){
        $userLikeDislike = UserLikeDislike::where('user_id',$userId)->where('profile_id',$profileId)->first();
        $profileLikeDislike = UserLikeDislike::where('user_id',$profileId)->where('profile_id',$userId)->first();
       
        $result['userLike'] = 0;
        $result['profileLike'] = 0;
        $result['user_id'] = 0;
        if($userLikeDislike){
            if($userLikeDislike->user_like != '' && $userLikeDislike->user_id == Auth::user()->id){
                $result['userLike'] = (($userLikeDislike->user_like == 1)?1:2);
            }
            if($userLikeDislike->profile_user_like != ''){
                $result['profileLike'] = (($userLikeDislike->profile_user_like == 1)?1:2);
            }
            $result['user_id'] = $userLikeDislike->user_id;
        }
        if($profileLikeDislike){
            if($profileLikeDislike->user_like != '' && $profileLikeDislike->profile_id == Auth::user()->id){
                $result['userLike'] = (($profileLikeDislike->user_like == 1)?1:2);
            }
            if($profileLikeDislike->profile_user_like != ''){
                $result['profileLike'] = (($profileLikeDislike->profile_user_like == 1)?1:2);
            }
        }
        
        return $result;
    }
    
    public function getProfileLikeDislikeStatus(Request $request){
        $userId = Auth::user()->id;
        $profileId = $request->profileId;
        $userLikeDislike = UserLikeDislike::where('user_id',$userId)->where('profile_id',$profileId)->first();
        $profileLikeDislike = UserLikeDislike::where('user_id',$profileId)->where('profile_id',$userId)->first();
        $likeDislikeStatus['userLike'] = $likeDislikeStatus['profileLike'] = $likeDislikeStatus['user_id']  = 0;
        
        if($userLikeDislike){
            if($userLikeDislike->user_like != '' && $userLikeDislike->user_id == Auth::user()->id){
                $likeDislikeStatus['userLike'] = (($userLikeDislike->user_like == 1)?1:2);
            }
            if($userLikeDislike->profile_user_like != ''){
                $likeDislikeStatus['profileLike'] = (($userLikeDislike->profile_user_like == 1)?1:2);
            }
            $likeDislikeStatus['user_id'] = $userLikeDislike->user_id;
        }
        if($profileLikeDislike){
            if($profileLikeDislike->user_like != '' && $profileLikeDislike->profile_id == Auth::user()->id){
                $likeDislikeStatus['userLike'] = (($profileLikeDislike->user_like == 1)?1:2);
            }
            if($profileLikeDislike->profile_user_like != ''){
                $likeDislikeStatus['profileLike'] = (($profileLikeDislike->profile_user_like == 1)?1:2);
            }
        }
        
        $result = array();
        $result['add'] = $result['like'] = $result['dislike'] = $result['message'] = 0;
        
        if($likeDislikeStatus['userLike'] == 1 && $likeDislikeStatus['profileLike']  == 0 && $likeDislikeStatus['user_id'] != $userId){
            $result['add'] = 1;
        }
        if($likeDislikeStatus['userLike'] == 0 && $likeDislikeStatus['profileLike'] == 0){
            $result['like'] = 1;
        }
        if(($likeDislikeStatus['userLike'] == 1 && $likeDislikeStatus['profileLike']  == 1)){
            $result['message'] = 1;
        }
        if(($likeDislikeStatus['userLike'] == 1 && $likeDislikeStatus['profileLike']  == 0)||
            ($likeDislikeStatus['userLike'] == 0 && $likeDislikeStatus['profileLike']  == 1)||
            ($likeDislikeStatus['userLike'] == 0 && $likeDislikeStatus['profileLike']  == 0)){
            $result['dislike'] = 1;
        }
        return $result;
    }

    public function userProfileLikeDislike(Request $request) {
         
       if($request->type == 'like'){
            $likeDislike = new UserLikeDislike();
            $likeDislike->user_like = ($request->type == 'like'?1:2);
            $likeDislike->profile_user_like = NULL;
            $likeDislike->user_id = $request->userId;
            $likeDislike->profile_id = $request->profileId;
            $likeDislike->save();
            return 'like';
        }
        if($request->type == 'add'){
            $likeDislike = new UserLikeDislike();
            $likeDislike->user_like = NULL;
            $likeDislike->profile_user_like = ($request->type == 'add'?1:2);
            $likeDislike->user_id = $request->userId;
            $likeDislike->profile_id = $request->profileId;
            $likeDislike->save();
            return 'match';
        }
        if($request->type == 'dislike'){
            $likeDislike = UserLikeDislike::where('user_id',$request->userId)->where('profile_id',$request->profileId)->first();
            if($likeDislike === null){
                $likeDislike = new UserLikeDislike();
                $likeDislike->user_like = NULL;
                $likeDislike->profile_user_like = ($request->type == 'dislike'?2:1);
                $likeDislike->user_id = $request->userId;
                $likeDislike->profile_id = $request->profileId;
                $likeDislike->save();
            }else{
                $likeDislike->user_like = ($request->type == 'dislike'?2:1);
                $likeDislike->save();
            }
            return 'dislike';
        }
    }
    

    public function viewSearchProfile(Request $request){
        if(Auth::user() && Auth::user()->id_verify == 1 && Auth::user()->email_verify == 1 && Auth::user()->phone_verify == 1){
            $page_limit = ($request['page_range'])?$request['page_range']:config('constant.recordPerPage');
            $searchProfile = array();
            if(isset($request->profile_search) && $request->profile_search == 1){
                return view('front.search.index',compact('searchProfile','request')); 
            }
            $dataQuery = User::with('countryData')->where('users.id','!=',Auth::user()->id)->where('users.is_admin',0)->where('users.status',2);
            $homeSearchQuery = clone $dataQuery;
            
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
            $userData = $userData->orderBy('users.id', 'desc')->get();
            
            if(isset($request->home_serach_submit) && $request->home_serach_submit == 1){
                if(isset($request->serach_gender) || $request->serach_gender != ''){
                    $homeSearchQuery->where('users.gender',$request->serach_gender);
                }
                if(isset($request->search_age) || $request->search_age != ''){
                    $age = explode(",",$request->search_age);
                    if(count($age)>0){
                        $homeSearchQuery->where('users.age','>=',trim($age[0]))->where('users.age','<=',trim($age[1]));
                    }
                }
                $userData = clone $homeSearchQuery;
                $userData = $userData->orderBy('users.id', 'desc')->get();
                
                $searchProfile = $homeSearchQuery->sortable()->orderBy('users.id', 'desc')->paginate($page_limit);
            }else{
                if ($request->has('sort') && $request->input('sort') != '') {
                    $searchProfile = $dataQuery->sortable()->orderBy($request->input('sort'), $request->input('direction'))->paginate($page_limit);
                } else {
                    $searchProfile = $dataQuery->sortable()->orderBy('users.id', 'desc')->paginate($page_limit);
                } 
            }
            
            
            $getData = SearchHistory::where('user_id',Auth::user()->id)->get()->count();
            $matchPercentageArray = $searchProfileIdArray = array();
            if(count($userData)>0){
                foreach($userData as $val){
                    $matchPercentage =  $this->matchedPercentage(Auth::user()->id,$val->id);
                    $matchPercentageArray[] = $matchPercentage;
                    $searchProfileIdArray[] = $val->id;
                }
                if($getData == 10){
                    SearchHistory::where('user_id',Auth::user()->id)->orderBy("id", "ASC")->take(1)->forceDelete();
                }
                $searchHistory = New SearchHistory();
                $searchHistory->user_id = Auth::user()->id;
                $searchHistory->search_data = json_encode($userData);
                $searchHistory->save();        
            }
            
            $matchPercentageArray = array_unique($matchPercentageArray);
            asort($matchPercentageArray);
            foreach($matchPercentageArray as $x=>$x_value)
            {
                 $matchPercentageArray[$x] = $x_value;
            }

            session(['searchProfileIdArray' => $searchProfileIdArray]);
            
            return view('front.search.index',compact('searchProfile','request','matchPercentageArray','searchProfileIdArray')); 
        }else{
            return redirect('/profile')->with('success',"You'll need to complete your profile and verify your phone number,identity.");
        }
    }
    
    public function matchedPercentage($userId,$matchProfileId) {
        $matchPercentatgeCount = 0;
        $totalMatchFields = 4;
        $matchPercentatge = 100/$totalMatchFields;
        
        $result = $this->matchingAlgorithm($userId);
        $genderMatch = $result['genderMatch'];
        $ageMatch = $result['ageMatch'];
        $heightMatch = $result['heightMatch'];
        $weightMatch = $result['weightMatch'];
        
        $matchPercentatgeCount = (in_array($matchProfileId,$genderMatch)?$matchPercentatge:0) + (in_array($matchProfileId,$ageMatch)?$matchPercentatge:0) +
                                             (in_array($matchProfileId,$heightMatch)?$matchPercentatge:0) + (in_array($matchProfileId,$weightMatch)?$matchPercentatge:0);
        
        
       return $matchPercentatgeCount;
    } 
    
    public function matchedProfile(Request $request) {
        if(Auth::user() && Auth::user()->id_verify == 1 && Auth::user()->email_verify == 1 && Auth::user()->phone_verify == 1){
            $matchPercentatgeCount = 0;
            $totalMatchFields = 4;
            $matchPercentatge = 100/$totalMatchFields;
            $matchProfileWithPerc = array();
            $matchedUserId = array();
            $userId = Auth::user()->id;
            $page_limit = ($request['page_range'])?$request['page_range']:config('constant.recordPerPage');

            $allUser = User::where('users.id','!=',$userId)->where('is_admin',0)->where('status',2)->pluck('id')->toArray();
            
            $matchingAlgorithm = $this->matchingAlgorithm($userId);
            $genderMatch = $matchingAlgorithm['genderMatch'];
            $ageMatch = $matchingAlgorithm['ageMatch'];
            $heightMatch = $matchingAlgorithm['heightMatch'];
            $weightMatch = $matchingAlgorithm['weightMatch'];
            
            if(count($allUser)>0){
                foreach($allUser as $val){
                    $matchPercentatgeCount = (in_array($val,$genderMatch)?$matchPercentatge:0) + (in_array($val,$ageMatch)?$matchPercentatge:0) +
                                             (in_array($val,$heightMatch)?$matchPercentatge:0) + (in_array($val,$weightMatch)?$matchPercentatge:0);
                    if($matchPercentatgeCount){
                        $matchProfileWithPerc[$val] = $matchPercentatgeCount;
                    }
                }
            }

            $matchedProfile = $topMatchedProfile = '';
            if(count($matchProfileWithPerc)>0){
                arsort($matchProfileWithPerc);
                foreach($matchProfileWithPerc as $x=>$x_value)
                {
                     $matchedUserId[$x] = $x_value;
                }
                $query = User::with('userInfoData')->whereIn('users.id',array_keys($matchedUserId))
                                    ->orderByRaw(\DB::raw("FIELD(users.id, ".implode(",",array_keys($matchedUserId))." )"));
                
                $topMatchedQuery = clone $query;
                $topMatchedProfile = $topMatchedQuery->take(5)->get();
                
                $matchedProfile = $query->paginate($page_limit);
                
            }
            $result['matchProfile'] = $matchedProfile;
            $result['matchProfileWithPerc'] = $matchProfileWithPerc;
            $result['topMatchedProfile'] = $topMatchedProfile;
            
            return $result;
        }else{
            return redirect('/profile')->with('success',"You'll need to complete your profile and verify your phone number,identity.");
        }
         
    }
    
    public function matchingAlgorithm($userId){
        $user = User::with('userInfoData')->where('users.id',$userId)->first();
        $genderMatch =  User::leftJoin('user_info as ui','users.id','ui.user_id')
                            ->Where(function ($q)use($user) {
                                $q->where('users.gender',$user->userInfoData->wish_to_meet)
                                  ->where('ui.wish_to_meet',$user->gender);
                            })->where('users.id','!=',$userId)
                            ->whereNotIn('users.id',$this->userDislikedProfile())
                            ->where('is_admin',0)->where('status',2)
                            ->pluck('users.id')->toArray();

        $ageMatch =  User::leftJoin('user_info as ui','users.id','ui.user_id')
                            ->where(function ($q)use($user) {
                                $q->where('users.age','>=',$user->userInfoData->preferred_min_age)
                                ->where('users.age','<=',$user->userInfoData->preferred_max_age)
                                ->where('ui.preferred_min_age','<=',$user->age)
                                ->where('ui.preferred_max_age','>=',$user->age);
                            })->where('users.id','!=',$userId)
                            ->whereNotIn('users.id',$this->userDislikedProfile())
                            ->where('is_admin',0)->where('status',2)
                            ->pluck('users.id')->toArray();

        $heightMatch =  User::leftJoin('user_info as ui','users.id','ui.user_id')
                            ->where(function ($q)use($user) {
                                $q->where('users.height','>=',$user->userInfoData->preferred_min_height)
                                  ->where('users.height','<=',$user->userInfoData->preferred_max_height)
                                  ->where('ui.preferred_min_height','<=',$user->height)
                                  ->where('ui.preferred_max_height','>=',$user->height);
                            })->where('users.id','!=',$userId)
                            ->whereNotIn('users.id',$this->userDislikedProfile())
                            ->where('is_admin',0)->where('status',2)
                            ->pluck('users.id')->toArray();

        $weightMatch =  User::leftJoin('user_info as ui','users.id','ui.user_id')
                            ->where(function ($q)use($user) {
                                $q->where('users.weight','>=',$user->userInfoData->preferred_min_weight)
                                  ->where('users.weight','<=',$user->userInfoData->preferred_max_weight)
                                  ->where('ui.preferred_min_weight','<=',$user->weight)
                                  ->where('ui.preferred_max_weight','>=',$user->weight);
                            })->where('users.id','!=',$userId)
                            ->whereNotIn('users.id',$this->userDislikedProfile())
                            ->where('is_admin',0)->where('status',2)
                            ->pluck('users.id')->toArray();
        
        $result = array();
        $result['genderMatch'] = $genderMatch;
        $result['ageMatch'] = $ageMatch;
        $result['heightMatch'] = $heightMatch;
        $result['weightMatch'] = $weightMatch;
        
        return $result;
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


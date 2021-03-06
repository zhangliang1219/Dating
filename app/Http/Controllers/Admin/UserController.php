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
use App\Country;
use App\UserPrivacySetting;
use App\UserInfoPrivacy;
use App\UserDoc;
use App\UserInfo;

class UserController  extends Controller
{
    public $moduleName = 'user';

    public function __construct()
    {
    }
    public function loginView(Request $request)
    {
        return view('admin.login');
    }
    
    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect('admin/login')
                        ->withErrors($validator)
                        ->withInput();
        }
        $credentials = $request->only('email', 'password');
        if (auth()->attempt($credentials)) {
            $user = Auth::getLastAttempted();
        if ($user->is_admin == 0) {
            return back()->withErrors(['message'=>'Incorrect login credentials.'])
                        ->withInput();
        }elseif($user->status != 2){
            return back()->withErrors(['message'=>'You must be active to login!'])
                        ->withInput();
        }else{
            return redirect()->to('/admin/dashboard');
        }
        }else{
            return back()->withErrors(['message'=>'Your email and password is incorrect,Please try again!'])
                        ->withInput();
        }
    }
    public function logout() {
        auth()->logout();
        return redirect()->to('/admin/login');
    }
    
    public function userListing(Request $request) {
        $page_limit = ($request['page_range'])?$request['page_range']:config('constant.recordPerPage');
        $dataQuery = User::where('is_admin','!=',1);
        
        $userName = clone $dataQuery;
        $userName = $userName->orderBy('name','ASC')->pluck('name','id');
        
        if ($request->has('search_submit') && $request->search_submit != '') {
            if ($request->has('search_by_user') && $request->search_by_user != '') {
                $dataQuery->where('id', $request->search_by_user);
            }
            if ($request->has('search_by_email') && $request->search_by_email != '') {
                $dataQuery->where('email',$request->search_by_email);
            }
            if ($request->has('search_by_status') && $request->search_by_status != '') {
                $dataQuery->where('status', $request->search_by_status);
            }
            if ($request->has('search_by_gender') && $request->search_by_gender != '') {
                $dataQuery->where('gender', $request->search_by_gender);
            }
            if ($request->has('search_by_email_verify') && $request->search_by_email_verify != '') {
                $dataQuery->where('email_verify', $request->search_by_email_verify);
            }
            if ($request->has('search_by_phone_verify') && $request->search_by_phone_verify != '') {
                $dataQuery->where('phone_verify', $request->search_by_phone_verify);
            }
            if ($request->has('search_by_id_verify') && $request->search_by_id_verify != '') {
                $dataQuery->where('id_verify', $request->search_by_id_verify);
            }
        }
        if ($request->has('sort') && $request->input('sort') != '') {
            $userList = $dataQuery->sortable()->orderBy($request->input('sort'), $request->input('direction'))->paginate($page_limit);
        } else {
            $userList = $dataQuery->sortable()->orderBy('id', 'desc')->paginate($page_limit);
        }
        return view('admin.user.index',compact('userList','userName','request'));
    }
    
    public function deleteUser(Request $request){
        try{
            $user = User::find($request->userId);
            if($user){
                $user->delete();
            }
            return Response::json(array('message'=>'User Deleted Successfully','status'=>'success'));
        }catch(Exception $e){
            return Response::json(array('message'=>'Something is wrong.Please try again!','status'=>'error'));
        }
    }
    
    public function editUser($id){
        $user = User::find($id);
        $country = Country::all();
        $userInfo = UserInfo::where('user_id',$id)->first();
        $userPrivacySetting = UserPrivacySetting::where('privacy_option',1)->pluck('field_id')->toArray();
        $userInfoPrivacy = UserInfoPrivacy::where('privacy_option',1)->where('user_id',$id)->pluck('field_id')->toArray();
        $userDoc = UserDoc::where('user_id',$id)->get()->toArray();
        return view('admin.user.edit',compact('user','country','userPrivacySetting','userInfoPrivacy','userDoc','userInfo'));
    }
    
    public function updateUser(Request $request,$id) {
        try{
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'dob' => 'required',
                'phoneNumber' => 'required',
                'gender' => 'required',  
                'email' => 'required|email|unique:users,email,'.$id, 
                'wish_to_meet'   => 'required',
                'relationship'=> 'required', 
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
                'describe_perfect_date'=>'required|max: 1000', 
            ]);
            if ($validator->fails()) {
                return redirect('admin/user/edit/'.$id)
                            ->withErrors($validator)
                            ->withInput();
            }
            $profile_name = NULL;
            if($request->file('photo_id') !=  ''){
                $profile_photo = $request->file('photo_id');
                $profile_name = time().'.'.$profile_photo->getClientOriginalExtension();
                $destinationPath = public_path('/images/profile');
                $profile_photo->move($destinationPath, $profile_name);
            }
            
            $user = User::find($id);
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->name = ($request->first_name.' '.$request->last_name);
            if(strtotime($user->dob) != strtotime($request->dob)){
                $now = time();
                $dob = strtotime($request->dob);
                $difference = $now - $dob;
                $age = floor($difference / 31556926);
                $user->age = $age;
            }
            $user->dob = $request->dob;
            $user->gender = $request->gender;
            $user->ethnicity = (isset($request->ethnicity)?($request->ethnicity):NULL);
            $user->ethnicity_other = (isset($request->ethnicity_other)?($request->ethnicity_other):NULL);
            $user->email = $request->email; 
            $user->phone = (isset($request->phoneNumber)?$request->phoneNumber:NULL);
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
            $user->status = (isset($request->status)?$request->status:NULL);
            if($request->file('photo_id') !=  NULL){
                $user->photo = $profile_name;
            }
            $user->email_verify	 = ($request->email_verification == 'on')?1:2;
            $user->phone_verify = ($request->phone_verification == 'on')?1:2;
            $user->id_verify = ($request->id_verification == 'on')?1:2;
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
        
            Session::flash('success', 'User updated successfully.');
            return redirect(url('/admin/user' ));
        }catch(Exception $e){
            Session::flash('error', 'Something is wrong.Please try again!');
            return Redirect::to('');
        }
    }
    
    public function userIdVerifyUpdate(Request $request,$id) {
        if($request->id_verify != ''){
            $user = User::find($id);
            $user->id_verify = $request->id_verify;
            $user->save();
            Session::flash('success', 'User Id verifaction status updated successfully.');
            return redirect(url('/admin/user' ));
        }else{
            return redirect()->to('/admin/user/edit/'.$id);
        }
    }
}

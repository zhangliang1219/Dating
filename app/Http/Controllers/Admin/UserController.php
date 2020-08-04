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
        return view('admin.user.edit',compact('user','country'));
    }
    
    public function updateUser(Request $request,$id) {
        try{
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'dob' => 'required',
                'phoneNumber' => 'required',
                'age' => 'required',
                'gender' => 'required',  
                'email' => 'required|email|unique:users,email,'.$id, 
                'wish_to_meet'   => 'required',
                'ethnicity'=> 'required',
                'relationship'=> 'required',
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
            $user->dob = $request->dob;
            $user->age = $request->age;
            $user->gender = $request->gender;
            $user->wish_to_meet = (isset($request->wish_to_meet)?$request->wish_to_meet:'');
            $user->preferred_age = (isset($request->preferred_age)? implode(",", $request->preferred_age):'');
            $user->preferred_height = (isset($request->preferred_height)? implode(",", $request->preferred_height):'');
            $user->preferred_weight = (isset($request->preferred_weight)? implode(",", $request->preferred_weight):'');
            $user->ethnicity = (isset($request->ethnicity)?($request->ethnicity):'');
            $user->email = $request->email; 
            $user->phone = (isset($request->phoneNumber)?$request->phoneNumber:'');
            $user->height = (isset($request->height)?$request->height:'');
            $user->weight = (isset($request->weight)?$request->weight:'');
            $user->build = (isset($request->build)?$request->build:'');
            $user->relationship = (isset($request->relationship)?$request->relationship:'');
            $user->living_arrangement = (isset($request->living_arrangement)?$request->living_arrangement:'');
            $user->city = (isset($request->city)?$request->city:'');
            $user->state = (isset($request->state)?$request->state:'');
            $user->country = (isset($request->country)?$request->country:'');
            $user->favorite_sport = (isset($request->favorite_sport)?$request->favorite_sport:'');
            $user->high_school_attended = (isset($request->high_school_attended)?$request->high_school_attended:'');
            $user->collage = (isset($request->collage)?$request->collage:'');
            $user->employment_status = (isset($request->employment_status)?$request->employment_status:'');
            $user->education = (isset($request->education)?$request->education:'');
            $user->children = (isset($request->children)?$request->children:'');
            $user->describe_perfect_date = (isset($request->describe_perfect_date)?$request->describe_perfect_date:'');
            $user->status = (isset($request->status)?$request->status:'');
            if($request->file('photo_id') !=  ''){
                $user->photo = $profile_name;
            }
            $user->email_verify	 = ($request->email_verification == 'on')?1:2;
            $user->phone_verify = ($request->phone_verification == 'on')?1:2;
            $user->id_verify = ($request->id_verification == 'on')?1:2;
            $user->save();
            
            Session::flash('success', 'User updated successfully.');
            return redirect(url('/admin/user' ));
        }catch(Exception $e){
            Session::flash('error', 'Something is wrong.Please try again!');
            return Redirect::to('');
        }
    }
}

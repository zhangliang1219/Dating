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
use App\Mail\WelcomeMail;
use Laravel\Socialite\Facades\Socialite;
use App\SocialIdentity;
use App\Country;


class UserController  extends Controller
{
    public $moduleName = 'user';

    public function __construct()
    {
    }
    public function register(Request $request) {
        $validator =  Validator::make($request->all(), [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'dob' => 'required',
            'phoneNumber' => 'required',
            'age' => 'required',
            'gender' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|string',
            'password_confirmation' => 'required_with:password|same:password', 
            'wish_to_meet'   => 'required',
            'ethnicity'=> 'required',
            'relationship'=> 'required',
        ]); 
        if ($validator->fails()) {
            return redirect('/register')
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
            $password = $request->password;
            $user = new User();
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
            $user->password = Hash::make($password);
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
            $user->photo = $profile_name;
            $user->is_admin = 0;
            $user->status = 1;
            $user->normal_login = 1;
            $user->save();
            
        Mail::to($user->email)->send(new WelcomeMail($user, request()->get('password')));
        return redirect('/register')->with('success','Please check your email to activate your account.');
    }
    
    public function confirmAccount(Request $request, $userId)
    {
        $user  = User::find($userId);
        if($user){
            if($user->status == 2){
                return redirect()->route('login')->with('success','Your account has been already activated.');
            }else{
                $user->status =  2;
                $user->email_verify =  1;
                $user->save();
                return redirect()->route('login')->with('success','Your account has been activated successfully. You can now login.');
            }
        }else{
            return redirect('/register')->withErrors('Something is wrong.Please try again!');
        }
    }
    
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }
    
    public function handleProviderCallback($provider)
    {
        
       $user = $this->createOrGetUser(Socialite::driver($provider)->stateless()->user(), $provider);
       Auth::login($user);
       return redirect()->to('/home');
    }
 
    /**
    * Create or get a user based on provider id.
    *
    * @return Object $user
    */
    private function createOrGetUser($providerUser, $provider)
    {
       $socialIdentity = SocialIdentity::where('provider_name', $provider)
                ->where('provider_id', $providerUser->getId())
                ->first();

       if ($socialIdentity) {
           return $socialIdentity->user;
       } else {
           $user = User::where('email', $providerUser->getEmail())->first();
           if (!$user) {
               $user = User::create([
                   'email' => $providerUser->getEmail(),
                   'name' => $providerUser->getName(),
                   'facebook_login'=> ($provider == 'facebook')?1:NULL,
                   'google_login'=>($provider == 'google')?1:NULL,
                   'instagram_login'=>($provider == 'instagram')?1:NULL,
               ]);

           }
           $user->social_identities()->create([
                   'user_id' => $user->id,
                   'provider_id' => $providerUser->getId(),
                   'provider_name' => $provider,
               ]);

           return $user;
       }
    }
}

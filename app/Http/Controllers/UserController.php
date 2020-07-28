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


class UserController  extends Controller
{
    public $moduleName = 'user';

    public function __construct()
    {
    }
    public function register(Request $request) {
        $validator =  Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'password_confirmation' => 'required_with:password|same:password|min:8',
            'phone' => 'required|numeric',
            'age'   => 'required|integer',
            'profile_photo'   => 'required|image',
            'gender'=> 'required|in:1,2'
        ]);
        if ($validator->fails()) {
            return redirect('/register')
                        ->withErrors($validator)
                        ->withInput();
        }
        $profile_name = '';
        if($request->file('profile_photo') !=  ''){
            $profile_photo = $request->file('profile_photo');
            $profile_name = time().'.'.$profile_photo->getClientOriginalExtension();
            $destinationPath = public_path('/images/profile');
            $profile_photo->move($destinationPath, $profile_name);
        }
            $password = $request->password;
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($password);
            $user->phone = $request->phone;
            $user->age = $request->age;
            $user->gender = $request->gender;
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

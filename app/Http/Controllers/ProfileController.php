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


class ProfileController  extends Controller
{
  public function userProfileInfo() {
        $country = Country::all();
        return view('front.profile.index',compact('country')); 
  }
  
  public function viewSearchProfile(Request $request){
        $user = new user();
        if(isset($request->gender) || $request->gender != ''){
            $user =  $user->where('wish_to_meet',$request->gender);
        }if(isset($request->wish_to_meet) || $request->wish_to_meet != ''){
            $user = $user->where('gender',$request->wish_to_meet);
        }if(isset($request->age) || $request->age != ''){
            $age = $request->age;
            $user = $user->whereRaw('FIND_IN_SET('.$age.',preferred_age)');
        }if(isset($request->country) || $request->country != ''){
            $user = $user->where('country',$request->country);
        }if(isset($request->interests) || $request->interests != ''){
        }
        $user = $user->where('id','!=',Auth::user()->id)->get();
        return view('front.profile.search',compact('user')); 
    }
    
    public function matchedProfile() {
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
                        ->where('users.id','!=',Auth::user()->id)->get();
                            
        echo "<pre>";print_R($matchProfile);exit;
    }
}

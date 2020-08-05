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
use App\SearchHistory;

class ProfileController  extends Controller
{
  public function userProfileInfo() {
        $country = Country::all();
        return view('front.profile.index',compact('country')); 
  }
  
  public function viewSearchProfile(Request $request){
        $page_limit = ($request['page_range'])?$request['page_range']:config('constant.recordPerPage');
        
        $dataQuery = User::with('country')->where('users.id','!=',Auth::user()->id)->where('users.is_admin',0)->where('users.status',2);
        if(isset($request->gender) || $request->gender != ''){
            $dataQuery->where('users.gender',$request->gender);
        }if(isset($request->age) || $request->age != ''){
            $dataQuery->where('users.age',$request->age);
        }if(isset($request->height) || $request->height != ''){
            $dataQuery->where('users.height',$request->height);
        }if(isset($request->country) || $request->country != ''){
            $dataQuery->where('users.country',$request->country);
        }if(isset($request->weight) || $request->weight != ''){
            $dataQuery->where('users.weight',$request->weight);
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
        return view('front.search.index',compact('searchProfile')); 
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
                        ->where('users.id','!=',Auth::user()->id)->where('is_admin',0)->where('status',2)->get();
         
    }
}

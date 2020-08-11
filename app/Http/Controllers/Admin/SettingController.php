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
use App\UserPrivacySetting;

class SettingController  extends Controller
{
    public function userInfoPrivacyView() {
        $userInfoPrivacy = UserPrivacySetting::pluck('field_id')->toArray();
        return view('admin.setting.user_privacy',compact('userInfoPrivacy'));
    }
    
    public function storeUserInfoPrivacy(Request $request) {
        try{
            if(isset($request->field_name) && count($request->field_name)>0)
            {
                UserPrivacySetting::truncate();
                foreach($request->field_name as $key => $val){
                    $userInfoPrivacy = new UserPrivacySetting();
                    $userInfoPrivacy->field_id = $val;
                    $userInfoPrivacy->privacy_option = 1;
                    $userInfoPrivacy->save();
                }
                Session::flash('success', 'UserInfo Privacy Set Successfully!');
                return redirect(url('/admin/setting/userInfo/privacy' ));
            }
        }catch(Exception $e){
            Session::flash('error', 'Something is wrong.Please try again!');
            return redirect(url('/admin/setting/userInfo/privacy' ));
        }
    }
}

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
        }elseif($user->status == 0){
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
        if ($request->has('sort') && $request->input('sort') != '') {
            $userList = $dataQuery->sortable()->orderBy($request->input('sort'), $request->input('direction'))->paginate($page_limit);
        } else {
            $userList = $dataQuery->sortable()->orderBy('id', 'desc')->paginate($page_limit);
        }
        return view('admin.user.index',compact('userList'));
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
        return view('admin.user.edit',compact('user'));
    }
    
    public function updateUser(Request $request,$id) {
        try{
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,'.$id,
                'phone' => 'required',
                'status' => 'required',
            ]);
            if ($validator->fails()) {
                return redirect('admin/user/edit/'.$id)
                            ->withErrors($validator)
                            ->withInput();
            }
            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->status = $request->status;
            $user->save();
            
            Session::flash('success', 'User updated successfully.');
            return redirect(url('/admin/user' ));
        }catch(Exception $e){
            Session::flash('error', 'You do not have permission to perform this action!');
            return Redirect::to('');
        }
    }
}

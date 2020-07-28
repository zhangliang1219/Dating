<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    
    public function showLoginForm()
    {
        return view('auth.login');
    }
    protected function credentials(Request $request)
    {
        return ['email' => $request->{$this->username()}, 'password' => $request->password, 'status' => 2,'is_admin' => 0];
    }
    public function login(Request $request)
    {
        $this->validateLogin($request);
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }
        if ($this->attemptLogin($request))
        {
            if (auth()->user()->is_admin == 0 || auth()->user()->status == 2){
                $data = [
                    'data' => auth()->user(),
                    'success' => true,
                    'msg' => 'Login successfully',
                ];
                return redirect()->to('/home');
            }else{
                $this->incrementLoginAttempts($request);
                $data = ['success' => false,
                          'msg' => 'Inactive'];
                return redirect('/login')
                        ->withErrors($data)
                        ->withInput();
            }
        }
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }
    
    public function logout() {
        auth()->logout();
        return redirect()->to('/login');
    }
}

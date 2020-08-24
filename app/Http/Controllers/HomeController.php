<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $totalUser = User::where('is_admin',0)->where('deleted_at')->count();
        $activeUser = User::where('is_admin',0)->where('status',2)->where('deleted_at')->count();
        $womenUser = User::where('is_admin',0)->where('gender',2)->where('deleted_at')->count();
        $menUser = User::where('is_admin',0)->where('gender',1)->where('deleted_at')->count();
        return view('home',compact('totalUser','activeUser','womenUser','menUser'));
    }
}

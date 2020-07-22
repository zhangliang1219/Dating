<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class DashboardController  extends Controller
{
    public function index(Request $request)
    {
        $lastMonth = date("Y-m-", strtotime("-1 months")); 
        $currentMonth = date("Y-m-"); 

        $query = User::where('is_admin','!=',1);
        $totalUser = clone $query;
        $lastMonthUser = clone $query;
        $currentMonthUser = clone $query;
        
        $totalUser = $totalUser->get()->count();
        $lastMonthUser = $lastMonthUser->where('created_at','LIKE','%'.$lastMonth.'%')->get()->count();
        $currentMonthUser = $currentMonthUser->where('created_at','LIKE','%'.$currentMonth.'%')->get()->count();
        return view('admin.dashboard',compact('totalUser','lastMonthUser','currentMonthUser'));
    }
    
    
}

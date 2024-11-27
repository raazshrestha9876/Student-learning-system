<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function Dashboard(){

        // $data['header_title'] = "dashboard";
        if(Auth::user()->is_role == 1){
            return view('admin/dashboard');
        }
        else if(Auth::user()->is_role == 2){
            return view('teacher/dashboard');
        }
        else if(Auth::user()->is_role == 3){
            return view('student/dashboard');
        }
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        // dd(Hash::make("admin123"));
        if (!empty(Auth::check())) {

            if (Auth::user()->is_role == 1) {
                return redirect('admin/dashboard');
            } else if (Auth::user()->is_role == 2) {
                return redirect('teacher/dashboard');
            } else if (Auth::user()->is_role == 3) {
                return redirect('student/dashboard');
            }
        }
        return view('auth.login');
    }

    public function AuthLogin(Request $request)
    {
        $remember = !empty($request->remember) ? true : false;

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember)) {

            if (Auth::user()->is_role == 1) {

                return redirect('admin/dashboard');
            }
            if (Auth::user()->is_role == 2) {

                return redirect('teacher/dashboard');
            }

            if (Auth::user()->is_role == 3) {

                return redirect('student/dashboard');
            }
        } else {
            return redirect()->back()->with('error', 'Please enter correct email and password');
        }
    }
    public function AuthLogout()
    {
        Auth::logout();
        return redirect(url('/'));
    }
}

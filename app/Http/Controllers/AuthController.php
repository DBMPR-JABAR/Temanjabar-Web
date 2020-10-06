<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Web Service
    public function login(Request $req)
    {
        $credentials = $req->only('email', 'password');
        $auth = Auth::attempt($credentials);
        if (!$auth) {
            return back()->with(['msg' => 'Email atau Password Salah']);
        }
        return redirect('admin');
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

}

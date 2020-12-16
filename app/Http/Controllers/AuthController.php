<?php

namespace App\Http\Controllers;

use App\Model\Push\UserPushNotification;
use App\Model\Transactional\Log;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class AuthController extends Controller
{
    // Web Service
    public function login(Request $req)
    {
        $credentials = $req->only('email', 'password');
        $auth = Auth::attempt($credentials);
        if (!$auth) {
            return back()->with(['msg' => 'Email atau Password Salah', 'color' => 'danger']);
        }
        if(Auth::user()->role == 'masyarakat'){
            Auth::logout();
            return back()->with(['msg' => 'Silahkan Login Di Smartphone Untuk Mengakses Fitur Masyarakat', 'color' => 'danger']);
        }
        Log::create(['activity' => 'Login', 'description' => 'User '.Auth::user()->name.' Logged In To Web']);
        return redirect('admin');
    }
    public function logout()
    {
        if(Auth::check()){
            Log::create(['activity' => 'Logout', 'description' => 'User '.Auth::user()->name.' Logged Out From Web']);
        }
        Auth::logout();

        return redirect('/');
    }
    public function verifyEmail($token)
    {
        try {
            $decrypted = Crypt::decrypt($token);
            $user = User::find($decrypted);
            $user->email_verified_at = now();
            $user->save();
            return redirect('login')->with(['msg' => 'Email Berhasil Diverifikasi', 'color' => 'success']);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return $e->getMessage();
        }
    }

    public function loginUsingId($encrypted_id){
        $id = decrypt($encrypted_id);
        $auth = Auth::loginUsingId($id);
        pushNotification([3],"Logged In","You have Logged IN");
        return redirect('admin');
    }
}

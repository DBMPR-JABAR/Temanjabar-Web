<?php

namespace App\Http\Controllers;

use App\Model\Push\UserPushNotification;
use App\Model\Transactional\Log;
use Illuminate\Support\Facades\Log as Logs;
use App\User;
use App\UserMasyarakat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Web Service
    public function login(Request $req)
    {
        $credentials = $req->only('email', 'password');
        $internal = DB::table('user_pegawai')->where('no_pegawai', $req->email);
        // dd($internal->first());
        if ($internal->count() > 0) {
            $user = DB::table('users')->where('id', $internal->first()->user_id)->first();
            $credentials['email'] = $user->email;
        }
        
        $auth = Auth::attempt($credentials);
        // dd($auth);
        if (!$auth) {
            Logs::notice("Email '" . $req->email . "' gagal login dengan ip " . request()->ip());
            return back()->with(['msg' => 'Email/NIP atau Password Salah', 'color' => 'danger']);
        }
        if (Auth::user()->role == 'masyarakat') {
            Auth::logout();
            return back()->with(['msg' => 'Silahkan Login Di Smartphone Untuk Mengakses Fitur Masyarakat', 'color' => 'danger']);
        }
        if(Auth::user()->is_delete == 1 || Auth::user()->blokir == "Y"){
            Auth::logout();
            return back()->with(['msg' => 'Akun anda telah di Blokir / di Hapus, Hubungi admin!!', 'color' => 'danger']);
        }
        Log::create(['activity' => 'Login', 'user_id' => Auth::user()->id, 'description' => 'User ' . Auth::user()->name . ' Logged In To Web Teman-Jabar', 'ip_address' => request()->ip()]);

        Logs::info(Auth::user()->name . ' login dengan ip ' . request()->ip());
        return redirect()->intended('admin');
    }
    public function logout()
    {
        if (Auth::check()) {
            Log::create(['activity' => 'Logout', 'user_id' => Auth::user()->id, 'description' => 'User ' . Auth::user()->name . ' Logged Out From Web', 'ip_address' => request()->ip()]);
        }
        Auth::logout();

        return redirect('/login');
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
    public function verifyEmailMasyarakat($token)
    {
        try {
            $decrypted = Crypt::decrypt($token);
            $user = UserMasyarakat::find($decrypted);
            $user->email_verified_at = now();
            $user->save();
            return redirect('login')->with(['msg' => 'Email Berhasil Diverifikasi', 'color' => 'success']);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return $e->getMessage();
        }
    }
    public function passwordResetMasyarakat($token)
    {
        try {
            $decrypted = Crypt::decrypt($token);
            $user = UserMasyarakat::where('kode_otp',$decrypted)->first();
            $profil = DB::table('landing_profil')->where('id', 1)->first();

            // dd($user);
            if($user){
                // return redirect('login')->with(['msg' => 'Oke', 'color' => 'success']);
                return view('landing.reset-password', compact('user','profil'));

            }else{
                return redirect('403')->with(['msg' => 'Link has been broken, please try again !', 'color' => 'error']);
            }
            return redirect('login')->with(['msg' => 'Email Berhasil Diverifikasi', 'color' => 'success']);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return $e->getMessage();
        }
    }
    public function changePasswordResetMasyarakat(Request $request, $token)
    {
        try {
            $this->validate($request,[
                'password' => 'confirmed|min:8|max:100'
            ]);
            $user = UserMasyarakat::where('kode_otp',$token)->first();

            if($user){
                // return redirect('login')->with(['msg' => 'Oke', 'color' => 'success']);
                $user->password = Hash::make($request->password);
                $user->save();
                return redirect('login')->with(['msg' => 'Password berhasil diganti, silahkan login di mobile!', 'color' => 'success']);

            }else{
                return redirect('403')->with(['msg' => 'Link has been broken, please try again !', 'color' => 'error']);
            }
            return redirect('login')->with(['msg' => 'Email Berhasil Diverifikasi', 'color' => 'success']);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return $e->getMessage();
        }
    }
    public function loginUsingId($encrypted_id)
    {
        $id = decrypt($encrypted_id);
        $auth = Auth::loginUsingId($id);
        pushNotification([Auth::user()->id], "Logged In", "You have Logged IN");
        return redirect('admin');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Validator;
use App\User;
use Illuminate\Support\Facades\Hash;

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

    // API Service
    public function loginAPI(Request $req)
    {
        $credentials = $req->only('email', 'password');
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));
    }
    public function registerAPI(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create([
            'name' => $req->get('name'),
            'email' => $req->get('email'),
            'password' => Hash::make($req->get('password')),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user','token'),201);
    }
    public function getAuthUser()
    {
        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], 401);

        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], 401);

        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], 400);

        }

        return response()->json(compact('user'));
    }


}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Validator;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    private $response;

    public function __construct() {
        $this->middleware('jwt.auth', ['except' => ['login', 'register', 'resetPassword', 'loginOTP', 'sendOTPMail', 'resendOTPMail','verifyOTP']]);
        $this->response = [
            'status' => 'false',
            'data' => []
        ];
    }

    public function login(Request $req)
    {
        $credentials = $req->only('email', 'password');
        try {
            if (!$token = auth('api')->attempt($credentials)) {
                $this->response['data']['message'] = 'invalid_credentials';
                return response()->json($this->response, 200);
            }
        } catch (JWTException $e) {
            $this->response['data']['message'] = 'could_not_create_token';
            return response()->json($this->response, 500);
        }

        $this->response['status'] = 'success';
        $this->response['data']['token'] = $this->getToken($token);
        $this->response['data']['user'] = auth('api')->user();
        return response()->json($this->response, 200);
    }
    public function register(Request $req)
    {
        try {
            $validator = Validator::make($req->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6',
            ]);

            if($validator->fails()){
                $this->response['data']['error'] = $validator->errors();
                return response()->json($this->response, 400);
            }

            $user = User::create([
                'name' => $req->get('name'),
                'email' => $req->get('email'),
                'password' => Hash::make($req->get('password')),
            ]);


            $this->response['status'] = 'success';
            $this->response['data'] = true;

            return response()->json($this->response,200);

        } catch (\Exception $e) {
            $this->response['data']['message'] = 'Internal Error';
            return response()->json($this->response,500);
        }
    }
    public function resetPassword(Request $req)
    {
        try {
            $validator = Validator::make($req->all(), [
                'email' => 'required|string|email|max:255|exists:users',
            ]);
            if($validator->fails()){
                $this->response['data']['error'] = $validator->errors();
                return response()->json($this->response, 400);
            }

            // TODO: Send Email

            $this->response['status'] = 'success';
            $this->response['data'] = true;

            return response()->json($this->response,200);

        } catch (\Exception $e) {
            $this->response['data']['message'] = 'Internal Error';
            return response()->json($this->response,500);
        }
    }

    public function getUser()
    {
        try {
            $this->response['status'] = 'success';
            $this->response['data']['user'] = auth('api')->user();
            return response()->json($this->response, 200);
        } catch (\Exception $e) {
            $this->response['data']['message'] = 'Internal Error';
            return response()->json($this->response, 500);
        }
    }
    protected function getToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ];
    }

    public function refresh()
    {
        try {
            return $this->getToken(auth('api')->refresh());
        } catch (\Exception $e) {
            $this->response['data']['message'] = 'Internal Error';
            return response()->json($this->response, 500);
        }
    }

    public function loginOTP(Request $req)
    {
        $user = User::where('email',$req->email)->first();
        try {
            if($user && Hash::check($req->password, $user->password)){
                $kode_otp = rand(100000, 999999);
                $user->kode_otp = $kode_otp;
                $user->save();

                $to_email = $user->email;
                $to_name = $user->name;
                $data = [
                    'name' => $to_name,
                    'otp' => $kode_otp
                ];
                try {
                    Mail::send('mail.sendOTP', $data, function($message) use ($to_name, $to_email) {
                        $message->to($to_email, $to_name)->subject('Kode OTP Temanjabar');
                        // $message->to('priyayidimas@upi.edu', 'Dimas Anom Priyayi')->subject('Kode OTP Temanjabar');
                        $message->from(env('MAIL_USERNAME'),env('MAIL_FROM_NAME'));
                    });
                    $this->response['status'] = 'success';
                    $this->response['data']['otp'] = $kode_otp;
                    $this->response['data']['message'] = 'Kode OTP Terkirim';
                    return response()->json($this->response, 200);
                }catch(\Exception $e){
                    $this->response['data']['message'] = 'Internal Error';
                    return response()->json($this->response, 500);
                }
            }else{
                throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException("User Email or Password Mismatch");
            }
        }catch(\Exception $e){
            if($e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException){
                $this->response['data']['message'] = 'User Email or Password Mismatch';
                return response()->json($this->response, 200);
            }else{
                $this->response['data']['message'] = 'Internal Error';
                return response()->json($this->response, 500);
            }
        }
    }

    public function resendOTPMail(Request $req){
        $kode_otp = rand(100000, 999999);

        $user = User::where('email',$req->email)->first();
        $user->kode_otp = $kode_otp;
        $user->save();

        $to_email = $user->email;
        $to_name = $user->name;

        $data = [
            'name' => $to_name,
            'otp' => $kode_otp
        ];
        try {
            Mail::send('mail.sendOTP', $data, function($message) use ($to_name, $to_email) {
                $message->to($to_email, $to_name)->subject('Kode OTP Temanjabar');
                $message->from(env('MAIL_USERNAME'),env('MAIL_FROM_NAME'));
            });

            $this->response['status'] = 'success';
            $this->response['data']['otp'] = $kode_otp;
            $this->response['data']['message'] = 'Kode OTP Terkirim';
        }catch(\Exception $e){
            $this->response['data']['message'] = 'Internal Error';
            return response()->json($this->response, 500);
        }
    }

    public function verifyOTP(Request $req){
        try {
            $user = User::where('email',$req->email)->where('kode_otp',$req->kode_otp)->first();
            if(!$user || !$token = auth('api')->login($user)) {
                $this->response['data']['message'] = 'Invalid OTP';
                return response()->json($this->response, 200);
            }
        } catch (JWTException $e) {
            $this->response['data']['message'] = 'could_not_create_token';
            return response()->json($this->response, 500);
        }

        $this->response['status'] = 'success';
        $this->response['data']['token'] = $this->getToken($token);
        $this->response['data']['user'] = auth('api')->user();
        return response()->json($this->response, 200);
    }
}

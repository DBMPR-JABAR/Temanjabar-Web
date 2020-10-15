<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Validator;
use App\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    private $response;

    public function __construct() {
        $this->middleware('jwt.auth', ['except' => ['login','register','resetPassword']]);
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
                $this->response['data']['error'] = 'invalid_credentials';
                return response()->json($this->response, 200);
            }
        } catch (JWTException $e) {
            $this->response['data']['error'] = 'could_not_create_token';
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
}

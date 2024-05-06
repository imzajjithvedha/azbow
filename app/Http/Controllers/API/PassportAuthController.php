<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PassportAuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users',
            'password' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json([
                'http_status' => 400,
                'http_status_message' => 'Bad Request',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 400);
        }

        if(Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
    
            if($user->status != '1') {
                return response()->json([
                    'http_status' => 401,
                    'http_status_message' => 'Unauthorized',
                    'message' => 'Login failed',
                    'error' => ['info' => 'Account disabled']
                ], 401);
            }


            $token = $user->createToken('MyApp')->accessToken;
            
            return response()->json([
                'http_status' => 200,
                'http_status_message' => 'Success',
                'message' => 'Login successful',
                'data' => ['token' => $token]
            ], 200);
        }
        else {
            return response()->json([
                'http_status' => 401,
                'http_status_message' => 'Unauthorized',
                'message' => 'Login failed',
                'error' => ['info' => 'Invalid password']
            ], 401);
        }
    }

    public function logout(Request $request)
    {
        Auth::user()->token()->revoke();

        return response()->json([
            'http_status' => 200,
            'http_status_message' => 'Success',
            'message' => 'Logout successful'
        ], 200);
    }
}
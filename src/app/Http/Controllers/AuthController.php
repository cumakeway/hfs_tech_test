<?php

namespace App\Http\Controllers;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
       
        $user = User::where('email', $request->input('email'))->first();
        $credentials = $request->only(['email', 'password']);
         
        if (!$token = JWTAuth::attempt($credentials)) {
           return response()->json([
            'error' => 'Invalid login details'
           ], 401);
        }
      
        return response()->json([
            'token' =>  $token,
            'user' => $user
        ], 200);
        
     }

     public function logout(Request $request) 
     {
         // Get JWT Token from the request header key "Authorization"
         $token = $request->header("Authorization");
         // Invalidate the token
         try {
             JWTAuth::invalidate(JWTAuth::getToken());
             return response()->json([
                 "status" => "success", 
                 "message"=> "User successfully logged out."
             ]);
         } catch (JWTException $e) {
             // something went wrong whilst attempting to encode the token
             return response()->json([
             "status" => "error", 
             "message" => "Failed to logout, please try again."
             ], 500);
         }
     }

}

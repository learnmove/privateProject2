<?php

namespace App\Http\Controllers\Auth;
use JWTAuth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function refresh(Request $request){
        $token=JWTAuth::getToken();
        // $user=JWTAuth::parseToken()->authenticate();
         $newtoken = JWTAuth::refresh($token);
        // $newtoken=JWTAuth::refresh(JWTAuth::getToken());
        return response()->json($newtoken);
    }
}

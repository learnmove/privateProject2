<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Entities\User;
use JWTAuth;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function __construct(){
     }
     public function getProfile()
     {
         //
        $user =  User::find(JWTAuth::parseToken()->authenticate()->id);
        $user['phone'] = resolve('\Lib\Mix')->phone_to_star($user['phone']);
        $user['email'] = resolve('\Lib\Mix')->email_to_star($user['email']);

        return $user;
     }
     public function updateProfile() {
         
     }

}
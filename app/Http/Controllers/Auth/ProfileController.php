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
        $request = request();
         $user = [
            'shop_name' => $request->shop_name,
            'shop_description' => $request->shop_description,
            'school_id' => $request->school_id,
            // 'avatar' => '',
         ];
         $path = resolve('\Lib\Mix')->storeImg($request->avatar);
        if($path){
            $user['avatar'] = $path;
        }

         $message = User::find(JWTAuth::parseToken()->authenticate()->id)->update($user);

         return [$message];
     }

}
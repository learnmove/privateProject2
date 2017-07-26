<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Auth;
use App\Entities\User;
class NotificationController extends Controller
{
    public function Getnotify(){
        $authuser=JWTAuth::parseToken()->authenticate();
        $user=User::find($authuser->id);
     
          return response()->json($user->notifications()->latest()->limit(35)->get());

    }
    public function MarkRead(){
        $authuser=JWTAuth::parseToken()->authenticate();
        $user=User::find($authuser->id);
        foreach($user->unreadNotifications as $notification){
                $notification->markAsRead();
        }
     
    }
}

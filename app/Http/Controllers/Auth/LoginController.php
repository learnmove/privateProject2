<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use JWTAuth;
use Validator;
use Auth;
use App\Repositories\UserRepositoryEloquent;
class LoginController extends Controller
{
  

    use AuthenticatesUsers;

    
    protected $redirectTo = '/home';
    protected $user_rp;
     public function __construct(UserRepositoryEloquent $repository){
         $this->user_rp=$repository;
     }
     protected function validator(Request $rq)
    {
        return Validator::make($rq->all(), [
            // 'email' => 'required|email|max:255',
            'password' => 'required|min:6',
            'account'=>'required'
            
        ]);
       
    }

    // public function __construct()
    // {
    //     $this->middleware('guest', ['except' => 'logout']);
    // }
    public function login(Request $rq){
        $v=$this->validator($rq);
        if($v->fails()){
            return $this->rj(['error'=>$v->messages()],404);
        }
         $credential=$rq->only('account','password');
        try{
            if(!$token=JWTAuth::attempt($credential)){
                return $this->rj(["帳號密碼錯誤"],401);
            }
        }catch(JWTException $e){
          return response()->json(['error' => 'could_not_create_token'], 500);

        }
        $user=Auth::user();
         return response()->json(compact('token','user'));

    }
}

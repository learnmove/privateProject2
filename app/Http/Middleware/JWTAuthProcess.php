<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
class JWTAuthProcess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
       
         $response = $next($request);
           
            
        if($token=JWTAuth::getToken()){
          
                       try{
                 if(JWTAuth::parseToken()->authenticate()){
                 return $next($request);
                     
                 }
                }catch(TokenExpiredException $e){
                   $response->headers->set('Authorization','Bearer ' );

        }
        return $response;
            }else{
                 return $next($request);
                
            }
    
       
      
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;

class IsUserAuthenticated
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
        if ($request->segment(1) == 'api' || request()->ajax()) {
            $token = $request->bearerToken();
            if(!$token)
                return response(['status'=>false, 'message'=>'Unauthenticated Admin!'],403);

                $decodeToken = decodeToken($token);
                if($decodeToken['status'] || $decodeToken['status']=='active'){
                    $email = $decodeToken['data']['email'];
                    $user = (new User())->where(['email'=>$email])->get();  
                    if(count($user)>0){
                        $request->decode = $user[0];
                        return $next($request);
                    }else{
                        return response(['status'=>false, 'message'=>'Admin not found!'],404);
                    }
                }else{
                    
                     return response(['status'=>false, 'message'=>$decodeToken['message']],401);
                }
            //return response($decodeToken);
           
        }
        return $next($request);
    }
}

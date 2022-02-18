<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Registration;

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
        $role = $request->session()->get('role');
        $id = $request->session()->get('id');

        if($role && $id && $role!='' && $id!=''){
            $userModel = new Registration;
            $user = $userModel->where(['id'=>$id])->get(); //echo "<pre>"; print_r($user); die();
            if(count($user)>0){ 
                
                $request->decode = $user[0];
                return $next($request);
                
                
            }else{
                return redirect('/login')->with(['error'=>'User not found!']);
            }
        }else{
            return redirect('/login')->with(['error'=>'Login first!']);
        }

    }
}

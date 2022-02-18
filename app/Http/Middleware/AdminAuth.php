<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Admin;

class AdminAuth
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
        $email = $request->session()->get('email');
        $id = $request->session()->get('id');

            if($email && $id && $email!='' && $id!=''){
                $adminModel = new Admin;
                $user = $adminModel->where(['email'=>$email,'id'=>$id])->get(); //echo "<pre>"; print_r($user); die();
                if(count($user)>0){ 
                     
                    $request->decode = $user[0];
                    return $next($request);
                    
                }else{
                    return redirect('/admin')->with(['error'=>'Admin not found!']);
                }
            }else{
                return redirect('/admin')->with(['error'=>'Login first!']);
            }


    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Registration;

class IsTeacherAuthenticated
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

        if($role && $id && $role=='2' && $id!=''){
            $userModel = new Registration;
            $user = $userModel->where(['role'=>$role,'id'=>$id])->get(); //echo "<pre>"; print_r($user); die();
            if(count($user)>0){ 
                
                //return redirect('student-dashboard');
                
                $request->decode = $user[0];
                return $next($request);
                
                
            }else{
                return redirect('/login')->with(['error'=>'Teacher not found!']);
            }
        }else{
            return redirect('/login')->with(['error'=>'Login first!']);
        }

    }
}
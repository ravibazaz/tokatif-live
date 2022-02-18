<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Registration;

use Session;
use Validator;
use Hash;

use Illuminate\Support\Facades\Storage;


class LoginController extends Controller
{
    protected $registrationModel;
    public function __construct(){
        $this->registrationModel = new Registration;
    }
    
    /*public function index(){
        return view('user/login');
    }*/
    
    public function login(Request $request)
    {

        if(count($request->all()) > 0) {   
            $validator = Validator::make($request->all(), [
                            'username' => 'required',
                            'password' => 'required',
                        ]);


            if ($validator->fails()) { 
                return redirect('login')->withErrors($validator)->withInput(); 
            }else{
                
                if (is_numeric($request->username)) {
                    $user = $this->registrationModel->where('phone_number', '=', $request->username)
                                                ->where('status', '=', '1')
                                                ->where('deleted_at', '=', null)->get();
                }else{
                    $user = $this->registrationModel->where('email', '=', $request->username)
                                                    ->where('status', '=', '1')
                                                    ->where('deleted_at', '=', null)->get();
                }
                
                if(count($user)>0){

                    if(Hash::check($request->password,$user[0]->password)){ 
                        
                        session([
                            'id'=>$user[0]->id,
                            'email'=>$user[0]->email,
                            'phone'=>$user[0]->phone_number,
                            'name'=>$user[0]->name,
                            'role'=>$user[0]->role,
                            'gender'=>$user[0]->gender
                        ]);
                        
                        //dd(session()->all());
                        
                        
                        if($user[0]->role=='1'){
                            return redirect('student-dashboard');
                        }else{
                            return redirect('teacher-dashboard');
                        }
                        
                
                        
                    }else{ 
                        return redirect('login')->with('error','Invalid password!')->withInput();
                    }
                    
                    
                }else{
                    return redirect('login')->with('error','Student email does not exist!')->withInput();
                }
                
                            
            }
        }else{
            
            if(session('role')=='1'){
                return redirect('student-dashboard');
            }elseif(session('role')=='2'){
                return redirect('teacher-dashboard');
            }else{
                return view('user/login'); 
            }
        }
        
    }






}



?>
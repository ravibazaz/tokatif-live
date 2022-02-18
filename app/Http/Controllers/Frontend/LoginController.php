<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\Registration;

use Session;
use Validator;

//use Illuminate\Support\Facades\Storage;


class LoginController extends Controller
{
    protected $registrationModel;
    public function __construct(){
        $this->registrationModel = new Registration;
    }
    
    /*public function index(){
        return view('user/login');
    }*/
    
    public function login()
    {
        return view('user/student-login');
    }
    
    public function student_login(Request $request)
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
                                                    ->where('role', '=', '1')
                                                    ->where('deleted_at', '=', null)->get(); 
                }else{
                    $user = $this->registrationModel->where('email', '=', $request->username) 
                                                    ->where('role', '=', '1')
                                                    ->where('deleted_at', '=', null)->get(); 
                }
                
                
                
                echo "<pre>"; print_r($user); die();
                
                if(count($user)>0){  
                    //return view('student/dashboard',$data);
                }else{
                    return redirect('login')->with('error','Email/Phone does not exists!')->withInput();
                }
                
                /*if(count($user)>0){ 
                    $password = Hash::make($request->password);
                    
                    if(Hash::check($password,$user[0]->password)){ //echo "match"; echo $user[0]->status;  die();
                        session([
                            'email'=>$user[0]->email,
                            'username'=>$user[0]->fname.' '.$user[0]->lname,
                            'name'=>$user[0]->fname.' '.$user[0]->lname,
                            'id'=>$user[0]->id
                        ]);  
                        //dd(session()->all());
                        return redirect('admin/dashboard');
                    }
                    else{ 
                        $request->session()->flash('error','Username/Password invalid');
                        return redirect('admin/');
                    }
        
                }else{
                    $request->session()->flash('error','User does not exist!');
                    return redirect('admin/');
                }*/
                
                
                            
                            
            }
        }
        

        //return view('student/dashboard',$data);
    }



    



}



?>
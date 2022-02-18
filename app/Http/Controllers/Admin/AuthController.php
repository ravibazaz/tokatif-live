<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin;

use Hash;
use App\Mail\ForgotPassword;
use Illuminate\Support\Facades\Mail;


class AuthController extends Controller
{
    protected $adminModel;

    public function __construct(){
        $this->adminModel=  new Admin();
    }
    
    /*public function login(){ 
        //echo "aaaaaaaaaaaaa"; exit();
        $data = session()->all(); //echo "<pre>"; print_r($data); echo session('email'); die();
        if(session('email')!='' && session('id')!=''){
            return redirect('admin/dashboard');
        }else{ 
            //echo "aa"; exit();
            return view('admin.auth.login');
        }
        
    }*/
    
    public function log(){  
        $data = session()->all(); //echo "<pre>"; print_r($data); echo session('email'); die();
        if(session('email')!='' && session('id')!=''){
            return redirect('admin/dashboard');
        }else{ 
            //echo "aa"; exit();
            return view('admin.auth.login');
        }
    }
    
    public function verify_login(Request $request){ 
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password'=>'required'
        ]);

        if ($validator->fails()) {
            return redirect('admin/')->withErrors($validator)->withInput();
        }

        $username = $request->input('username');
        $password = $request->input('password');
        
        
        $user = $this->adminModel->where(['email'=>$username])->get();

        if(count($user)>0){  
            if(Hash::check($password,$user[0]->password)){ //echo "match"; echo $user[0]->status;  die();
                session([
                    'email'=>$user[0]->email,
                    'username'=>$user[0]->name,
                    'name'=>$user[0]->name,
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
        }
        
    }
    public function forgotPassword(){
        return view('admin.auth.forgot-password');
    }
    public function sendForgotPassword(Request $request){
        /*$validator = Validator::make($request->all(),[
            'email'=>'required|email'
        ]);
        $email= $request->email;
        $user = $this->userModel->where(['email'=>$email,'role_type'=>'1'])->get();
        if(count($user)>0){
            $token=getToken([
                    'email'=>$email,
                    'id'=>$user[0]->id,
                ]);  
            
            $updateData=[];
            $updateData['remember_token'] = $token;
            $updateData['updated_at'] = date('Y-m-d H:i:s'); 

            $this->userModel->where('id',$user[0]->id)->update($updateData);

            $data['url']=config('app.url').'/admin/reset-password?q='.$token;  
            $data['name']= $user[0]->fname;
            //echo "zzz ".$data['url']; die();
            Mail::to($request->email)->send(new ForgotPassword($data));
            //Mail::to('john@example.com')->send(new WelcomeEmail());
            return redirect()->back()->with(['success'=>'Reset password email has been sent to your email address']);
        }else{
            return redirect()->back()->with(['error'=>'User not found']);
        }*/
        
    }
    public function resetPassword(Request $request){
        if($request->has('q')){
            $q = $request->q;
            $decodeToken = \decodeToken($q);
            $user = $this->adminModel->where(['id'=>$decodeToken['id'],'email'=>$decodeToken['email']])->get();
            // print_r($user);
            if(count($user)>0){
                
            }else{

            }
        

        }else{
            return redirect()->route('admin-login')->with(['error'=>'Invalid Access']);
        }
    }
    public function logout(){
        session()->flush();
        return redirect('admin/signin');
    }
}

<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Registration;
use App\Models\Newsletter;

use Session;
use Validator;
use Hash;

use App\Mail\ForgotPassword;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    
    protected $registrationModel;
    protected $newsletterModel;
    
    public function __construct(){
        $this->registrationModel = new Registration;
        $this->newsletterModel = new Newsletter;
    }
    
    
    public function index()
    {
        //echo "test ======================== "; exit();
        
        $alldata['banner_data'] = DB::table('banners')->get()->toArray();
        $alldata['languages_data'] = DB::table('languages')->get()->toArray();
        $alldata['whylearns_data'] = DB::table('whylearns')->get()->toArray();
        $alldata['whyteches_data'] = DB::table('whyteches')->get()->toArray();
        $alldata['howitworks_data'] = DB::table('howitworks')->get()->toArray();
        $alldata['howitworks_data'] = DB::table('howitworks')->get()->toArray();
        $alldata['becomefluents_data'] = DB::table('becomefluents')->get()->toArray();

        return view('home/homepage',$alldata);
    }
    
    
    public function forgot_password(Request $request)
    {

        if(count($request->all()) > 0) {   
            $validator = Validator::make($request->all(), [
                            'email'=>'required|email|regex:/(.+)@(.+)\.(.+)/i',
                        ]);


            if ($validator->fails()) { 
                return redirect('forgot-password')->withErrors($validator)->withInput(); 
            }else{
                
                $user = $this->registrationModel->where('email', '=', $request->email)
                                                ->where('deleted_at', '=', null)->get();
                
                if(count($user)>0){

                    $token = getToken([
                                'email'=>$request->email,
                                'id'=>$user[0]->id,
                            ]);
                    
                    
                    $updateData=[];
                    $updateData['remember_token'] = $token;
                    $updateData['updated_at'] = date('Y-m-d H:i:s'); 
        
                    $this->registrationModel->where('id',$user[0]->id)->update($updateData);
                    
                    $subject = 'Password Reset';

                    $data = [
                                'to' => $request->email,
                                'from' => env('MAIL_FROM_ADDRESS'),
                                'subject' => $subject,
                                'receiver' => $request->email,
                                'sender' => env('MAIL_FROM_NAME'),
                                'name' => $user[0]->name,
                                'url' => url('/').'/reset-password/'.$token
                            ];
        
                    Mail::to($request->email)->send(new ForgotPassword($data));
                    
                    return redirect()->back()->with(['success'=>'Reset password email has been sent to your email address']);
                    
                }else{
                    return redirect('forgot-password')->with('error','Email id does not exist!')->withInput(); 
                }
                
                            
            }
        }else{
            return view('user/forgot-password');   
        }
        
    }
    
    
    
    
    public function resetPassword(Request $request, $q){ //echo "zzzzzzzzzzzzzzzzzzzzz ".$q; exit();
        
        $data['q'] = $q;
        $token = decodeToken($q);
        
        $data['email'] = $token['data']['email'];
        $data['id'] = $token['data']['id'];
        
        //echo "<pre>"; echo $token['data']['email']; print_r($token['data']); exit();  
        
        if($request->has('npassword') && $request->has('rpassword')){  
            $validator = Validator::make($request->all(), [
                            'npassword'=>'required|min:6',
                            'rpassword'=>'required|same:npassword|min:6',
                        ]);

            if ($validator->fails()) { 
                return redirect('reset-password/'.$q)->withErrors($validator)->withInput();
            }else{
                
                $user = $this->registrationModel->where('id', '=', $request->u_id)
                                                ->where('remember_token', '=', $request->u_token)
                                                ->where('deleted_at', '=', null)->get();
                
                if(count($user)>0){
                    $updateData=[];

                    $updateData['updated_at'] = date('Y-m-d H:i:s'); 
                    $updateData['remember_token'] = null; 
                    $updateData['password'] = Hash::make($request->npassword);
                    
                    try{
                        $this->registrationModel->where('id',$request->u_id)->update($updateData);
    
                        return redirect('reset-password/'.$q)->with('success','New login password has been updated successfully.');
                        
                    }catch(Exception $e){
                        return redirect('reset-password/'.$q)->with('error','Please try again!');
                    }
                    
                }else{
                    return redirect('reset-password/'.$q)->with('error','Invalid token!');
                }
                
                
            }

        }else{ 
            return view('user.reset-password',$data);
        }
    }
    
    
    public function newsletter_email(Request $request)
    {

        if(count($request->all()) > 0) {   
            $validator = Validator::make($request->all(), [
                            'newsletter_email'=>'required|email|regex:/(.+)@(.+)\.(.+)/i',
                        ]);


            if ($validator->fails()) { 
                return redirect()->back()->withErrors($validator)->withInput(); 
            
            }else{
                
                $newsletter = $this->newsletterModel->where('email', '=', $request->newsletter_email)
                                                ->where('deleted_at', '=', null)->get();
                                                
                if(count($newsletter)>0){
                    return redirect()->back()->with('error_n','Email already subscribed!')->withInput();
                }
                

                $insertData = [
                            'email'=>$request->newsletter_email,
                            'created_at'=>date('Y-m-d H:i:s')
                        ];

                $newsletterId = $this->newsletterModel->insertGetId($insertData); 
    
                if($newsletterId!=''){
                    return redirect()->back()->with('success_n', 'Newsletter email has been sent successfully.'); 
                }else{
                    return redirect()->back()->with('error_n', 'Please try again!!')->withInput(); 
                }
                
                            
            }
        }
        
    }
    
    
}

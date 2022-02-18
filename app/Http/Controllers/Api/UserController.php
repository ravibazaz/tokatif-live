<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserRoles;
use App\Models\CustomerContact;
use App\Models\Activities;
use App\Models\Work;

use Illuminate\Support\Facades\Auth;
use Validator;
use Hash;
use DB;

use Illuminate\Support\Facades\Storage;

use App\Mail\Registration;
use App\Mail\ForgotPassword;
use Illuminate\Support\Facades\Mail;





/**
 * @group  User management
 *
 * APIs for managing user 
 */
class UserController extends Controller
{
    protected $userModel;
    protected $userRoleModel;
    protected $customerContactModel;
    protected $activitiesModel;
    protected $workModel;

    public function __construct(){
        $this->userModel = new User;
        $this->userRoleModel = new UserRoles();
        $this->customerContactModel = new CustomerContact();
        $this->activitiesModel = new Activities;
        $this->workModel = new Work;
    }



    /**
     *  All User Data 
     */
    public function getAllUserData(Request $request){

        $roles = $this->userRoleModel->where('deleted_at', '=', null)->get();

        $arr = array();
        foreach ($roles as $key => $value) { 
            //return $value->type;
            $data = $this->userModel->where('status', '=', 'active')
                            ->where('deleted_at', '=', null)
                            ->where('role_type', '=', $value->type)
                            ->get();

            $arr[$value->name] = $data;
        }

        $milestone = $this->workModel->select('name')
                                        ->where('deleted_at', '=', null)
                                        ->where('category','=','milestone')
                                        ->orderBy('name','asc')->get();

        $maintask = $this->workModel->select('name')
                                        ->where('deleted_at', '=', null)
                                        ->where('category','=','maintask')
                                        ->orderBy('name','asc')->get();

        $task = $this->workModel->select('name')
                                        ->where('deleted_at', '=', null)
                                        ->where('category','=','task')
                                        ->orderBy('name','asc')->get();

        $subtask = $this->workModel->select('name')
                                        ->where('deleted_at', '=', null)
                                        ->where('category','=','subtask')
                                        ->orderBy('name','asc')->get();

        
        return response(['status'=>"success", 
                        'message'=>'User data found.', 
                        'data'=>$arr,
                        'milestone'=>$milestone,
                        'maintask'=>$maintask,
                        'task'=>$task,
                        'subtask'=>$subtask
                    ]);
        
    }






    /**
	 *  User List
	 */
    public function list(Request $request){
        
        $userRole = $request->role_type;
        $search = $request->search;

        if (is_numeric($search)) {
            if($userRole!=''){
                $data = DB::table('users')
                            ->join('user_roles','users.role_type', '=', 'user_roles.type')
                            ->select('user_roles.name as role','users.*')
                            ->where('users.deleted_at', '=', null)
                            ->where('users.role_type', '=', $userRole)
                            ->whereJsonContains('users.phones', [$search])
                            ->orderBy('users.id','desc')->get();
            }else{
                $data = DB::table('users')
                            ->join('user_roles','users.role_type', '=', 'user_roles.type')
                            ->select('user_roles.name as role','users.*')
                            ->where('users.deleted_at', '=', null)
                            ->whereJsonContains('users.phones', [$search])
                            ->orderBy('users.id','desc')->get();
            }
            
        }else{

            if($userRole!='' && $search!=''){
                $data = DB::table('users')
                            ->join('user_roles','users.role_type', '=', 'user_roles.type')
                            ->select('user_roles.name as role','users.*')
                            ->where('users.deleted_at', '=', null)
                            ->where('users.role_type', '=', $userRole)
                            ->where('users.fname', 'like', '%'.$search.'%')
                            ->orWhere('users.lname', 'like', '%'.$search.'%')
                            ->orderBy('users.id','desc')->get();
            }elseif($userRole=='' && $search!=''){
                $data = DB::table('users')
                            ->join('user_roles','users.role_type', '=', 'user_roles.type')
                            ->select('user_roles.name as role','users.*')
                            ->where('users.deleted_at', '=', null)
                            ->where('users.fname', 'like', '%'.$search.'%')
                            ->orWhere('users.lname', 'like', '%'.$search.'%')
                            ->orderBy('users.id','desc')->get();
            }elseif($userRole!='' && $search==''){
                $data = DB::table('users')
                            ->join('user_roles','users.role_type', '=', 'user_roles.type')
                            ->select('user_roles.name as role','users.*')
                            ->where('users.deleted_at', '=', null)
                            ->where('users.role_type', '=', $userRole)
                            ->orderBy('users.id','desc')->get();
            }else{
                $data = DB::table('users')
                            ->join('user_roles','users.role_type', '=', 'user_roles.type')
                            ->select('user_roles.name as role','users.*')
                            ->where('users.deleted_at', '=', null)
                            ->orderBy('users.id','desc')->get();
            }
            
        }

        if(count($data)>0){
            return response(['status'=>"success", 'message'=>'User list found.', 'data'=>$data]);
        }else{
            return response(['status'=>"failure", 'message'=>'User not found!', 'data'=>$data]);
        }
        
        
    }


    /**
    * User Add
    * @bodyParam role_type integer required Role Id is required for this api
    * @bodyParam fname string required First name is required for this api
    * @bodyParam lname string required Last name is required for this api
    * @bodyParam email string required Email is required for this api
    * @bodyParam password string required Password is required for this api
    * @bodyParam phones array required Phones is required for this api
    * @bodyParam address string required Address is required for this api
    * @bodyParam latitude string required Latitude is required for this api
    * @bodyParam longitude string required Longitude is required for this api
    */
    public function add(Request $request){
        $data =(Object)$request->all();
        
        if($data->role_type=='7'){
            $validator = Validator::make($request->all(), [
                            'role_type' => 'required|integer|between:1,10',
                            'fname' => 'required',
                            'lname' => 'required',
                            'email'=>'required|email',
                            'password'=>'required',
                            //'phones' => 'array|min:1',
                            //'phones.*' => 'numeric|distinct|digits:10',
                            'address'=>'required',
                            'latitude'=>'required',
                            'longitude'=>'required',
                            'customer_contact_name' => 'required|string',
                            'customer_contact_email' => 'required|email',
                            //'customer_contact_phones' => 'required|array|min:1',
                            //'customer_contact_phones.*' => 'numeric|distinct|digits:10', 
                            'customer_contact_website'=>'required|url'
                        ]);
        }else{
            $validator = Validator::make($request->all(), [
                            'role_type' => 'required|integer|between:1,10',
                            'fname' => 'required',
                            'lname' => 'required',
                            'email'=>'required|email',
                            'password'=>'required',
                            //'phones' => 'array|min:1',
                            //'phones.*' => 'numeric|distinct|digits:10',
                            'address'=>'required',
                            'latitude'=>'required',
                            'longitude'=>'required'
                        ]);
        }
        
        if ($validator->fails()) { 
            //return response($validator->errors(),200);
            return response()->json(['status' => "failure",'message' => $validator->messages()], 406);  
        }else{   

            $roleExist = $this->userRoleModel->where(['type'=>$data->role_type])->count(); 
            $user = $this->userModel->where(['email'=>$data->email])->get(); 
            if(count($user)>0){
                return response([
                    'status'=>"failure",
                    'message'=>'Email id already exists!'
                ],200);
            }

            if($roleExist==0){
                return response([
                    'status'=>"failure",
                    'message'=>'Role type does not exists!'
                ],200);
            }

        
        $imageName = '';
        if($request->image!=''){
            $img = $request->image;  // your base64 encoded
            $image_parts = explode(";base64,", $img);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $imageName = uniqid() . '.'.$image_type;

            //file_put_contents($file, $image_base64);

            Storage::disk('local')->put($imageName, $image_base64);
        }
        



                //$otp =  randomNumber();
                $user = new User();

                $user->role_type = $data->role_type;
                $user->fname = ucfirst($data->fname); 
                $user->lname = ucfirst($data->lname);
                $user->email = $data->email;
                $user->password = Hash::make($data->password);
                //$user->phones = json_encode($data->phones);
                //$data->phones = ["1111111111"];
                $user->phones = json_encode($data->phones);
                $user->address = ucfirst($data->address);
                $user->latitude = $data->latitude;
                $user->longitude = $data->longitude;
                $user->photo = $imageName;

                if($data->role_type==1){
                    $accessModules = ["team", "roles", "customer", "work", "service", "project", "milestone", "maintask", "task", "subtask", "handover", "calender", "report"];
                    $user->access_modules = json_encode($accessModules);
                }
    
                $user->save();
                $user_id = $user->id;

                if($data->role_type=='7'){     
                    //$data->customer_contact_phones = ["1111111111"];
                    $insertData = [
                                'user_id'=>$user_id,
                                'name'=>ucfirst($request->customer_contact_name),
                                'email'=>$request->customer_contact_email,
                                'phones'=>json_encode($request->customer_contact_phones),
                                'website'=>$request->customer_contact_website
                            ];
 
                    $customer_contact_id = $this->customerContactModel->insertGetId($insertData);
                }

                if($user_id!=''){ 
                    $comment = 'Registration successful. Login email: '.$data->email;
                    $subject = 'New registration';
                    $body = 'Message: '.$comment;

                    $to = 'parna@crescentek.com';
                    //$to = $data->email;

                    $details = [
                        'to' => $to,
                        'from' => env('MAIL_FROM_ADDRESS'),
                        'subject' => $subject,
                        'receiver' => ucfirst($data->fname).' '.ucfirst($data->lname),
                        'sender' => env('MAIL_FROM_NAME'), 
                        'msg' => $comment, 
                        'body' => $body
                    ];

                    Mail::to($to)->send(new Registration($details));

                    if (Mail::failures()) {

                        return response()->json([
                            'status'  => false,
                            'message' => 'Email sending failed.. retry again...!!',
                            'data'    => $details
                        ]);

                    }else{

                        $token=getToken([
                            'email'=>$data->email,
                            'id'=>$user_id,
                            'role_type'=>$user->role_type
                        ]);
                        return response([
                            'status'=>"success",
                            'id'=>$user_id,
                            'email'=>$data->email,
                            'token'=>$token,
                            //'otp'=>$otp,
                            'message'=>'User has been registered successfully.'
                        ]);
                    }

                }
                
                
            
           
        }
       
    }



    /**
    * User Edit
    */
    public function edit(Request $request){
        $data =(Object)$request->all();
        
        $validator = Validator::make($request->all(), [
            'fname' => 'string',
            'lname' => 'string',
            //'email'=> 'email',
            'password'=> 'string',
            'phones' => 'array|min:1',
            'phones.*' => 'numeric|distinct|digits:10',
            'address'=> 'string',
            'latitude'=> 'numeric',
            'longitude'=> 'numeric'
        ]);

        //return $request->id;
        
        if ($validator->fails()) {  
            //return response($validator->errors(),403);
            return response()->json(['status' => "failure",'message' => $validator->messages()], 406);  
        }else{   

            $userData = $this->userModel->where('id',$request->id)->first();  

            if($userData){
                
                $updateData=[];

                /*if($request->has('email')){
                    $user = $this->userModel->where(['email'=>$data->email])->get(); 
                    if(count($user)>0 && $request->email != $userData->email){
                        return response([
                            'status'=>"failure",
                            'message'=>'Email id already exists!'
                        ],409);
                    }else{
                        $updateData['email'] = $request->email;
                    }
                }*/

                if($request->has('fname')){
                    $updateData['fname'] = ucfirst($request->fname); 
                }
                if($request->has('lname')){
                    $updateData['lname'] = ucfirst($request->lname); 
                }
                if($request->has('password')){
                    $updateData['password'] = Hash::make($request->password);
                }
                if($request->has('phones')){
                    $updateData['phones'] = $request->phones; 
                }
                if($request->has('address')){
                    $updateData['address'] = $request->address; 
                }
                if($request->has('latitude')){
                    $updateData['latitude'] = $request->latitude; 
                }
                if($request->has('longitude')){
                    $updateData['longitude'] = $request->longitude; 
                }


                try{
                    $this->userModel->where('id',$request->id)->update($updateData);

                    $updatedUserData = $this->userModel->where('id',$request->id)->first();  
                    return response(['status'=>"success", 'message'=>'User data has been updated successfully.', 'data'=>$updatedUserData]);
                    
                }catch(Exception $e){
                    return response(['status'=>"failure", 'message'=>'Please try again!', 'error'=>$e],200);
                }
            

            }else{
                return response([
                                'status'=>"failure",
                                'message'=>'User data not found!'
                            ],200); 
            }
            
           
        }
       
    }







    /**
    * Change Password
    */
    public function change_password(Request $request){
        $data =(Object)$request->all();
        
        $validator = Validator::make($request->all(), [
            'old_password'=> 'required|string',
            'new_password'=> 'required|string'
        ]);

        
        if ($validator->fails()) {  
            //return response($validator->errors(),200);
            return response()->json(['status' => "failure",'message' => $validator->messages()], 406);  
        }else{   

            $role_type = $request->decode->role_type;
            $user_id = $request->decode->id;

            $userData = $this->userModel->where('id',$user_id)
                                        ->where('deleted_at', '=', null)
                                        ->first();  

            if($userData){
                //return $userData->id." >> ".$userData->password;

                if (!Hash::check($request->old_password, $userData->password)) {
                    return response([
                                'status'=>"failure",
                                'message'=>'The old password does not match our records.'
                            ],200); 
                }

                $updateData=[];
                
                if($request->has('new_password')){
                    $updateData['password'] = Hash::make($request->new_password);
                }
                
                try{
                    $this->userModel->where('id',$user_id)->update($updateData);

                    $updatedUserData = $this->userModel->where('id',$user_id)->first();  
                    return response(['status'=>"success", 'message'=>'User password has been updated successfully.', 'data'=>$updatedUserData]);
                    
                }catch(Exception $e){
                    return response(['status'=>"failure", 'message'=>'Please try again!', 'error'=>$e],200);
                }
            

            }else{
                return response([
                                'status'=>"failure",
                                'message'=>'User not found!'
                            ],200); 
            }
            
           
        }
       
    }




    /**
    * Forgot Password
    */
    public function forgot_password(Request $request){
        $data =(Object)$request->all();
        
        $validator = Validator::make($request->all(), [
            'email'=> 'required|email'
        ]);

        
        if ($validator->fails()) {  
            //return response($validator->errors(),200);
            return response()->json(['status' => "failure",'message' => $validator->messages()], 406);  
        }else{   

            $userData = $this->userModel->where('email',$request->email)
                                        ->where('deleted_at', '=', null)
                                        ->first();  

            if($userData){
                
                try{

                    //return $userData;

                    $subject = 'OTP to reset your password.';
                    $url = url('/');

                    $otp = rand(100000,999999);

                    $to = $request->email;
                    $details = [
                                'to' => $to,
                                'from' => env('MAIL_FROM_ADDRESS'),
                                'subject' => $subject,
                                'receiver' => ucfirst($userData->fname).' '.ucfirst($userData->lname),
                                'sender' => env('MAIL_FROM_NAME'), 
                                'otp' => $otp
                            ];

                    Mail::to($to)->send(new ForgotPassword($details));

                    if (Mail::failures()) {

                        return response()->json([
                            'status'  => false,
                            'message' => 'Email sending failed.. retry again...!!',
                            'data'    => $details
                        ]);

                    }else{

                        $updateData=[];
                
                        $updateData['remember_token'] = $otp;
                        
                        $this->userModel->where('id',$userData->id)->update($updateData);

                        return response([
                            'status'=>"success",
                            'message'=>'OTP has been sent to '.$to
                        ]);
                    }
                    
                }catch(Exception $e){
                    return response(['status'=>"failure", 'message'=>'Please try again!', 'error'=>$e],200);
                }
            

            }else{
                return response([
                                'status'=>"failure",
                                'message'=>'User email not found!'
                            ],200); 
            }
            
           
        }
       
    }



    /**
    * Reset Password
    */
    public function reset_password(Request $request){
        $data =(Object)$request->all();
        
        $validator = Validator::make($request->all(), [
            'email'=> 'required|email',
            'otp'=> 'required',
            'new_password'=> 'required'
        ]);

        
        if ($validator->fails()) {  
            //return response($validator->errors(),200);
            return response()->json(['status' => "failure",'message' => $validator->messages()], 406);  
        }else{   

            $userData = $this->userModel->where('email',$request->email)
                                        ->where('deleted_at', '=', null)
                                        ->first();  

            if($userData){
                
                $remember_token = $userData->remember_token;

                if($request->otp != $remember_token){
                    return response()->json([
                            'status'  => 'failure',
                            'message' => 'Not a valid OTP!!'
                        ]);
                }

                try{

                    $updateData=[];
            
                    $updateData['password'] = Hash::make($request->new_password);
                    $updateData['remember_token'] = null;
                    
                    $this->userModel->where('id',$userData->id)->update($updateData);

                    return response([
                        'status'=>"success",
                        'message'=>'Your password has been updated successfully.'
                    ]);
                    
                    
                }catch(Exception $e){
                    return response(['status'=>"failure", 'message'=>'Please try again!', 'error'=>$e],200);
                }
            

            }else{
                return response([
                                'status'=>"failure",
                                'message'=>'User email not found!'
                            ],200); 
            }
            
           
        }
       
    }
    

    /**
    * User Access Rights
    */
    public function access_modules(Request $request){
        
        //return $request->decode;
        $role_type = $request->decode->role_type;
        $user_id = $request->decode->id;

        if($user_id=='' && $role_type==''){
            return response([
                'status'=>"failure",
                'message'=>'Please provide a valid token!'
            ],401);
        }

     
        $data = $this->userModel->select('fname','lname','access_modules')
                                ->where('status', '=', 'active')
                                ->where('deleted_at', '=', null)
                                ->where('id', '=', $user_id)
                                ->get();
       
        
        if(count($data)>0){
            return response(['status'=>"success", 'message'=>'User access right modules found.', 'data'=>$data]);
        }else{
            return response(['status'=>"failure", 'message'=>'No data found!', 'data'=>$data]);
        }
       
    }




    /**
    * User Activities
    */
    public function activities(Request $request){
        
        //return $request->decode;
        $role_type = $request->decode->role_type;
        $user_id = $request->decode->id;

        if($user_id=='' && $role_type==''){
            return response([
                'status'=>"failure",
                'message'=>'Please provide a valid token!'
            ],401);
        }

        //return $user_id;
        
        $data = $this->activitiesModel->select('*')
                                ->where('deleted_at', '=', null)
                                ->where('assigned_to', '=', $user_id)
                                ->whereDate('created_at', date("Y-m-d"))
                                ->get();
       
        
        if(count($data)>0){
            return response(['status'=>"success", 'message'=>'Activity list found.', 'data'=>$data]);
        }else{
            return response(['status'=>"failure", 'message'=>'No activity found for today!', 'data'=>$data]);
        }
       
    }




    /**
	 *  Delete User 
	 *
	 * @urlParam id int required for this api
	 *
	 */
    /*public function delete(Request $request){
        $user_id = $request->decode->id;
        $id = $request->id;
        $addr =  $this->userModel->where(['user_id'=>$user_id, 'id'=>$id])->first();
        if($addr){
            $this->userModel->where(['id'=>$id])->delete();
            return response(['status'=>"success", 'message'=>'Address has been deleted successfully']);
        }else{
            return response(['status'=>"failure", 'message'=>'Id not found'],200);
        }

    }*/



}

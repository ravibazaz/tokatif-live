<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\UserRoles;
use App\Models\Log;
use Hash;
use DB;
use Storage;

/**
 * @group  Login
 *
 * APIs for managing Login
 */
class LoginController extends Controller
{
    protected $userModel;
    protected $userRoleModel;
    protected $logModel;

    public function __construct(){
        $this->userModel = new User();
        $this->userRoleModel = new UserRoles();
        $this->logModel = new Log();
    }

    
    /**
    * Login 
    * @bodyParam email string required EmailId is required for this api
    * @bodyParam password string required Password is required for this api
    */
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password'=>'required'
        ]);
        if ($validator->fails()) {
            //return response($validator->errors(),200);
            return response()->json(['status' => "failure",'message' => $validator->messages()], 406);  
        }else{  
            $response = [];
            $data = (Object)$request->all(); 
            $user = $this->userModel->where(['email'=>$data->email])->get();
            //return $user; 

            if(count($user)>0){  
                if(Hash::check($data->password,$user[0]->password)){
                    //if($user[0]->is_phone_verified=='Y'){
                        // $otp =  randomNumber();

                    $userPhoneArr = json_decode($user[0]->phones, true);
                    $userPhoneVal = '';
                    foreach($userPhoneArr as $v){
                        $userPhoneVal .= $v.','; 
                    }
                    $userPhones = rtrim($userPhoneVal, ',');


                        $token=getToken([
                                'email'=>$user[0]->email,
                                'id'=>$user[0]->id,
                                'role_type'=>$user[0]->role_type
                            ]);

                        $userRole = $this->userRoleModel->where('type',$user[0]->role_type)->get();
                        if(count($userRole)>0){
                            $role = $userRole[0]->name;
                        }
                        if($user[0]->status=='active'){

                            $insertLogData = [
                                                'user_id'=>$user[0]->id,
                                                'user_role'=>$role,
                                                'logType'=>'login',
                                                'created_at'=>date('Y-m-d H:i:s')
                                            ];
                            $this->logModel->insert($insertLogData);

                            $response['status']="success";
                            
                            return response([
                                'status'=>"success",
                                'token'=>$token,
                                'user_id'=>$user[0]->id,
                                'user_name'=>$user[0]->fname.' '.$user[0]->lname,
                                'user_email'=>$user[0]->email,
                                'user_phone'=>$userPhones,
                                'user_address'=>$user[0]->address,
                                'account_status'=>$user[0]->status,
                                'role_type'=>$user[0]->role_type,
                                'role'=>$role,
                                'message'=>'Login successfull.'
                            ],200);
                        }elseif($user[0]->status=='pending'){
                            return response([
                                'status'=>"success",
                                'token'=>$token,
                                'user_id'=>$user[0]->id,
                                'user_name'=>$user[0]->fname.' '.$user[0]->lname,
                                'user_email'=>$user[0]->email,
                                'user_phone'=>$userPhones,
                                'user_address'=>$user[0]->address,
                                'account_status'=>$user[0]->status,
                                'role_type'=>$user[0]->role_type,
                                'role'=>$role,
                                'message'=>'User has not activated! Please contact to the administrator.'
                            ],200);
                        }else{
                            return response([
                                'status'=>"success",
                                'token'=>$token,
                                'user_id'=>$user[0]->id,
                                'user_name'=>$user[0]->fname.' '.$user[0]->lname,
                                'user_email'=>$user[0]->email,
                                'user_phone'=>$userPhones,
                                'user_address'=>$user[0]->address,
                                'account_status'=>$user[0]->status,
                                'role_type'=>$user[0]->role_type,
                                'role'=>$role,
                                'message'=>'User has blocked by admin! Please contact to the administrator.'
                            ],200);
                        }

                    //}
                    /*else{

                        $otp =  randomNumber();
                        $this->userModel->where('id',$user[0]->id)->update(['otp'=>$otp]);
                        $token=getToken([
                            'phone'=>$user[0]->store_phone,
                            'id'=>$user[0]->id,
                            'role'=>'store'
                        ]);
                        return response([
                            'status'=>"success",
                            'token'=>$token,
                            'isPhoneVerified'=>"failure",
                            'otp'=>$otp,
                            'message'=>'User not verified phonenumber'
                        ],200);

                    }*/
                    
                    
                }else{
                    return response([
                        'status'=>"failure",
                        'message'=>'Username/Password invalid!'
                    ],200);
                }
                
            }else{
                return response([
                    'status'=>"failure",
                    'message'=>'Username/Password invalid!'
                ],200);
            }
        }
    }


    

    /**
    * Logout 
    */
    public function logout(Request $request){ return $request; die();
        $data = (Object)$request->all();
        $user_id = $request->decode->id;
        $role_type = $request->decode->role_type;

        $userRole = $this->userRoleModel->where('id',$role_type)->get();
        if(count($userRole)>0){
            $role = $userRole[0]->name;
        }
        
        if($role_type!=''){
            $insertLogData = [
                                'user_id'=>$user_id,
                                'user_role'=>$role,
                                'logType'=>'logout',
                                'created_at'=>date('Y-m-d H:i:s')
                            ];
            $this->logModel->insert($insertLogData);

            return response([
                'status'=>"success",
                'role_type'=>$role_type,
                'id'=>$user_id,
                'message'=>'User has been logged out successfully.'
            ],200);

        }else{
            return response([
                'status'=>"failure",
                'message'=>'Please provide a valid token!'
            ]);
        }
    }











}

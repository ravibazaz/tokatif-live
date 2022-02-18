<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserRoles;
use Validator;
use Storage;

/**
 * @group  User Role Management
 *
 * APIs for managing user roles
 */
class RoleController extends Controller
{
    protected $userRoleModel;
    
    public function __construct(){
        $this->userRoleModel = new UserRoles;
    }

    /**
	 *  All user roles
	 *
	 */
    public function list(Request $request){
        try{
            $data = $this->userRoleModel->where('deleted_at', '=', Null)->get();
        }catch(Exception $e){
            return response(['status'=>"failure",'message'=>$e],200);
        }
        return response(['status'=>"success", 'message'=>'User role found.', 'data'=>$data]);
    }


    /**
	 *  Create User Role
	 * @bodyParam name string required Role name required for this post
     * @bodyParam type string  required Role type required for this post 
	 * 
	 */
    public function add(Request $request){
        $validator=Validator::make($request->all(),[
            'name'=>'required|string',
            'type'=>'required|integer|between:1,10'

        ]);

        if($validator->fails()){
            //return response($validator->errors(),200); 
            return response()->json(['status' => "failure",'message' => $validator->messages()], 406);  
        }else{
            
            try{
                $roleData = $this->userRoleModel->where(['name'=>$request->name])->get();
                $roleTypeData = $this->userRoleModel->where(['type'=>$request->type])->get();
            }catch(Exception $e){
                return response(['status'=>"failure", 'message'=>$e],200);
            }

            if(count($roleData)>0){
                return response(['status'=>"failure", 'message'=>'User role name already exists!']);
            }
            if(count($roleTypeData)>0){
                return response(['status'=>"failure", 'message'=>'User role type already exists!']);
            }

            $insertData=[
                'name'=>ucfirst($request->name),
                'type'=>$request->type
            ];

            $this->userRoleModel->insert($insertData);
            return response(['status'=>"success",'message'=>'User role has been added successfully.']);

        }
    }


     /**
	 *  Edit User Role
	 * @bodyParam name string required Role name required for this post
     * @bodyParam type numeric required Role type required for this post
	 * 
	 *
	 */
    public function edit(Request $request){
        $validator = Validator::make($request->all(),[
            'name'=>'required|string',
            'type'=>'required|integer|between:1,10'
            
        ]);

        if($validator->fails()){
            //return response(['status'=>"failure", 'error'=>$validator->errors()]);
            return response()->json(['status' => "failure",'message' => $validator->messages()], 406);  
        }

        $roleData = $this->userRoleModel->where('id',$request->id)->first();  
        //return $roleData->type;

        $updateData=[];
        if($roleData){

            if($request->has('name')){
                $isNameExist = $this->userRoleModel->where(['name'=>$request->name])->get();
                if(count($isNameExist)>0 && $isNameExist[0]->id!=$request->id){
                    return response(['status'=>"failure", 'message'=>'Role name already exist!'],200);
                }else{
                    $updateData['name']=ucfirst($request->name);
                }
            }

            if($request->has('type')){
                $isTypeExist = $this->userRoleModel->where(['type'=>$request->type])->get();
                if(count($isTypeExist)>1 && $isTypeExist[0]->id!=$request->id){
                    return response(['status'=>"failure", 'message'=>'Role type already exist!'],200);
                }else{
                    $updateData['type']=$request->type;
                }
            }

            
            try{
                $this->userRoleModel->where('id',$request->id)->update($updateData);
                return response(['status'=>"success", 'message'=>'User role has been updated successfully.']);
            }catch(Exception $e){
                return response(['status'=>"failure", 'message'=>'Something Error', 'error'=>$e],200);
            }
            

        }else{
            return response(['status'=>"failure", 'message'=>'Data not found!'],200);
        }
    }

     /**
	 *  Delete User Role
	 * @urlParam id int required User role id required for this api
	 * 
	 */
    public function delete(Request $request){
        //dd($request);
        $id = $request->id; 
        $userData = $this->userRoleModel->where('id',$id)->get();
        if(count($userData)>0){
            $this->userRoleModel->where(['id'=>$id])->delete();
            return response(['status'=>"success", 'message'=>'User role has been deleted successfully.']);

        }else{
            return response(['status'=>"failure",'message'=>'User role not found!'],200);
        }
    }
}

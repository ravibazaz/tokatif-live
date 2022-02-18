<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Work;
use Validator;
use Hash;
use DB;



/** 
 * @group Work Management
 * 
 * This api for work management 
 */
class WorkController extends Controller
{
    protected $workModel;

    public function __construct(){
        $this->workModel = new Work;
    }

    /**
     * Work list 
     * 
     */
    public function list(Request $request){ 

        //return $request->decode;
        $role_type = $request->decode->role_type;
        $user_id = $request->decode->id;

        if($user_id!='' && ($role_type!=7 || $role_type!=8 || $role_type!=9)){
            $WorkName = $request->search;

            if($WorkName==''){
                $data = $this->workModel->where('deleted_at', '=', null)->where('category','=','work')->get();

            }else{

                $data = $this->workModel->where('deleted_at', '=', null)			
                				->where('category','=','work')
                                ->where('name', 'like', '%'.$WorkName.'%')
                                ->get();
            }

            if(count($data)>0){
                return response(['status'=>"success", 'message'=>'Work list found.', 'data'=>$data]);
            }else{
                return response(['status'=>"failure", 'message'=>'Work not found!', 'data'=>$data]);
            }

            

        }else{
            return response([
                'status'=>"failure",
                'message'=>'Please provide a valid token!'
            ],200);
        }
        
    }

    /**
     * Work add
     * @bodyParam name string required Work name  
     * @bodyParam number int required Work number
     * @bodyParam units int required Work units
     * @bodyParam warranty_period alphanumeric required Work warranty period
     */
    public function add(Request $request){  
        $role_type = $request->decode->role_type;
        $user_id = $request->decode->id;
        //return $request->decode;

        $role_type = $request->decode->role_type;
        $user_id = $request->decode->id;  


        if($user_id=='' && ($role_type!=7 || $role_type!=8 || $role_type!=9)){
            return response([
                'status'=>"failure",
                'message'=>'Please provide a valid token!'
            ],401);
        }

        $validator = Validator::make($request->all(), [
        					'category' => 'required|string|in:milestone,maintask,task,subtask,work',
                            'name' => 'required|string',
                            'units' => 'string|in:SQM,LM,Pieces,Lum-sum,Hour,Day',
                            'warranty_period' => 'string'
                        ]);

        if ($validator->fails()) { 
            //return response($validator->errors(),403);
            return response()->json(['status' => "failure",'message' => $validator->messages()], 406);  
        }else{ 
            
            $data =(Object) $request->all();
            $product = $this->workModel->where(['name'=>$data->name])->get();
            if(count($product)>0){
                return response([
                    'status'=>"failure",
                    'message'=>'Work already exists!'
                ],200);
            }else{
                
                $insertData=[
                			'category'=>$request->category,
                            'name'=>ucfirst($request->name),
                            'units'=>$request->units,
                            'warranty_period'=>$request->warranty_period,
                            'added_by'=>$request->decode->id,
                            'created_at'=>date('Y-m-d H:i:s')
                        ];

                $workId = $this->workModel->insertGetId($insertData);
                
                return response([
                    'status'=>"success",
                    'work_id'=>$workId,
                    'message'=>'Work has been added successfully.'
                ]);
                

            }
        }

    }




    public function edit(Request $request){

        $role_type = $request->decode->role_type;
        $user_id = $request->decode->id;   

        if($user_id=='' && ($role_type!=7 || $role_type!=8 || $role_type!=9)){
            return response([
                'status'=>"failure",
                'message'=>'Please provide a valid token!'
            ],401);
        }

        $validator = Validator::make($request->all(), [
                            'name' => 'string',
                            'units' => 'string|in:SQM,LM,Pieces,Lum-sum,Hour,Day',
                            'warranty_period'=>'alpha_num'
                        ]);

        if ($validator->fails()) { 
            //return response($validator->errors(),200);
            return response()->json(['status' => "failure",'message' => $validator->messages()], 406);  
        }else{ 

            $workData = $this->workModel->where('id',$request->id)->first();  

            if($workData){
                $updateData=[];

                $updateData['updated_at'] = date('Y-m-d H:i:s'); 
                
                if($request->has('name')){
                    $work = $this->workModel->where(['name'=>$request->name])->get(); 
                    if(count($work)>0 && $request->name != $workData->name){
                        return response([
                            'status'=>"failure",
                            'message'=>'Work name already exists!'
                        ],200);
                    }else{
                        $updateData['name'] = ucfirst($request->name);
                    }
                }

                if($request->has('units')){
                    $updateData['units'] = $request->units; 
                }
                if($request->has('warranty_period')){
                    $updateData['warranty_period'] = $request->warranty_period; 
                }
                
                try{
                    $this->workModel->where('id',$request->id)->update($updateData);

                    $updatedData = $this->workModel->where('id',$request->id)->first();  
                    return response(['status'=>"success", 'message'=>'Work has been updated successfully.', 'data'=>$updatedData]);
                    
                }catch(Exception $e){
                    return response(['status'=>"failure", 'message'=>'Please try again!', 'error'=>$e],200);
                }

            }else{
                return response([
                                'status'=>"failure",
                                'message'=>'Work not found!'
                            ],200); 
            }
        }

    }


    /*public function delete(Request $request){
        $store_id = $request->decode->id;
        $id= $request->id;
        $prod = $this->workModel
        ->join('product_categories','product_categories.id','=','products.prod_cat_id')
        ->where(['products.id'=>$id,'product_categories.store_id'=>$store_id])->get();
        if(count($prod)>0){
            $this->workModel->where('id',$id)->delete();
            return response([
                'status'=>"success",
                'message'=>'Work has been deleted successfully'
            ]);
        }else{
            return response([
                    'status'=>"failure",
                    'message'=>'Work not found'
            ],404);

        }
    }*/
    
}

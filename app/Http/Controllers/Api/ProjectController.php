<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Work;
use App\Models\User;
use Validator;
use Hash;
use DB;

use App\Mail\ProjectCreation;
use Illuminate\Support\Facades\Mail;

/** 
 * @group Project Management
 * 
 * This api for Project management 
 */
class ProjectController extends Controller
{
    protected $workModel;
    protected $projectModel;
    protected $userModel;

    public function __construct(){
        $this->workModel = new Work;
        $this->projectModel = new Project;
        $this->userModel = new User;
    }

    /**
     * Project list 
     * 
     */
    public function list(Request $request){ 

        //return $request->decode;
        $role_type = $request->decode->role_type;
        $user_id = $request->decode->id;

        
        if($user_id!=''){
            $ProjectName = $request->search;

            $newArr = array();

            if($role_type==1){
                if($ProjectName==''){
                    $projectData = DB::table('project')
                                        ->join('users','project.added_by', '=', 'users.id')
                                        ->select('project.*','users.fname as created_by')
                                        ->where('project.deleted_at', '=', null)
                                        ->orderBy('project.id','desc')->get();
                }else{
                    
                    $projectData = DB::table('project')
                                        ->join('users','project.added_by', '=', 'users.id')
                                        ->select('project.*','users.fname as created_by')
                                        ->where('project.deleted_at', '=', null)
                                        ->where('project.name', 'like', '%'.$request->search.'%')
                                        ->orderBy('project.id','desc')->get();
                }
            
            }else{

                if($ProjectName==''){
                    $projectData = DB::table('project')
                                        ->join('users','project.added_by', '=', 'users.id')
                                        ->select('project.*','users.fname as created_by')
                                        ->where('project.deleted_at', '=', null)
                                        ->where('project.project_manager_id', '=', $user_id)
                                        ->orWhere('project.project_supervisor_id', '=', $user_id)
                                        ->orderBy('project.id','desc')->get();
                }else{
                    
                    $projectData = DB::table('project')
                                        ->join('users','project.added_by', '=', 'users.id')
                                        ->select('project.*','users.fname as created_by')
                                        ->where('project.deleted_at', '=', null)
                                        ->where('project.name', 'like', '%'.$request->search.'%')
                                        ->where('project.project_manager_id', '=', $user_id)
                                        ->orWhere('project.project_supervisor_id', '=', $user_id)
                                        ->orderBy('project.id','desc')->get();
                }
            }
//return $projectData;
            if(count($projectData)>0){
                foreach ($projectData as $key => $value) {
                    $customerData = $this->userModel->where('id',$value->customer_id)->first();
                    $designerData = $this->userModel->where('id',$value->designer_id)->first();
                    $projectManagerData = $this->userModel->where('id',$value->project_manager_id)->first();
                    $projectSupervisorData = $this->userModel->where('id',$value->project_supervisor_id)->first();
                    
                    $newArr[] = array('id'=>$value->id,
                                    /*'work_id'=>$value->work_id,*/
                                    'name'=>$value->name,
                                    'project_no'=>$value->project_no,
                                    'contract_no'=>$value->contract_no,
                                    'start_date'=>$value->start_date,
                                    'end_date'=>$value->end_date,
                                    'address'=>$value->address,
                                    'latitude'=>$value->latitude,
                                    'longitude'=>$value->longitude,
                                    'customer_id'=>$value->customer_id,
                                    'customer_name'=>$customerData->fname.' '.$customerData->lname,
                                    'customer_address'=>$customerData->address,
                                    'customer_phones'=>$customerData->phones,
                                    'customer_email'=>$customerData->email,
                                    'designer_id'=>$value->designer_id,
                                    'designer_name'=>$designerData->fname.' '.$designerData->lname,
                                    'designer_email'=>$designerData->email,
                                    'designer_phones'=>$designerData->phones,
                                    'project_manager_id'=>$value->project_manager_id,
                                    'project_manager_name'=>$projectManagerData->fname.' '.$projectManagerData->lname,
                                    'project_manager_email'=>$projectManagerData->email,
                                    'project_manager_phones'=>$projectManagerData->phones,
                                    'project_supervisor_id'=>$value->project_supervisor_id,
                                    'project_supervisor_name'=>$projectSupervisorData->fname.' '.$projectSupervisorData->lname,
                                    'project_supervisor_email'=>$projectSupervisorData->email,
                                    'project_supervisor_phones'=>$projectSupervisorData->phones,
                                    'added_by'=>$value->added_by,
                                    'created_at'=>$value->created_at,
                                    );
                }
            }

            return response(['status'=>"success", 'message'=>'Project list found.', 'data'=>$newArr]);

        }else{
            return response([
                'status'=>"failure",
                'message'=>'Please provide a valid token!'
            ],401);
        }
        
    }

    /**
     * Project add 
     * @bodyParam customer_id int required Customer Id
     * @bodyParam name string required Project name  
     * @bodyParam project_no alphanumeric required Project number
     * @bodyParam contract_no alphanumeric required Contract number
     * @bodyParam start_date datetime required Project start date
     * @bodyParam end_date datetime required Project end date
     */
    public function add(Request $request){  
        
        //return $request->decode;

        $role_type = $request->decode->role_type;
        $user_id = $request->decode->id;   

        if($user_id=='' && ($role_type!=1)){
            return response([
                'status'=>"failure",
                'message'=>'Please provide a valid token!'
            ],401);
        }

        $validator = Validator::make($request->all(), [
                            //'work_id' => 'required|numeric',
                            'name' => 'required|string',
                            'customer_project_no' => 'required|string',
                            'contract_no' => 'required|string',
                            'start_date' => 'required|date_format:Y-m-d',
                            'end_date' => 'required|date_format:Y-m-d|after_or_equal:start_date',
                            'customer_id' => 'required|numeric',
                            'designer_id' => 'required|numeric',
                            'project_manager_id' => 'required|numeric', 
                            'project_supervisor_id' => 'required|numeric',
                            'address'=>'required',
                            'latitude'=>'required',
                            'longitude'=>'required'
                        ]);

        if ($validator->fails()) { 
            //return response($validator->errors(['status'=>"failure"]),200); 
            return response()->json(['status' => "failure",'message' => $validator->messages()], 406);  
        }else{ 
            
            $data =(Object) $request->all();

            $projectName = $this->projectModel->where(['project_no'=>$data->name])->get();
            if(count($projectName)>0){
                return response([
                    'status'=>"failure",
                    'message'=>'Project name already exists!'
                ],200);
            }

            $project = $this->projectModel->where(['project_no'=>$data->customer_project_no])->get();
            if(count($project)>0){
                return response([
                    'status'=>"failure",
                    'message'=>'Project number already exists!'
                ],200);
            }

            /*$workExistCheck = $this->workModel->where(['id'=>$data->work_id])->get(); 
            if(count($workExistCheck)==0){
                return response([
                    'status'=>"failure",
                    'message'=>'Work does not exists!'
                ],200);
            }*/

            $customerExistCheck = $this->userModel->where(['id'=>$data->customer_id,'role_type'=>7,'status'=>'active'])->get(); 
            if(count($customerExistCheck)==0){
                return response([
                    'status'=>"failure",
                    'message'=>'Customer does not exists!'
                ],200);
            }

            $designerExistCheck = $this->userModel->where(['id'=>$data->designer_id,'role_type'=>8,'status'=>'active'])->get(); 
            if(count($designerExistCheck)==0){
                return response([
                    'status'=>"failure",
                    'message'=>'Designer does not exists!'
                ],200);
            }

            $projectManagerExistCheck = $this->userModel->where(['id'=>$data->project_manager_id,'role_type'=>2,'status'=>'active'])->get(); 
            if(count($projectManagerExistCheck)==0){
                return response([
                    'status'=>"failure",
                    'message'=>'Project manager does not exists!'
                ],200);
            }

            
            $projectSupervisorExistCheck = $this->userModel->where(['id'=>$data->project_supervisor_id,'role_type'=>3,'status'=>'active'])->get(); 
            if(count($projectManagerExistCheck)==0){
                return response([
                    'status'=>"failure",
                    'message'=>'Project supervisor does not exists!'
                ],200);
            }

            //return "......valid....";

            $insertData=[
                        //'work_id'=>$request->work_id,
                        'name'=>ucfirst($request->name),
                        'project_no'=>$request->customer_project_no,
                        'contract_no'=>$request->contract_no,
                        'start_date'=>$request->start_date,
                        'end_date'=>$request->end_date,
                        'customer_id'=>$request->customer_id,
                        'designer_id'=>$request->designer_id,
                        'project_manager_id'=>$request->project_manager_id,
                        'project_supervisor_id'=>$request->project_supervisor_id,
                        'added_by'=>$request->decode->id,
                        'address'=>$request->address,
                        'latitude'=>$request->latitude,
                        'longitude'=>$request->longitude,
                        'status'=>'1',
                        'created_at'=>date('Y-m-d H:i:s'),
                        'title'=>ucfirst($request->name),
                        'start'=>date("Y-m-d H:i:s", strtotime($request->start_date)),
                        'end'=>date("Y-m-d H:i:s", strtotime($request->end_date))
                    ];

            $projectId = $this->projectModel->insertGetId($insertData);

            if($projectId!=''){
                $activity = "New project created: ".ucfirst($request->name);
                $added_by = $request->decode->id;
                $assigned_to = $request->project_manager_id;
                $project_id = $projectId;
                $milestone_id = NULL;
                $main_task_id = NULL;
                $task_id = NULL;
                $sub_task_id = NULL;

                $activityId = addActivity($activity,$added_by,$assigned_to,$project_id,$milestone_id,$main_task_id,$task_id,$sub_task_id);

                $assigned_to_1 = $request->project_supervisor_id;
                $activityId_1 = addActivity($activity,$added_by,$assigned_to_1,$project_id,$milestone_id,$main_task_id,$task_id,$sub_task_id);

                $assigned_to_2 = $request->designer_id;
                $activityId_2 = addActivity($activity,$added_by,$assigned_to_2,$project_id,$milestone_id,$main_task_id,$task_id,$sub_task_id);

                /*$projectData = DB::table('project')
                                    ->join('users','project.added_by', '=', 'users.id')
                                    ->select('project.*','users.fname as created_by')
                                    ->where('project.deleted_at', '=', null)
                                    ->where('project.id', '=', $projectId)
                                    ->orderBy('project.id','desc')->first();*/
                                    

                $projectData = $this->projectModel->where('id',$projectId)->first(); 

                $customerData = $this->userModel->where('id',$projectData->customer_id)->first();
                $designerData = $this->userModel->where('id',$projectData->designer_id)->first();
                $projectManagerData = $this->userModel->where('id',$projectData->project_manager_id)->first();
                $projectSupervisorData = $this->userModel->where('id',$projectData->project_supervisor_id)->first();
                
                $newArr = array('id'=>$projectData->id,
                                //'work_id'=>$projectData->work_id,
                                'name'=>$projectData->name,
                                'project_no'=>$projectData->project_no,
                                'contract_no'=>$projectData->contract_no,
                                'start_date'=>$projectData->start_date,
                                'end_date'=>$projectData->end_date,
                                'address'=>$projectData->address,
                                'latitude'=>$projectData->latitude,
                                'longitude'=>$projectData->longitude,
                                'customer_id'=>$projectData->customer_id,
                                'customer_name'=>$customerData->fname.' '.$customerData->lname,
                                'customer_address'=>$customerData->address,
                                'customer_phones'=>$customerData->phones,
                                'customer_email'=>$customerData->email,
                                'designer_id'=>$projectData->designer_id,
                                'designer_name'=>$designerData->fname.' '.$designerData->lname,
                                'designer_email'=>$designerData->email,
                                'designer_phones'=>$designerData->phones,
                                'project_manager_id'=>$projectData->project_manager_id,
                                'project_manager_name'=>$projectManagerData->fname.' '.$projectManagerData->lname,
                                'project_manager_email'=>$projectManagerData->email,
                                'project_manager_phones'=>$projectManagerData->phones,
                                'project_supervisor_id'=>$projectData->project_supervisor_id,
                                'project_supervisor_name'=>$projectSupervisorData->fname.' '.$projectSupervisorData->lname,
                                'project_supervisor_email'=>$projectSupervisorData->email,
                                'project_supervisor_phones'=>$projectSupervisorData->phones,
                                'added_by'=>$projectData->added_by,
                                'created_at'=>$projectData->created_at,
                                );
                
                // Send Email =========================================================
                $createdData = DB::table('users')->where('id', $projectData->added_by)->first();
                $createdBy = $createdData->fname.' '.$createdData->lname;

                //$workData = DB::table('work')->where('id', $projectData->work_id)->first();

                $projectManager = $projectManagerData->fname.' '.$projectManagerData->lname;
                $projectManagerEmail = $projectManagerData->email;

                $projectSupervisor = $projectSupervisorData->fname.' '.$projectSupervisorData->lname;
                $projectSupervisorEmail = $projectSupervisorData->email;

                $projectDesigner = $designerData->fname.' '.$designerData->lname;

                $projectCustomer = $customerData->fname.' '.$customerData->lname;

                $subject = 'New project has been created '.ucfirst($projectData->name);
                $to_projectManager = $projectManagerEmail;
                $to_projectSupervisor = $projectSupervisorEmail;

                $details = [
                        'to' => $to_projectManager,
                        'from' => env('MAIL_FROM_ADDRESS'),
                        'subject' => $subject,
                        'receiver' => $projectManager,
                        'sender' => env('MAIL_FROM_NAME'), 
                        'project_name' => ucfirst($projectData->name), 
                        'created_by' => $createdBy,
                        'start_date'=>date('d-M-Y', strtotime($projectData->start_date)),
                        'end_date'=>date('d-M-Y', strtotime($projectData->end_date)),
                        //'work'=>$workData->name,
                        'project_manager'=>$projectManager,
                        'project_supervisor'=>$projectSupervisor,
                        'project_designer'=>$projectDesigner,
                        'customer'=>$projectCustomer,
                        'location'=>$projectData->address
                    ];
                
                Mail::to($to_projectManager)->send(new ProjectCreation($details));

                $details_2 = [
                        'to' => $to_projectManager,
                        'from' => env('MAIL_FROM_ADDRESS'),
                        'subject' => $subject,
                        'receiver' => $projectManager,
                        'sender' => env('MAIL_FROM_NAME'), 
                        'project_name' => ucfirst($projectData->name), 
                        'created_by' => $createdBy,
                        'start_date'=>date('d-M-Y', strtotime($projectData->start_date)),
                        'end_date'=>date('d-M-Y', strtotime($projectData->end_date)),
                        //'work'=>$workData->name,
                        'project_manager'=>$projectManager,
                        'project_supervisor'=>$projectSupervisor,
                        'project_designer'=>$projectDesigner,
                        'customer'=>$projectCustomer,
                        'location'=>$projectData->address
                    ];

                Mail::to($to_projectSupervisor)->send(new ProjectCreation($details_2));
                

                return response([
                    'status'=>"success",
                    'Project_id'=>$projectId,
                    'message'=>'Project has been added successfully.',
                    'data'=>$newArr
                ]);

            }else{
                return response([
                            'status'=>"failure",
                            'message'=>'Please try again!'
                        ],200);
            }

            
                
            
        }

    }



    /**
     * Project edit
     */
    public function edit(Request $request){

        $role_type = $request->decode->role_type;
        $user_id = $request->decode->id;   

        if($user_id=='' && ($role_type!=1)){
            return response([
                'status'=>"failure",
                'message'=>'Please provide a valid token!'
            ],401);
        }

        $validator = Validator::make($request->all(), [
                            'name' => 'string',
                            'project_no' => 'string',
                            'contract_no' => 'string',
                            'start_date' => 'date_format:Y-m-d',
                            'end_date' => 'date_format:Y-m-d|after_or_equal:start_date',
                            'customer_id' => 'numeric',
                            'designer_id' => 'numeric',
                            'project_manager_id' => 'numeric', 
                            'project_supervisor_id' => 'numeric',
                            'address'=>'string',
                            'latitude'=>'numeric',
                            'longitude'=>'numeric'
                        ]);
 

        if ($validator->fails()) { 
            //return response($validator->errors(),200);
            return response()->json(['status' => "failure",'message' => $validator->messages()], 406);  
        }else{ 

            $projectData = $this->projectModel->where('id',$request->id)->first();  

            if($projectData){
                $updateData=[];

                $updateData['updated_at'] = date('Y-m-d H:i:s'); 
                
                if($request->has('name')){
                    $project = $this->projectModel->where(['name'=>$request->name])->get(); 
                    if(count($project)>0 && ucfirst($request->name) != $projectData->name){
                        return response([
                            'status'=>"failure",
                            'message'=>'Project name already exists!'
                        ],200);
                    }else{
                        $updateData['name'] = ucfirst($request->name);
                        $updateData['title'] = ucfirst($request->name); 
                    }
                }

                if($request->has('customer_project_no')){
                    $project = $this->projectModel->where(['project_no'=>$request->customer_project_no])->get();
                    if(count($project)>0 && $request->customer_project_no != $projectData->project_no){
                        return response([
                            'status'=>"failure",
                            'message'=>'Project number already exists!'
                        ],200);
                    }else{
                        $updateData['project_no'] = $request->customer_project_no; 
                    } 
                }

                if($request->has('customer_id')){
                    $customerExistCheck = $this->userModel->where(['id'=>$request->customer_id,'role_type'=>7,'status'=>'active'])->get(); 
                    if(count($customerExistCheck)==0){
                        return response([
                            'status'=>"failure",
                            'message'=>'Customer does not exists!'
                        ],200);
                    }else{
                        $updateData['customer_id'] = $request->customer_id; 
                    }
                }

                if($request->has('designer_id')){
                    $designerExistCheck = $this->userModel->where(['id'=>$request->designer_id,'role_type'=>8,'status'=>'active'])->get(); 
                    if(count($designerExistCheck)==0){
                        return response([
                            'status'=>"failure",
                            'message'=>'Designer does not exists!'
                        ],200);
                    }else{
                        $updateData['designer_id'] = $request->designer_id; 
                    }
                }

                if($request->has('project_manager_id')){
                    $projectManagerExistCheck = $this->userModel->where(['id'=>$request->project_manager_id,'role_type'=>2,'status'=>'active'])->get(); 
                    if(count($projectManagerExistCheck)==0){
                        return response([
                            'status'=>"failure",
                            'message'=>'Project manager does not exists!'
                        ],200);
                    }else{
                        $updateData['project_manager_id'] = $request->project_manager_id; 
                    }
                }


                if($request->has('project_supervisor_id')){
                    $projectSupervisorExistCheck = $this->userModel->where(['id'=>$request->project_supervisor_id,'role_type'=>3,'status'=>'active'])->get(); 
                    if(count($projectManagerExistCheck)==0){
                        return response([
                            'status'=>"failure",
                            'message'=>'Project supervisor does not exists!'
                        ],200);
                    }else{
                        $updateData['project_supervisor_id'] = $request->project_supervisor_id; 
                    }
                }



                if($request->has('start_date')){
                    $updateData['start_date'] = $request->start_date; 
                    $updateData['start'] = date("Y-m-d H:i:s", strtotime($request->start_date));
                }
                if($request->has('end_date')){
                    $updateData['end_date'] = $request->end_date; 
                    $updateData['end'] = date("Y-m-d H:i:s", strtotime($request->end_date));
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
                    $this->projectModel->where('id',$request->id)->update($updateData);

                    $updatedData = $this->projectModel->where('id',$request->id)->first();  
                    return response(['status'=>"success", 'message'=>'Project has been updated successfully.', 'data'=>$updatedData]);
                    
                }catch(Exception $e){
                    return response(['status'=>"failure", 'message'=>'Please try again!', 'error'=>$e],200);
                }

            }else{
                return response([
                                'status'=>"failure",
                                'message'=>'Project not found!'
                            ],200); 
            }
        }

    }






    public function detail(Request $request){

        $role_type = $request->decode->role_type;
        $user_id = $request->decode->id;   

        if($user_id=='' && ($role_type!=1)){
            return response([
                'status'=>"failure",
                'message'=>'Please provide a valid token!'
            ],401);
        }

        $projectData = $this->projectModel->where('id',$request->id)->first();  

        if($projectData){
            $customerData = $this->userModel->where('id',$projectData->customer_id)->first();
            $designerData = $this->userModel->where('id',$projectData->designer_id)->first();
            $projectManagerData = $this->userModel->where('id',$projectData->project_manager_id)->first();
            $projectSupervisorData = $this->userModel->where('id',$projectData->project_supervisor_id)->first();
            
            $newArr = array('id'=>$projectData->id,
                            //'work_id'=>$projectData->work_id,
                            'name'=>$projectData->name,
                            'project_no'=>$projectData->project_no,
                            'contract_no'=>$projectData->contract_no,
                            'start_date'=>$projectData->start_date,
                            'end_date'=>$projectData->end_date,
                            'address'=>$projectData->address,
                            'latitude'=>$projectData->latitude,
                            'longitude'=>$projectData->longitude,
                            'customer_id'=>$projectData->customer_id,
                            'customer_name'=>$customerData->fname.' '.$customerData->lname,
                            'customer_address'=>$customerData->address,
                            'customer_phones'=>$customerData->phones,
                            'customer_email'=>$customerData->email,
                            'designer_id'=>$projectData->designer_id,
                            'designer_name'=>$designerData->fname.' '.$designerData->lname,
                            'designer_email'=>$designerData->email,
                            'designer_phones'=>$designerData->phones,
                            'project_manager_id'=>$projectData->project_manager_id,
                            'project_manager_name'=>$projectManagerData->fname.' '.$projectManagerData->lname,
                            'project_manager_email'=>$projectManagerData->email,
                            'project_manager_phones'=>$projectManagerData->phones,
                            'project_supervisor_id'=>$projectData->project_supervisor_id,
                            'project_supervisor_name'=>$projectSupervisorData->fname.' '.$projectSupervisorData->lname,
                            'project_supervisor_email'=>$projectSupervisorData->email,
                            'project_supervisor_phones'=>$projectSupervisorData->phones,
                            'added_by'=>$projectData->added_by,
                            'created_at'=>$projectData->created_at,
                            );
            
            return response(['status'=>"success", 'message'=>'Project data found.', 'data'=>$newArr]);

        }else{
            return response([
                            'status'=>"failure",
                            'message'=>'Project not found!'
                        ],200); 
        }
        

    }




    
}

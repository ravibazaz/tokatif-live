<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Milestone;
use App\Models\MainTask;
use App\Models\Task;
use App\Models\SubTask;
use App\Models\TaskSubtaskComment;
use App\Models\Handover;
//use App\Models\Service;
use App\Models\User;
use Validator;
use Hash;
use DB;



/** 
 * @group Handover Management
 * 
 * This api for Handover management 
 */
class HandoverController extends Controller
{
    //protected $serviceModel;
    protected $projectModel;
    protected $milestoneModel;
    protected $mainTaskModel;
    protected $taskModel;
    protected $subTaskModel;
    protected $handoverModel;
    protected $taskSubtaskCommentModel;
    protected $userModel;

    public function __construct(){
        //$this->serviceModel = new Service;
        $this->projectModel = new Project;
        $this->milestoneModel = new Milestone;
        $this->mainTaskModel = new MainTask;
        $this->taskModel = new Task;
        $this->subTaskModel = new SubTask;
        $this->handoverModel = new Handover;
        $this->taskSubtaskCommentModel = new TaskSubtaskComment;
        $this->userModel = new User;
    }

    /**
     * Handover list 
     * 
     */
    public function list(Request $request){ 

        //return $request->decode;
        $role_type = $request->decode->role_type;
        $user_id = $request->decode->id;

        if($user_id!='' && ($role_type!='')){
        
            $search = $request->search;

            if($role_type==1){
                if($search==''){
                    $data = DB::table('task')
                                ->join('project','task.project_id', '=', 'project.id')
                                ->join('users','task.assigned_to', '=', 'users.id')
                                ->select('task.*','users.fname','users.lname','project.name AS project_name','project.customer_id','project.designer_id','project.project_manager_id','project.project_supervisor_id','project.project_no','project.contract_no','project.address')
                                ->where('task.deleted_at', '=', null)
                                ->where('task.status', '=', '4')
                                ->orderBy('task.id','desc')->get();
                }else{
                    $data = DB::table('task')
                                ->join('project','task.project_id', '=', 'project.id')
                                ->join('users','task.assigned_to', '=', 'users.id')
                                ->select('task.*','users.fname','users.lname','project.name AS project_name','project.customer_id','project.designer_id','project.project_manager_id','project.project_supervisor_id','project.project_no','project.contract_no','project.address')
                                ->where('task.deleted_at', '=', null)
                                ->where('task.status', '=', '4')
                                ->where('task.name', 'like', '%'.$request->search.'%')
                                ->orderBy('task.id','desc')->get();
                }
            
            }else{

                if($search==''){
                    $data = DB::table('task')
                                ->join('project','task.project_id', '=', 'project.id')
                                ->join('users','task.assigned_to', '=', 'users.id')
                                ->select('task.*','users.fname','users.lname','project.name AS project_name','project.customer_id','project.designer_id','project.project_manager_id','project.project_supervisor_id','project.project_no','project.contract_no','project.address')
                                ->where('task.deleted_at', '=', null)
                                ->where('task.status', '=', '4')
                                ->where('task.assigned_to', '=', $user_id)
                                ->orderBy('task.id','desc')->get();
                }else{
                    
                    $data = DB::table('task')
                                ->join('project','task.project_id', '=', 'project.id')
                                ->join('users','task.assigned_to', '=', 'users.id')
                                ->select('task.*','users.fname','users.lname','project.name AS project_name','project.customer_id','project.designer_id','project.project_manager_id','project.project_supervisor_id','project.project_no','project.contract_no','project.address')
                                ->where('task.deleted_at', '=', null)
                                ->where('task.status', '=', '4')
                                ->where('task.assigned_to', '=', $user_id)
                                ->where('task.name', 'like', '%'.$request->search.'%')
                                ->orderBy('task.id','desc')->get();
                }
            }

            
            if(count($data)>0){
                return response(['status'=>"success", 'message'=>'Task list found.', 'data'=>$data]);
            }else{
                return response(['status'=>"failure", 'message'=>'Task not found!', 'data'=>$data]);
            }

        }else{
            return response([
                'status'=>"failure",
                'message'=>'Please provide a valid token!'
            ],401);
        }
        
    }






    /**
     * Handover approve 
     * @bodyParam project_id int required Project Id
     * @bodyParam milestone_id int required Milestone Id
     */
    public function approve(Request $request){  
        
        //return $request->decode;

        $role_type = $request->decode->role_type;
        $user_id = $request->decode->id;   

        if($user_id=='' && ($role_type!=2 || $role_type!=3 || $role_type!=7)){
            return response([
                'status'=>"failure",
                'message'=>'Please provide a valid token!'
            ],401);
        }

        
        $validator = Validator::make($request->all(), [
                    'project_id' => 'required|numeric',
                    'milestone_id' => 'required|numeric',
                    'main_task_id' => 'required|numeric',
                    'task_id' => 'required|numeric',
                    'rating' => 'required|integer|min:1|max:5',
                    'comment'=>'required'
                ]);
        
        if ($validator->fails()) { 
            //return response($validator->errors(),200);
            return response()->json(['status' => "failure",'message' => $validator->messages()], 406);  
        }else{ 
            
            $data =(Object) $request->all();

            $projectExistCheck = $this->projectModel->where(['id'=>$data->project_id])->get(); 
            if(count($projectExistCheck)==0){
                return response([
                    'status'=>"failure",
                    'message'=>'Project does not exists!'
                ],200);
            }

            $milestoneExistCheck = $this->milestoneModel->where(['id'=>$data->milestone_id,'project_id'=>$data->project_id])->get(); 
            if(count($milestoneExistCheck)==0){
                return response([
                    'status'=>"failure",
                    'message'=>'Milestone does not exists!'
                ],200);
            }

            $mainTaskExistCheck = $this->mainTaskModel->where(['id'=>$data->main_task_id,'project_id'=>$data->project_id,'milestone_id'=>$data->milestone_id])->get(); 
            if(count($mainTaskExistCheck)==0){
                return response([
                    'status'=>"failure",
                    'message'=>'Maintask does not exists!'
                ],200);
            }

            $taskExistCheck = $this->taskModel->where(['id'=>$data->task_id,'project_id'=>$data->project_id,'milestone_id'=>$data->milestone_id,'main_task_id'=>$data->main_task_id])->get(); 
            if(count($taskExistCheck)==0){
                return response([
                    'status'=>"failure",
                    'message'=>'Task does not exists!'
                ],200);
            }else{

                $taskStatus = $taskExistCheck[0]->status;
                $assigned_to = $taskExistCheck[0]->assigned_to;
                $taskName = $taskExistCheck[0]->name;

                $projectData = $this->projectModel->where(['id'=>$request->project_id])->first();
                $project_manager_id = $projectData->project_manager_id;
                $project_supervisor_id = $projectData->project_supervisor_id;

                if($taskStatus=='1' || $taskStatus=='2' || $taskStatus=='3'){
                    return response([
                                'status'=>"failure",
                                'message'=>'Task not yet completed!'
                            ]);
                }

                if($taskStatus=='6'){
                    return response([
                                'status'=>"failure",
                                'message'=>'Task already handed over!'
                            ]);
                }
            }

            $customer_id = 0;
            if($role_type==7){
                $customer_id = $request->decode->id;
            }

            $insertData=[
                            'type'=>'1',
                            'project_id'=>$request->project_id,
                            'milestone_id'=>$request->milestone_id,
                            'main_task_id'=>$request->main_task_id,
                            'task_id'=>$request->task_id,
                            'approved_by'=>$request->decode->id,
                            'customer_id'=>$request->decode->id,
                            'date'=>date('Y-m-d H:i:s'),
                            'comment'=>ucfirst($request->comment),
                            'work_quality_rating'=>$request->rating,
                            'added_by'=>$request->decode->id,
                            'created_at'=>date('Y-m-d H:i:s')
                        ];

            $handoverId = $this->handoverModel->insertGetId($insertData);

            if($handoverId!=''){
                $updateData=[];

                $updateData['updated_at'] = date('Y-m-d H:i:s'); 
                $updateData['status'] = '6'; 

                $this->taskModel->where('id',$request->task_id)->update($updateData);
                

                $activity = "Handover has been approved for task : ".ucfirst($taskName);
                $added_by = $request->decode->id;
                $assigned_to = $assigned_to;
                $project_id = $request->project_id;
                $milestone_id = $request->milestone_id;
                $main_task_id = $request->main_task_id;
                $task_id = $request->task_id;
                $sub_task_id = null;

                $activityId = addActivity($activity,$added_by,$assigned_to,$project_id,$milestone_id,$main_task_id,$task_id,$sub_task_id);


                $assigned_to_1 = $project_manager_id;
                $activityId_1 = addActivity($activity,$added_by,$assigned_to_1,$project_id,$milestone_id,$main_task_id,$task_id,$sub_task_id);

                $assigned_to_2 = $project_supervisor_id;
                $activityId_2 = addActivity($activity,$added_by,$assigned_to_2,$project_id,$milestone_id,$main_task_id,$task_id,$sub_task_id);


                return response([
                            'status'=>"success",
                            'handover_id'=>$handoverId,
                            'message'=>'Handover has been approved successfully.'
                        ]);
            }else{
                return response(['status'=>"failure", 'message'=>'Please try again!']);
            }

            
                
            
        }

    }









    /**
     * Handover reject 
     * @bodyParam project_id int required Project Id
     * @bodyParam milestone_id int required Milestone Id
     */
    public function reject(Request $request){  
        
        //return $request->decode;

        $role_type = $request->decode->role_type;
        $user_id = $request->decode->id;   

        if($user_id=='' && ($role_type!=2 || $role_type!=3 || $role_type!=7)){
            return response([
                'status'=>"failure",
                'message'=>'Please provide a valid token!'
            ],401);
        }

        
        $validator = Validator::make($request->all(), [
                    'project_id' => 'required|numeric',
                    'milestone_id' => 'required|numeric',
                    'main_task_id' => 'required|numeric',
                    'task_id' => 'required|numeric',
                    'comment'=>'required'
                ]);
        
        if ($validator->fails()) { 
            //return response($validator->errors(),200);
            return response()->json(['status' => "failure",'message' => $validator->messages()], 406);  
        }else{ 
            
            $data =(Object) $request->all();

            $projectExistCheck = $this->projectModel->where(['id'=>$data->project_id])->get(); 
            if(count($projectExistCheck)==0){
                return response([
                    'status'=>"failure",
                    'message'=>'Project does not exists!'
                ],200);
            }

            $milestoneExistCheck = $this->milestoneModel->where(['id'=>$data->milestone_id,'project_id'=>$data->project_id])->get(); 
            if(count($milestoneExistCheck)==0){
                return response([
                    'status'=>"failure",
                    'message'=>'Milestone does not exists!'
                ],200);
            }

            $mainTaskExistCheck = $this->mainTaskModel->where(['id'=>$data->main_task_id,'project_id'=>$data->project_id,'milestone_id'=>$data->milestone_id])->get(); 
            if(count($mainTaskExistCheck)==0){
                return response([
                    'status'=>"failure",
                    'message'=>'Maintask does not exists!'
                ],200);
            }

            $taskExistCheck = $this->taskModel->where(['id'=>$data->task_id,'project_id'=>$data->project_id,'milestone_id'=>$data->milestone_id,'main_task_id'=>$data->main_task_id])->get(); 
            if(count($taskExistCheck)==0){
                return response([
                    'status'=>"failure",
                    'message'=>'Task does not exists!'
                ],200);
            }else{

                $taskStatus = $taskExistCheck[0]->status;
                $assigned_to = $taskExistCheck[0]->assigned_to;
                $taskName = $taskExistCheck[0]->name;

                $projectData = $this->projectModel->where(['id'=>$request->project_id])->first();
                $project_manager_id = $projectData->project_manager_id;
                $project_supervisor_id = $projectData->project_supervisor_id;

                if($taskStatus=='1' || $taskStatus=='2' || $taskStatus=='3'){
                    return response([
                                'status'=>"failure",
                                'message'=>'Task not yet completed!'
                            ]);
                }

                if($taskStatus=='6'){
                    return response([
                                'status'=>"failure",
                                'message'=>'Task already handed over!'
                            ]);
                }
            }

            $customer_id = 0;
            if($role_type==7){
                $customer_id = $request->decode->id;
            }

            $insertData=[
                            'type'=>'0',
                            'project_id'=>$request->project_id,
                            'milestone_id'=>$request->milestone_id,
                            'main_task_id'=>$request->main_task_id,
                            'task_id'=>$request->task_id,
                            'approved_by'=>$request->decode->id,
                            'customer_id'=>$request->decode->id,
                            'date'=>date('Y-m-d H:i:s'),
                            'comment'=>ucfirst($request->comment),
                            'added_by'=>$request->decode->id,
                            'created_at'=>date('Y-m-d H:i:s')
                        ];

            $handoverId = $this->handoverModel->insertGetId($insertData);

            if($handoverId!=''){
                $updateData=[];

                $updateData['updated_at'] = date('Y-m-d H:i:s'); 
                $updateData['type'] = 'service'; 
                $updateData['status'] = '2'; 

                $this->taskModel->where('id',$request->task_id)->update($updateData);


                // Create Service
                /*$insertServiceData=[
                                        'name'=>'Service required for: '.$taskName,
                                        'added_by'=>$request->decode->id,
                                        'project_id'=>$request->project_id,
                                        'milestone_id'=>$request->milestone_id,
                                        'main_task_id'=>$request->main_task_id,
                                        'task_id'=>$request->task_id,
                                        'created_at'=>date('Y-m-d H:i:s')
                                    ];

                $serviceId = $this->serviceModel->insertGetId($insertServiceData);*/
                

                // Create Notification
                $activity = "Handover has been rejected for task : ".ucfirst($taskName);
                $added_by = $request->decode->id;
                $assigned_to = $assigned_to;
                $project_id = $request->project_id;
                $milestone_id = $request->milestone_id;
                $main_task_id = $request->main_task_id;
                $task_id = $request->task_id;
                $sub_task_id = null;

                $activityId = addActivity($activity,$added_by,$assigned_to,$project_id,$milestone_id,$main_task_id,$task_id,$sub_task_id);


                $assigned_to_1 = $project_manager_id;
                $activityId_1 = addActivity($activity,$added_by,$assigned_to_1,$project_id,$milestone_id,$main_task_id,$task_id,$sub_task_id);

                $assigned_to_2 = $project_supervisor_id;
                $activityId_2 = addActivity($activity,$added_by,$assigned_to_2,$project_id,$milestone_id,$main_task_id,$task_id,$sub_task_id);


                return response([
                            'status'=>"success",
                            'handover_id'=>$handoverId,
                            'message'=>'Handover has been rejected.'
                        ]);
            }else{
                return response(['status'=>"failure", 'message'=>'Please try again!']);
            }

            
                
            
        }

    }








    public function completed_list(Request $request){ 

        //return $request->decode;
        $role_type = $request->decode->role_type;
        $user_id = $request->decode->id;

        if($user_id!='' && ($role_type!='')){
        
            $search = $request->search;

            if($role_type==1){
                if($search==''){
                    $data = DB::table('task')
                                ->join('project','task.project_id', '=', 'project.id')
                                ->join('users','task.assigned_to', '=', 'users.id')
                                ->select('task.*','users.fname','users.lname','project.name AS project_name','project.customer_id','project.designer_id','project.project_manager_id','project.project_supervisor_id','project.project_no','project.contract_no','project.address')
                                ->where('task.deleted_at', '=', null)
                                ->where('task.status', '=', '6')
                                ->orderBy('task.id','desc')->get();
                }else{
                    $data = DB::table('task')
                                ->join('project','task.project_id', '=', 'project.id')
                                ->join('users','task.assigned_to', '=', 'users.id')
                                ->select('task.*','users.fname','users.lname','project.name AS project_name','project.customer_id','project.designer_id','project.project_manager_id','project.project_supervisor_id','project.project_no','project.contract_no','project.address')
                                ->where('task.deleted_at', '=', null)
                                ->where('task.status', '=', '6')
                                ->where('task.name', 'like', '%'.$request->search.'%')
                                ->orderBy('task.id','desc')->get();
                }
            
            }else{

                if($search==''){
                    $data = DB::table('task')
                                ->join('project','task.project_id', '=', 'project.id')
                                ->join('users','task.assigned_to', '=', 'users.id')
                                ->select('task.*','users.fname','users.lname','project.name AS project_name','project.customer_id','project.designer_id','project.project_manager_id','project.project_supervisor_id','project.project_no','project.contract_no','project.address')
                                ->where('task.deleted_at', '=', null)
                                ->where('task.status', '=', '6')
                                ->where('task.assigned_to', '=', $user_id)
                                ->orderBy('task.id','desc')->get();
                }else{
                    
                    $data = DB::table('task')
                                ->join('project','task.project_id', '=', 'project.id')
                                ->join('users','task.assigned_to', '=', 'users.id')
                                ->select('task.*','users.fname','users.lname','project.name AS project_name','project.customer_id','project.designer_id','project.project_manager_id','project.project_supervisor_id','project.project_no','project.contract_no','project.address')
                                ->where('task.deleted_at', '=', null)
                                ->where('task.status', '=', '6')
                                ->where('task.assigned_to', '=', $user_id)
                                ->where('task.name', 'like', '%'.$request->search.'%')
                                ->orderBy('task.id','desc')->get();
                }
            }

            
            if(count($data)>0){
                return response(['status'=>"success", 'message'=>'Task list found.', 'data'=>$data]);
            }else{
                return response(['status'=>"failure", 'message'=>'Task not found!', 'data'=>$data]);
            }

        }else{
            return response([
                'status'=>"failure",
                'message'=>'Please provide a valid token!'
            ],401);
        }
        
    }












    
}

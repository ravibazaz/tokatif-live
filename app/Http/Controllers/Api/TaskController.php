<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Milestone;
use App\Models\MainTask;
use App\Models\Task;
use App\Models\TaskSubtaskComment;
use App\Models\Work;
use App\Models\User;
use Validator;
use Hash;
use DB;

use App\Mail\MaintaskCreation;
use Illuminate\Support\Facades\Mail;

/** 
 * @group Task Management
 * 
 * This api for Task management 
 */
class TaskController extends Controller
{
    protected $workModel;
    protected $projectModel;
    protected $milestoneModel;
    protected $mainTaskModel;
    protected $taskModel;
    protected $taskSubtaskCommentModel;
    protected $userModel;

    public function __construct(){
        $this->workModel = new Work;
        $this->projectModel = new Project;
        $this->milestoneModel = new Milestone;
        $this->mainTaskModel = new MainTask;
        $this->taskModel = new Task;
        $this->taskSubtaskCommentModel = new TaskSubtaskComment;
        $this->userModel = new User;
    }

    /**
     * Task list 
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
                                ->join('milestone','task.milestone_id', '=', 'milestone.id')
                                ->join('main_task','task.main_task_id', '=', 'main_task.id')
                                ->join('users','task.assigned_to', '=', 'users.id')
                                ->select('task.*','users.fname','users.lname','project.name AS project_name','milestone.name as milestone_name','main_task.name as main_task_name','project.customer_id','project.designer_id','project.project_manager_id','project.project_supervisor_id','project.project_no','project.contract_no','project.address')
                                ->where('task.deleted_at', '=', null)
                                ->where('task.type', '=', 'task')
                                ->orderBy('task.id','desc')->get();
                }else{
                    

                    $data = DB::table('task')
                                ->join('project','task.project_id', '=', 'project.id')
                                ->join('milestone','task.milestone_id', '=', 'milestone.id')
                                ->join('main_task','task.main_task_id', '=', 'main_task.id')
                                ->join('users','task.assigned_to', '=', 'users.id')
                                ->select('task.*','users.fname','users.lname','project.name AS project_name','milestone.name as milestone_name','main_task.name as main_task_name','project.customer_id','project.designer_id','project.project_manager_id','project.project_supervisor_id','project.project_no','project.contract_no','project.address')
                                ->where('task.deleted_at', '=', null)
                                ->where('task.name', 'like', '%'.$request->search.'%')
                                ->where('task.type', '=', 'task')
                                ->orderBy('task.id','desc')->get();
                }
            
            }else{

                if($search==''){

                    $data = DB::table('task')
                                ->join('project','task.project_id', '=', 'project.id')
                                ->join('milestone','task.milestone_id', '=', 'milestone.id')
                                ->join('main_task','task.main_task_id', '=', 'main_task.id')
                                ->join('users','task.assigned_to', '=', 'users.id')
                                ->select('task.*','users.fname','users.lname','project.name AS project_name','milestone.name as milestone_name','main_task.name as main_task_name','project.customer_id','project.designer_id','project.project_manager_id','project.project_supervisor_id','project.project_no','project.contract_no','project.address')
                                ->where('task.deleted_at', '=', null)
                                ->where('task.assigned_to', '=', $user_id)
                                ->where('task.type', '=', 'task')
                                ->orderBy('task.id','desc')->get();

                }else{
                    
                    $data = DB::table('task')
                                ->join('project','task.project_id', '=', 'project.id')
                                ->join('milestone','task.milestone_id', '=', 'milestone.id')
                                ->join('main_task','task.main_task_id', '=', 'main_task.id')
                                ->join('users','task.assigned_to', '=', 'users.id')
                                ->select('task.*','users.fname','users.lname','project.name AS project_name','milestone.name as milestone_name','main_task.name as main_task_name','project.customer_id','project.designer_id','project.project_manager_id','project.project_supervisor_id','project.project_no','project.contract_no','project.address')
                                ->where('task.deleted_at', '=', null)
                                ->where('task.name', 'like', '%'.$request->search.'%')
                                ->where('task.assigned_to', '=', $user_id)
                                ->where('task.type', '=', 'task')
                                ->orderBy('task.id','desc')->get();
                }
            }

            
            
            if(count($data)>0){
                $newArr = array();
                foreach ($data as $key => $value) {
                    $addedBy = $value->added_by;
                    $added = $this->userModel->where(['id'=>$addedBy])->first();
                    $addedByName = $added->fname.' '.$added->lname;

                    if($value->status=='1'){
                        $status = 'New';
                    }elseif($value->status=='2'){
                        $status = 'Open';
                    }elseif($value->status=='3'){
                        $status = 'In Progress';
                    }elseif($value->status=='4'){
                        $status = 'Completed';
                    }elseif($value->status=='5'){
                        $status = 'On Hold';
                    }elseif($value->status=='6'){
                        $status = 'Handover';
                    }

                    $newArr[] = array( 
                                        "id" => $value->id,
                                        "project_id" => $value->project_id, 
                                        "milestone_id" => $value->milestone_id, 
                                        "main_task_id" => $value->main_task_id,  
                                        "name" => $value->name, 
                                        "task_no" => $value->task_no, 
                                        "quantity" => $value->quantity, 
                                        "assigned_to" => $value->assigned_to, 
                                        "approved_by" => $value->approved_by, 
                                        "helpers" => $value->helpers, 
                                        "start_date" => $value->start_date, 
                                        "end_date" => $value->end_date,  
                                        "description" => $value->description, 
                                        "added_by" => $addedByName, 
                                        "status" => $status, 
                                        "created_at" => $value->created_at,    
                                        "assigned_to" => $value->fname.' '.$value->lname, 
                                        "project_name" => $value->project_name, 
                                        "milestone_name" => $value->milestone_name,     
                                        "main_task_name" => $value->main_task_name, 
                                        "project_no" => $value->project_no,
                                        "contract_no" => $value->contract_no,               
                                        "address" => $value->address,
                                    );
                }

                return response(['status'=>"success", 'message'=>'Task list found.', 'data'=>$newArr]);
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








    public function maintaskwise_list(Request $request){ 

        //return $request->decode;
        $role_type = $request->decode->role_type;
        $user_id = $request->decode->id;

        if($user_id!='' && ($role_type!='')){
            
            if($request->projectId!='' && $request->milestoneId!='' && $request->maintaskId!=''){

                $search = $request->search;

                if($role_type==1){
                    if($search==''){
                        $data = DB::table('task')
                                ->join('project','task.project_id', '=', 'project.id')
                                ->join('milestone','task.milestone_id', '=', 'milestone.id')
                                ->join('main_task','task.main_task_id', '=', 'main_task.id')
                                ->join('users','task.assigned_to', '=', 'users.id')
                                ->select('task.*','users.fname','users.lname','project.name AS project_name','milestone.name as milestone_name','main_task.name as main_task_name','project.customer_id','project.designer_id','project.project_manager_id','project.project_supervisor_id','project.project_no','project.contract_no','project.address')
                                ->where('task.deleted_at', '=', null)
                                ->where('task.project_id', '=', $request->projectId)
                                ->where('task.milestone_id', '=', $request->milestoneId)
                                ->where('task.main_task_id', '=', $request->maintaskId)
                                ->where('task.type', '=', 'task')
                                ->orderBy('task.id','desc')->get();

                    }else{
                        $data = DB::table('task')
                                ->join('project','task.project_id', '=', 'project.id')
                                ->join('milestone','task.milestone_id', '=', 'milestone.id')
                                ->join('main_task','task.main_task_id', '=', 'main_task.id')
                                ->join('users','task.assigned_to', '=', 'users.id')
                                ->select('task.*','users.fname','users.lname','project.name AS project_name','milestone.name as milestone_name','main_task.name as main_task_name','project.customer_id','project.designer_id','project.project_manager_id','project.project_supervisor_id','project.project_no','project.contract_no','project.address')
                                ->where('task.deleted_at', '=', null)
                                ->where('task.project_id', '=', $request->projectId)
                                ->where('task.milestone_id', '=', $request->milestoneId)
                                ->where('task.main_task_id', '=', $request->maintaskId)
                                ->where('task.name', 'like', '%'.$request->search.'%')
                                ->where('task.type', '=', 'task')
                                ->orderBy('task.id','desc')->get();
                    }
                
                }else{

                    if($search==''){
                        $data = DB::table('task')
                                ->join('project','task.project_id', '=', 'project.id')
                                ->join('milestone','task.milestone_id', '=', 'milestone.id')
                                ->join('main_task','task.main_task_id', '=', 'main_task.id')
                                ->join('users','task.assigned_to', '=', 'users.id')
                                ->select('task.*','users.fname','users.lname','project.name AS project_name','milestone.name as milestone_name','main_task.name as main_task_name','project.customer_id','project.designer_id','project.project_manager_id','project.project_supervisor_id','project.project_no','project.contract_no','project.address')
                                ->where('task.deleted_at', '=', null)
                                ->where('task.assigned_to', '=', $user_id)
                                ->where('task.project_id', '=', $request->projectId)
                                ->where('task.milestone_id', '=', $request->milestoneId)
                                ->where('task.main_task_id', '=', $request->maintaskId)
                                ->where('task.type', '=', 'task')
                                ->orderBy('task.id','desc')->get();

                    }else{
                        
                        $data = DB::table('task')
                                ->join('project','task.project_id', '=', 'project.id')
                                ->join('milestone','task.milestone_id', '=', 'milestone.id')
                                ->join('main_task','task.main_task_id', '=', 'main_task.id')
                                ->join('users','task.assigned_to', '=', 'users.id')
                                ->select('task.*','users.fname','users.lname','project.name AS project_name','milestone.name as milestone_name','main_task.name as main_task_name','project.customer_id','project.designer_id','project.project_manager_id','project.project_supervisor_id','project.project_no','project.contract_no','project.address')
                                ->where('task.deleted_at', '=', null)
                                ->where('task.name', 'like', '%'.$request->search.'%')
                                ->where('task.assigned_to', '=', $user_id)
                                ->where('task.project_id', '=', $request->projectId)
                                ->where('task.milestone_id', '=', $request->milestoneId)
                                ->where('task.main_task_id', '=', $request->maintaskId)
                                ->where('task.type', '=', 'task')
                                ->orderBy('task.id','desc')->get();
                    }
                }



                if(count($data)>0){

                    $newArr = array();
                    foreach ($data as $key => $value) {
                        $addedBy = $value->added_by;
                        $added = $this->userModel->where(['id'=>$addedBy])->first();
                        $addedByName = $added->fname.' '.$added->lname;

                        if($value->status=='1'){
                            $status = 'New';
                        }elseif($value->status=='2'){
                            $status = 'Open';
                        }elseif($value->status=='3'){
                            $status = 'In Progress';
                        }elseif($value->status=='4'){
                            $status = 'Completed';
                        }elseif($value->status=='5'){
                            $status = 'On Hold';
                        }elseif($value->status=='6'){
                            $status = 'Handover';
                        }

                        $newArr[] = array( 
                                            "id" => $value->id,
                                            "project_id" => $value->project_id, 
                                            "milestone_id" => $value->milestone_id, 
                                            "main_task_id" => $value->main_task_id,  
                                            "name" => $value->name, 
                                            "task_no" => $value->task_no, 
                                            "quantity" => $value->quantity, 
                                            "assigned_to" => $value->assigned_to, 
                                            "approved_by" => $value->approved_by, 
                                            "helpers" => $value->helpers, 
                                            "start_date" => $value->start_date, 
                                            "end_date" => $value->end_date,  
                                            "description" => $value->description, 
                                            "added_by" => $addedByName, 
                                            "status" => $status, 
                                            "created_at" => $value->created_at,    
                                            "assigned_to" => $value->fname.' '.$value->lname, 
                                            "project_name" => $value->project_name, 
                                            "milestone_name" => $value->milestone_name,     
                                            "main_task_name" => $value->main_task_name, 
                                            "project_no" => $value->project_no,
                                            "contract_no" => $value->contract_no,               
                                            "address" => $value->address,
                                        );
                    }

                    return response(['status'=>"success", 'message'=>'Task list found.', 'data'=>$newArr]);
                }else{
                    return response(['status'=>"failure", 'message'=>'Task not found!', 'data'=>$data]);
                }


            }else{
                return response([
                            'status'=>"failure",
                            'message'=>'Please provide a valid url!'
                        ]);
            }
            
            

        }else{
            return response([
                'status'=>"failure",
                'message'=>'Please provide a valid token!'
            ],401);
        }
        
    }







    /**
     * Task add 
     * @bodyParam project_id int required Project Id
     * @bodyParam milestone_id int required Milestone Id
     * @bodyParam name string required Milestone name  
     * @bodyParam assigned_to numeric required Assigned to
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

        if(count(array_filter($request->helpers)) == 0) {
            $validator = Validator::make($request->all(), [
                        'name' => 'string',
                        'work_id' => 'required|numeric',
                        'project_id' => 'required|numeric',
                        'milestone_id' => 'required|numeric',
                        'main_task_id' => 'required|numeric',
                        'quantity' => 'required|numeric',
                        'assigned_to' => 'required|numeric',
                        'start_date' => 'required|date_format:Y-m-d',
                        'end_date' => 'required|date_format:Y-m-d|after_or_equal:start_date',
                        'description'=>'required'
                    ]);
        }else{
            $validator = Validator::make($request->all(), [
                        'name' => 'string',
                        'work_id' => 'required|numeric',
                        'project_id' => 'required|numeric',
                        'milestone_id' => 'required|numeric',
                        'main_task_id' => 'required|numeric',
                        'quantity' => 'required|numeric',
                        'assigned_to' => 'required|numeric',
                        'start_date' => 'required|date_format:Y-m-d',
                        'end_date' => 'required|date_format:Y-m-d|after_or_equal:start_date',
                        'helpers' => 'array|min:0',
                        'helpers.*' => 'numeric|distinct',
                        'description'=>'required'
                    ]);
        }

        if ($validator->fails()) { 
            //return response($validator->errors(),200);
            return response()->json(['status' => "failure",'message' => $validator->messages()], 406);  
        }else{ 
            
            $data =(Object) $request->all();

            /*$TaskName = $this->taskModel->where(['name'=>$data->name])->get();
            if(count($TaskName)>0){
                return response([
                    'status'=>"failure",
                    'message'=>'Task name already exists!'
                ],200);
            }*/

            $TaskNameExistCheck = $this->workModel->where('deleted_at', '=', null)
                                                        ->where('category','=','task')
                                                        ->where('name','=',$data->name)
                                                        ->orderBy('name','asc')->get();

            if(count($TaskNameExistCheck)==0){
                return response([
                    'status'=>"failure",
                    'message'=>'Task name does not exists!'
                ],200);
            }


            $workExistCheck = $this->workModel->where(['id'=>$data->work_id])->get(); 
            if(count($workExistCheck)==0){
                return response([
                    'status'=>"failure",
                    'message'=>'Work does not exists!'
                ],200);
            }

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

            $assignedToExistCheck = $this->userModel->where(['id'=>$data->assigned_to,'status'=>'active'])->get(); 
            if(count($assignedToExistCheck)==0){
                return response([
                    'status'=>"failure",
                    'message'=>'Assigned to does not exists!'
                ],200);
            }


            $projectData = $this->projectModel->where(['id'=>$request->project_id])->first();
            $startDate = $projectData->start_date;
            $endDate = $projectData->end_date;

            if (($request->start_date >= $startDate) && ($request->start_date <= $endDate)){   
                $start_date = $request->start_date;
            }else{ 
                return response([
                    'status'=>"failure",
                    'message'=>'Please select start date between '.$startDate.' & '.$endDate
                ],200); 
            }

            if (($request->end_date >= $startDate) && ($request->end_date <= $endDate)){   
                $end_date = $request->end_date;
            }else{ 
                return response([
                    'status'=>"failure",
                    'message'=>'Please select end date between '.$startDate.' & '.$endDate
                ],200);  
            } 



            $lastRow = DB::table('task')->latest('id')->first();
            if($lastRow){
                $newID = $lastRow->id + 1;
                $task_no = 'FFD00 '.$request->project_id.' / '.$request->milestone_id.' / '.$request->main_task_id.' / '.$newID; 
            }else{
                $task_no = 'FFD00 '.$request->project_id.' / '.$request->milestone_id.' / '.$request->main_task_id.' / 1';
            }


            

            if($request->helpers == "[null]") {
                $h = [null];
                $helpers = json_encode($h); 
            }else{
                $helpers = json_encode($request->helpers);
            }

            $insertData=[
                            'type'=>'task',
                            'project_id'=>$request->project_id,
                            'work_id'=>$request->work_id,
                            'milestone_id'=>$request->milestone_id,
                            'main_task_id'=>$request->main_task_id,
                            'name'=>ucfirst($request->name),
                            'task_no'=>$task_no,
                            'quantity'=>$request->quantity,
                            'assigned_to'=>$request->assigned_to,
                            'approved_by'=>$request->decode->id,
                            'start_date'=>$start_date,
                            'end_date'=>$end_date,
                            'helpers'=>$helpers,
                            'description'=>ucfirst($request->description),
                            'added_by'=>$request->decode->id,
                            'created_at'=>date('Y-m-d H:i:s')
                        ];

            $taskId = $this->taskModel->insertGetId($insertData);

            if($taskId!=''){
                $activity = "New task created: ".ucfirst($request->name);
                $added_by = $request->decode->id;
                $assigned_to = $request->assigned_to;
                $project_id = $request->project_id;
                $milestone_id = $request->milestone_id;
                $main_task_id = $request->main_task_id;
                $task_id = $taskId;
                $sub_task_id = NULL;

                $activityId = addActivity($activity,$added_by,$assigned_to,$project_id,$milestone_id,$main_task_id,$task_id,$sub_task_id);

                if(count($request->helpers)>0){
                    $helperArr = array();
                    foreach ($request->helpers as $helper) {
                        $helperArr[] = $helper;

                        addActivity($activity,$added_by,$helper,$project_id,$milestone_id,$main_task_id,$task_id,$sub_task_id);
                    }
                    //return $helperArr;
                }


                // Send Email =========================================================
                $createdData = DB::table('users')->where('id', $request->decode->id)->first();
                $createdBy = $createdData->fname.' '.$createdData->lname;

                $assignedToData = DB::table('users')->where('id', $request->assigned_to)->first();
                $assignedTo = $assignedToData->fname.' '.$assignedToData->lname;
                $assignedToEmail = $assignedToData->email;

                $projectData = DB::table('project')->where('id', $request->project_id)->first();
                $projectName = $projectData->name;

                $subject = 'New task has been created '.ucfirst($request->name).' for project: '.$projectName;
                $to = $assignedToEmail;

                $details = [
                        'to' => $to,
                        'from' => env('MAIL_FROM_ADDRESS'),
                        'subject' => $subject,
                        'receiver' => $assignedTo,
                        'sender' => env('MAIL_FROM_NAME'), 
                        'project_name' => ucfirst($projectName), 
                        'task_name' => ucfirst($request->name), 
                        'created_by' => $createdBy,
                        'start_date'=>date('d-M-Y', strtotime($start_date)),
                        'end_date'=>date('d-M-Y', strtotime($end_date)),
                        'assigned_to'=>$assignedTo,
                        'description'=>$request->description
                    ];

                Mail::to($to)->send(new MaintaskCreation($details));

            }

            return response([
                'status'=>"success",
                'task_id'=>$taskId,
                'message'=>'Task has been added successfully.'
            ]);
                
            
        }

    }



    /**
     * Task edit
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

        if(count(array_filter($request->helpers)) == 0) {
            $validator = Validator::make($request->all(), [
                        'name' => 'string',
                        'work_id' => 'required|numeric',
                        'project_id' => 'required|numeric',
                        'milestone_id' => 'required|numeric',
                        'main_task_id' => 'required|numeric',
                        'quantity' => 'required|numeric',
                        'assigned_to' => 'required|numeric',
                        'start_date' => 'required|date_format:Y-m-d',
                        'end_date' => 'required|date_format:Y-m-d|after_or_equal:start_date',
                        'description'=>'required'
                    ]);
        }else{
            $validator = Validator::make($request->all(), [
                        'name' => 'string',
                        'work_id' => 'required|numeric',
                        'project_id' => 'required|numeric',
                        'milestone_id' => 'required|numeric',
                        'main_task_id' => 'required|numeric',
                        'quantity' => 'required|numeric',
                        'assigned_to' => 'required|numeric',
                        'start_date' => 'required|date_format:Y-m-d',
                        'end_date' => 'required|date_format:Y-m-d|after_or_equal:start_date',
                        'helpers' => 'array|min:0',
                        'helpers.*' => 'numeric|distinct',
                        'description'=>'required'
                    ]);
        }
 

        if ($validator->fails()) { 
            //return response($validator->errors(),200);
            return response()->json(['status' => "failure",'message' => $validator->messages()], 406);  
        }else{ 

            $TaskData = $this->taskModel->where('id',$request->id)->first();  

            if($TaskData){

                $workExistCheck = $this->workModel->where(['id'=>$request->work_id])->get(); 
                if(count($workExistCheck)==0){
                    return response([
                        'status'=>"failure",
                        'message'=>'Work does not exists!'
                    ],200);
                }

                $projectExistCheck = $this->projectModel->where(['id'=>$request->project_id])->get(); 
                if(count($projectExistCheck)==0){
                    return response([
                        'status'=>"failure",
                        'message'=>'Project does not exists!'
                    ],200);
                }

                $milestoneExistCheck = $this->milestoneModel->where(['id'=>$request->milestone_id,'project_id'=>$request->project_id])->get(); 
                if(count($milestoneExistCheck)==0){
                    return response([
                        'status'=>"failure",
                        'message'=>'Milestone does not exists!'
                    ],200);
                }

                $mainTaskExistCheck = $this->mainTaskModel->where(['id'=>$request->main_task_id,'project_id'=>$request->project_id,'milestone_id'=>$request->milestone_id])->get(); 
                if(count($mainTaskExistCheck)==0){
                    return response([
                        'status'=>"failure",
                        'message'=>'Maintask does not exists!'
                    ],200);
                }

                $assignedToExistCheck = $this->userModel->where(['id'=>$request->assigned_to,'status'=>'active'])->get(); 
                if(count($assignedToExistCheck)==0){
                    return response([
                        'status'=>"failure",
                        'message'=>'Assigned to does not exists!'
                    ],200);
                }



                $projectData = $this->projectModel->where(['id'=>$TaskData->project_id])->first();
                $startDate = $projectData->start_date;
                $endDate = $projectData->end_date;

                if (($request->start_date >= $startDate) && ($request->start_date <= $endDate)){   
                    $start_date = $request->start_date;
                }else{ 
                    return response([
                        'status'=>"failure",
                        'message'=>'Please select start date between '.$startDate.' & '.$endDate
                    ],200); 
                }

                if (($request->end_date >= $startDate) && ($request->end_date <= $endDate)){   
                    $end_date = $request->end_date;
                }else{ 
                    return response([
                        'status'=>"failure",
                        'message'=>'Please select end date between '.$startDate.' & '.$endDate
                    ],200);  
                } 




                $updateData=[];

                $updateData['updated_at'] = date('Y-m-d H:i:s'); 
                
                if($request->has('name')){

                    $TaskNameExistCheck = $this->workModel->where('deleted_at', '=', null)
                                                        ->where('category','=','task')
                                                        ->where('name','=',$request->name)
                                                        ->orderBy('name','asc')->get();

                    if(count($TaskNameExistCheck)==0){
                        return response([
                            'status'=>"failure",
                            'message'=>'Task name does not exists!'
                        ],200);
                    }else{
                        $updateData['name'] = ucfirst($request->name);
                    }

                    /*$task = $this->taskModel->where(['name'=>$request->name])->get(); 
                    if(count($task)>0 && ucfirst($request->name) != $TaskData->name){
                        return response([
                            'status'=>"failure",
                            'message'=>'Task name already exists!'
                        ],200);
                    }else{
                        $updateData['name'] = ucfirst($request->name);
                    }*/
                }


                /*if($request->has('task_no')){
                    $updateData['task_no'] = $request->task_no; 
                }*/
                if($request->has('quantity')){
                    $updateData['quantity'] = $request->quantity; 
                }
                if($request->has('work_id')){
                    $updateData['work_id'] = $request->work_id; 
                }
                if($request->has('project_id')){
                    $updateData['project_id'] = $request->project_id; 
                }
                if($request->has('milestone_id')){
                    $updateData['milestone_id'] = $request->milestone_id; 
                }
                if($request->has('main_task_id')){
                    $updateData['main_task_id'] = $request->main_task_id; 
                }
                if($request->has('assigned_to')){
                    $updateData['assigned_to'] = $request->assigned_to; 
                }
                if($request->has('description')){
                    $updateData['description'] = $request->description; 
                }
                if($request->has('start_date')){
                    $updateData['start_date'] = $start_date; 
                }
                if($request->has('end_date')){
                    $updateData['end_date'] = $end_date; 
                }
                if($request->has('helpers')){
                    $updateData['helpers'] = json_encode($request->helpers); 
                }
                
            
                
                try{
                    $this->taskModel->where('id',$request->id)->update($updateData);

                    $updatedData = $this->taskModel->where('id',$request->id)->first();  
                    return response(['status'=>"success", 'message'=>'Task has been updated successfully.', 'data'=>$updatedData]);
                    
                }catch(Exception $e){
                    return response(['status'=>"failure", 'message'=>'Please try again!', 'error'=>$e],200);
                }

            }else{
                return response([
                                'status'=>"failure",
                                'message'=>'Task not found!'
                            ],200); 
            }
        }

    }




    /**
     * Change Task Status
     */
    public function change_task_status(Request $request){

        $role_type = $request->decode->role_type;
        $user_id = $request->decode->id; 

        if($user_id=='' && $role_type!=''){
            return response([
                'status'=>"failure",
                'message'=>'Please provide a valid token!'
            ],401);
        }


        $TaskData = $this->taskModel->where('id',$request->id)->first();   
        $assigned_to = $TaskData->assigned_to;

        if($request->status!='' && $assigned_to!=$user_id){
            return response([
                'status'=>"failure",
                'message'=>'You are not authorized to update the task status!'
            ],401);
        }

        if($assigned_to==$user_id){
            $validator = Validator::make($request->all(), [
                        'status' => 'required|integer|between:1,5'
                    ]);
        }else{
            $validator = Validator::make($request->all(), [
                        'comment'=>'required|string|min:2'
                    ]);
        }
        

        if ($validator->fails()) { 
            //return response($validator->errors(),200);
            return response()->json(['status' => "failure",'message' => $validator->messages()], 406);  
        }else{ 

            if($TaskData){
                //return $TaskData;

                /*$existingTaskStatus = array("1", "2", "3", "4", "5");
                if (!in_array($request->status, $existingTaskStatus)) {
                    return response([
                        'status'=>"failure",
                        'message'=>'Task status does not exists!'
                    ],200);
                }*/


                
                $updateData=[];

                $updateData['updated_at'] = date('Y-m-d H:i:s'); 
                
                if($request->has('status')){
                    $updateData['status'] = $request->status; 
                }
                
                
                try{

                    if($request->status!=''){
                        $this->taskModel->where('id',$request->id)->update($updateData);
                    }else{
                        $request->status = NULL;
                    }
                    

                    $insertData=[
                                'project_id'=>$TaskData->project_id,
                                'milestone_id'=>$TaskData->milestone_id,
                                'main_task_id'=>$TaskData->main_task_id,
                                'task_id'=>$request->id,
                                'comment'=>ucfirst($request->comment),
                                'status'=>$request->status,
                                'added_by'=>$request->decode->id,
                                'created_at'=>date('Y-m-d H:i:s')
                            ];

                    $taskCommentId = $this->taskSubtaskCommentModel->insertGetId($insertData);

                    if($taskCommentId!=''){

                        $projectData = DB::table('project')->where('id', $TaskData->project_id)->first();
                        $projectName = $projectData->name;

                        if($request->status!=''){
                            if($request->status=='1'){
                                $status = 'New';
                            }elseif($request->status=='2'){
                                $status = 'Open';
                            }elseif($request->status=='3'){
                                $status = 'In Progress';
                            }elseif($request->status=='4'){
                                $status = 'Completed';
                            }elseif($request->status=='5'){
                                $status = 'On Hold';
                            }elseif($request->status=='6'){
                                $status = 'Handover';
                            }

                            $activity = "Task status has been changed to ".$status." for task: ".$TaskData->name;
                            $returnMsg = "Task status has been updated successfully.";
                        }else{
                            $activity = "Comment has been added to task: ".$TaskData->name;
                            $returnMsg = "Comment has been added successfully.";
                        }
                        
                        $added_by = $request->decode->id;
                        $assigned_to = $TaskData->assigned_to;
                        $project_id = $TaskData->project_id;
                        $milestone_id = $TaskData->milestone_id;
                        $main_task_id = $TaskData->main_task_id;
                        $task_id = $TaskData->id;
                        $sub_task_id = NULL;

                        $activityId = addActivity($activity,$added_by,$assigned_to,$project_id,$milestone_id,$main_task_id,$task_id,$sub_task_id);
                    }

                    $updatedData = $this->taskModel->where('id',$request->id)->first();  
                    return response(['status'=>"success", 'message'=>$returnMsg, 'data'=>$updatedData]);
                    
                }catch(Exception $e){
                    return response(['status'=>"failure", 'message'=>'Please try again!', 'error'=>$e],200);
                }

            }else{
                return response([
                                'status'=>"failure",
                                'message'=>'Task not found!'
                            ],200); 
            }
        }

    }




    public function show_comments(Request $request){ 

        //return $request->decode;
        $role_type = $request->decode->role_type;
        $user_id = $request->decode->id;

        if($user_id!='' && ($role_type!='')){
        
            $data = DB::table('task')
                            ->join('task_subtask_comments','task.id', '=', 'task_subtask_comments.task_id')
                            ->join('users','task_subtask_comments.added_by', '=', 'users.id')
                            ->select('task.name as task_name','users.fname','users.lname','task_subtask_comments.comment','task_subtask_comments.created_at')
                            ->where('task.deleted_at', '=', null)
                            ->where('task.id', '=', $request->id)
                            ->orderBy('task.id','desc')->get(); 

            
            if(count($data)>0){
                return response(['status'=>"success", 'message'=>'Comment list found.', 'data'=>$data]);
            }else{
                return response(['status'=>"failure", 'message'=>'Comment not found!', 'data'=>$data]);
            }

        }else{
            return response([
                'status'=>"failure",
                'message'=>'Please provide a valid token!'
            ],401);
        }
        
    }



    /**
     * ProductivityWise Task EndDate
     */
    public function getProductivityWiseTaskEndDate(Request $request){

        $role_type = $request->decode->role_type;
        $user_id = $request->decode->id; 

        if($user_id=='' && $role_type!=''){
            return response([
                'status'=>"failure",
                'message'=>'Please provide a valid token!'
            ],401);
        }

        $validator = Validator::make($request->all(), [
                        'work_id' => 'required|numeric',
                        'project_id' => 'required|numeric',
                        'assigned_to' => 'required|numeric',
                        'task_start_date' => 'required|date_format:Y-m-d'
                    ]);

        if ($validator->fails()) { 
            //return response($validator->errors(),200);
            return response()->json(['status' => "failure",'message' => $validator->messages()], 406);  
        }else{ 

            $project = DB::table("project")
                            ->select('end_date')
                            ->where("id",$request->project_id)
                            ->first();

            $end_date = $project->end_date;

            $userProductivity = DB::table("user_productivity")
                                ->select('qty')
                                ->where("work_id",$request->work_id)
                                ->where("user_id",$request->assigned_to)
                                ->first(); 

            if($userProductivity){
                $days = $userProductivity->qty;

                $taskEndDate = date('Y-m-d', strtotime($request->task_start_date. ' + '.$days.' days'));

                if($end_date >= $taskEndDate){
                    return response(['status'=>"success", 'message'=>'Task end date found.', 'data'=>$taskEndDate],200);
                }else{
                    return response([
                                'status'=>"failure",
                                'message'=>'According to the productivity level this technician will take more time to end the task which will exceed the project end date!'
                            ],200);
                }
            }else{
                return response([
                                'status'=>"failure",
                                'message'=>'Productivity level of this technician not found!'
                            ],200);
            }

            
        }

    }

    
}

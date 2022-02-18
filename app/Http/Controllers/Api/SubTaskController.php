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
use App\Models\Work;
use App\Models\User;
use Validator;
use Hash;
use DB;

use App\Mail\MaintaskCreation;
use Illuminate\Support\Facades\Mail;

/** 
 * @group Subtask Management
 * 
 * This api for Subtask management 
 */
class SubTaskController extends Controller
{
    protected $workModel;
    protected $projectModel;
    protected $milestoneModel;
    protected $mainTaskModel;
    protected $taskModel;
    protected $subTaskModel;
    protected $taskSubtaskCommentModel;
    protected $userModel;

    public function __construct(){
        $this->workModel = new Work;
        $this->projectModel = new Project;
        $this->milestoneModel = new Milestone;
        $this->mainTaskModel = new MainTask;
        $this->taskModel = new Task;
        $this->subTaskModel = new SubTask;
        $this->taskSubtaskCommentModel = new TaskSubtaskComment;
        $this->userModel = new User;
    }

    /**
     * Subtask list 
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
                    $data = $this->subTaskModel->where('deleted_at', '=', null)->get();
                }else{
                    $data = $this->subTaskModel->where('deleted_at', '=', null)
                                                ->where('name', 'like', '%'.$request->search.'%')
                                                ->get();
                }
            
            }else{

                if($search==''){
                    $data = $this->subTaskModel->where('deleted_at', '=', null)
                                                ->where('assigned_to', '=', $user_id)
                                                ->get();
                }else{
                    
                    $data = $this->subTaskModel->where('deleted_at', '=', null)
                                                ->where('assigned_to', '=', $user_id)
                                                ->where('name', 'like', '%'.$request->search.'%')
                                                ->get();
                }
            }


            
            if(count($data)>0){
                return response(['status'=>"success", 'message'=>'Subtask list found.', 'data'=>$data]);
            }else{
                return response(['status'=>"failure", 'message'=>'Subtask not found!', 'data'=>$data]);
            }

        }else{
            return response([
                'status'=>"failure",
                'message'=>'Please provide a valid token!'
            ],401);
        }
        
    }





    public function taskwise_list(Request $request){ 

        //return $request->decode;
        $role_type = $request->decode->role_type;
        $user_id = $request->decode->id;

        if($user_id!='' && ($role_type!='')){
            
            if($request->projectId!='' && $request->milestoneId!='' && $request->maintaskId!='' && $request->taskId!=''){

                $search = $request->search;

                if($role_type==1){
                    if($search==''){
                        $data = $this->subTaskModel->where('deleted_at', '=', null)
                                                    ->where('project_id', '=', $request->projectId)
                                                    ->where('milestone_id', '=', $request->milestoneId)
                                                    ->where('main_task_id', '=', $request->maintaskId)
                                                    ->where('task_id', '=', $request->taskId)
                                                    ->get();
                    }else{
                        $data = $this->subTaskModel->where('deleted_at', '=', null)
                                                    ->where('project_id', '=', $request->projectId)
                                                    ->where('milestone_id', '=', $request->milestoneId)
                                                    ->where('main_task_id', '=', $request->maintaskId)
                                                    ->where('task_id', '=', $request->taskId)
                                                    ->where('name', 'like', '%'.$request->search.'%')
                                                    ->get();
                    }
                
                }else{

                    if($search==''){
                        $data = $this->subTaskModel->where('deleted_at', '=', null)
                                                    ->where('project_id', '=', $request->projectId)
                                                    ->where('milestone_id', '=', $request->milestoneId)
                                                    ->where('main_task_id', '=', $request->maintaskId)
                                                    ->where('task_id', '=', $request->taskId)
                                                    ->where('assigned_to', '=', $user_id)
                                                    ->get();
                    }else{
                        
                        $data = $this->subTaskModel->where('deleted_at', '=', null)
                                                    ->where('project_id', '=', $request->projectId)
                                                    ->where('milestone_id', '=', $request->milestoneId)
                                                    ->where('main_task_id', '=', $request->maintaskId)
                                                    ->where('task_id', '=', $request->taskId)
                                                    ->where('assigned_to', '=', $user_id)
                                                    ->where('name', 'like', '%'.$request->search.'%')
                                                    ->get();
                    }
                }


                if(count($data)>0){
                    return response(['status'=>"success", 'message'=>'Subtask list found.', 'data'=>$data]);
                }else{
                    return response(['status'=>"failure", 'message'=>'Subtask not found!', 'data'=>$data]);
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
     * Subtask add 
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
                        'name' => 'required|string',
                        'project_id' => 'required|numeric',
                        'milestone_id' => 'required|numeric',
                        'main_task_id' => 'required|numeric',
                        'task_id' => 'required|numeric',
                        'assigned_to' => 'required|numeric',
                        'start_date' => 'required|date_format:Y-m-d',
                        'end_date' => 'required|date_format:Y-m-d|after_or_equal:start_date',
                        'description'=>'required'
                    ]);
        }else{
            $validator = Validator::make($request->all(), [
                        'name' => 'required|string',
                        'project_id' => 'required|numeric',
                        'milestone_id' => 'required|numeric',
                        'main_task_id' => 'required|numeric',
                        'task_id' => 'required|numeric',
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

            /*$subTaskName = $this->subTaskModel->where(['name'=>$data->name])->get();
            if(count($subTaskName)>0){
                return response([
                    'status'=>"failure",
                    'message'=>'Subtask name already exists!'
                ],200);
            }*/

            $subTaskNameExistCheck = $this->workModel->where('deleted_at', '=', null)
                                                        ->where('category','=','subtask')
                                                        ->where('name','=',$data->name)
                                                        ->orderBy('name','asc')->get();

            if(count($subTaskNameExistCheck)==0){
                return response([
                    'status'=>"failure",
                    'message'=>'Subtask name does not exists!'
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

            $taskExistCheck = $this->taskModel->where(['id'=>$data->task_id,'project_id'=>$data->project_id,'milestone_id'=>$data->milestone_id,'main_task_id'=>$data->main_task_id])->get(); 
            if(count($taskExistCheck)==0){
                return response([
                    'status'=>"failure",
                    'message'=>'Task does not exists!'
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

            

            if($request->helpers == "[null]") {
                $helpers = (array) null;
            }else{
                $helpers = json_encode($request->helpers);
            }

            $insertData=[
                            'project_id'=>$request->project_id,
                            'milestone_id'=>$request->milestone_id,
                            'main_task_id'=>$request->main_task_id,
                            'task_id'=>$request->task_id,
                            'name'=>ucfirst($request->name),
                            'assigned_to'=>$request->assigned_to,
                            'approved_by'=>$request->decode->id,
                            'start_date'=>$start_date,
                            'end_date'=>$end_date,
                            'helpers'=>$helpers,
                            'description'=>ucfirst($request->description),
                            'added_by'=>$request->decode->id,
                            'created_at'=>date('Y-m-d H:i:s')
                        ];

            $subTaskId = $this->subTaskModel->insertGetId($insertData);

            if($subTaskId!=''){
                $activity = "New subtask created: ".ucfirst($request->name);
                $added_by = $request->decode->id;
                $assigned_to = $request->assigned_to;
                $project_id = $request->project_id;
                $milestone_id = $request->milestone_id;
                $main_task_id = $request->main_task_id;
                $task_id = $request->task_id;
                $sub_task_id = $subTaskId;

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

                $subject = 'New subtask has been created '.ucfirst($request->name).' for project: '.$projectName;
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
                'sub_task_id'=>$subTaskId,
                'message'=>'Subtask has been added successfully.'
            ]);
                
            
        }

    }



    /**
     * Subtask edit
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
                        'name' => 'required|string',
                        'project_id' => 'required|numeric',
                        'milestone_id' => 'required|numeric',
                        'main_task_id' => 'required|numeric',
                        'task_id' => 'required|numeric',
                        'assigned_to' => 'required|numeric',
                        'start_date' => 'required|date_format:Y-m-d',
                        'end_date' => 'required|date_format:Y-m-d|after_or_equal:start_date',
                        'description'=>'required'
                    ]);
        }else{
            $validator = Validator::make($request->all(), [
                        'name' => 'required|string',
                        'project_id' => 'required|numeric',
                        'milestone_id' => 'required|numeric',
                        'main_task_id' => 'required|numeric',
                        'task_id' => 'required|numeric',
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

            $subsubTaskData = $this->subTaskModel->where('id',$request->id)->first();  

            if($subsubTaskData){

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

                $taskExistCheck = $this->taskModel->where(['id'=>$request->task_id,'project_id'=>$request->project_id,'milestone_id'=>$request->milestone_id,'main_task_id'=>$request->main_task_id])->get(); 
                if(count($taskExistCheck)==0){
                    return response([
                        'status'=>"failure",
                        'message'=>'Task does not exists!'
                    ],200);
                }

                $assignedToExistCheck = $this->userModel->where(['id'=>$request->assigned_to,'status'=>'active'])->get(); 
                if(count($assignedToExistCheck)==0){
                    return response([
                        'status'=>"failure",
                        'message'=>'Assigned to does not exists!'
                    ],200);
                }



                $projectData = $this->projectModel->where(['id'=>$subsubTaskData->project_id])->first();
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
                    $subTaskNameExistCheck = $this->workModel->where('deleted_at', '=', null)
                                                            ->where('category','=','subtask')
                                                            ->where('name','=',$request->name)
                                                            ->orderBy('name','asc')->get();

                    if(count($subTaskNameExistCheck)==0){
                        return response([
                            'status'=>"failure",
                            'message'=>'Subtask name does not exists!'
                        ],200);
                    }else{
                        $updateData['name'] = ucfirst($request->name);
                    }

                    
                    /*$subtask = $this->subTaskModel->where(['name'=>$request->name])->get(); 
                    if(count($subtask)>0 && ucfirst($request->name) != $subsubTaskData->name){
                        return response([
                            'status'=>"failure",
                            'message'=>'Subtask name already exists!'
                        ],200);
                    }else{
                        $updateData['name'] = ucfirst($request->name);
                    }*/
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
                if($request->has('task_id')){
                    $updateData['main_task_id'] = $request->task_id; 
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
                    $this->subTaskModel->where('id',$request->id)->update($updateData);

                    $updatedData = $this->subTaskModel->where('id',$request->id)->first();  
                    return response(['status'=>"success", 'message'=>'Subtask has been updated successfully.', 'data'=>$updatedData]);
                    
                }catch(Exception $e){
                    return response(['status'=>"failure", 'message'=>'Please try again!', 'error'=>$e],200);
                }

            }else{
                return response([
                                'status'=>"failure",
                                'message'=>'Subtask not found!'
                            ],200); 
            }
        }

    }






    /**
     * Add SubTask Comment
     */
    public function add_comment(Request $request){

        $role_type = $request->decode->role_type;
        $user_id = $request->decode->id;   

        if($user_id=='' && $role_type!=''){
            return response([
                'status'=>"failure",
                'message'=>'Please provide a valid token!'
            ],401);
        }

        $validator = Validator::make($request->all(), [
                        'comment'=>'required|string|min:2'
                    ]);
        

        if ($validator->fails()) { 
            //return response($validator->errors(),200);
            return response()->json(['status' => "failure",'message' => $validator->messages()], 406);  
        }else{ 

            $subTaskData = $this->subTaskModel->where('id',$request->id)->first();  

            if($subTaskData){                
                
                try{
                    
                    $insertData=[
                                'project_id'=>$subTaskData->project_id,
                                'milestone_id'=>$subTaskData->milestone_id,
                                'main_task_id'=>$subTaskData->main_task_id,
                                'task_id'=>$subTaskData->task_id,
                                'sub_task_id'=>$request->id,
                                'comment'=>ucfirst($request->comment),
                                'status'=>$request->status,
                                'added_by'=>$request->decode->id,
                                'created_at'=>date('Y-m-d H:i:s')
                            ];

                    $taskCommentId = $this->taskSubtaskCommentModel->insertGetId($insertData);

                    if($taskCommentId!=''){

                        $projectData = DB::table('project')->where('id', $subTaskData->project_id)->first();
                        $projectName = $projectData->name;

                        $activity = "Comment has been added to ".$subTaskData->name;
                        $added_by = $request->decode->id;
                        $assigned_to = $subTaskData->assigned_to;
                        $project_id = $subTaskData->project_id;
                        $milestone_id = $subTaskData->milestone_id;
                        $main_task_id = $subTaskData->main_task_id;
                        $task_id = $subTaskData->id;
                        $sub_task_id = NULL;

                        $activityId = addActivity($activity,$added_by,$assigned_to,$project_id,$milestone_id,$main_task_id,$task_id,$sub_task_id);
                    }

                    $allComments = $this->taskSubtaskCommentModel->where('project_id',$subTaskData->project_id)
                                                                ->where('milestone_id',$subTaskData->milestone_id)
                                                                ->where('main_task_id',$subTaskData->main_task_id)
                                                                ->where('task_id',$subTaskData->task_id)
                                                                ->where('sub_task_id',$request->id)
                                                                ->get();  
                    return response(['status'=>"success", 'message'=>'Comment has been added successfully.', 'data'=>$allComments]);
                    
                }catch(Exception $e){
                    return response(['status'=>"failure", 'message'=>'Please try again!', 'error'=>$e],200);
                }

            }else{
                return response([
                                'status'=>"failure",
                                'message'=>'Sub task not found!'
                            ],200); 
            }
        }

    }




    public function show_comments(Request $request){ 

        //return $request->decode;
        $role_type = $request->decode->role_type;
        $user_id = $request->decode->id;

        if($user_id!='' && ($role_type!='')){
        
            $data = DB::table('sub_task')
                            ->join('task_subtask_comments','sub_task.id', '=', 'task_subtask_comments.sub_task_id')
                            ->join('users','task_subtask_comments.added_by', '=', 'users.id')
                            ->select('sub_task.name as subtask_name','users.fname','users.lname','task_subtask_comments.comment','task_subtask_comments.created_at')
                            ->where('sub_task.deleted_at', '=', null)
                            ->where('sub_task.id', '=', $request->id)
                            ->orderBy('sub_task.id','desc')->get(); 

            
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









    
}

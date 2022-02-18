<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Milestone;
use App\Models\MainTask;
use App\Models\TaskSubtaskComment;
use App\Models\Work;
use App\Models\User;
use Validator;
use Hash;
use DB;

use App\Mail\MaintaskCreation;
use Illuminate\Support\Facades\Mail;


/** 
 * @group MainTask Management
 * 
 * This api for MainTask management 
 */
class MainTaskController extends Controller
{
    protected $workModel;
    protected $projectModel;
    protected $milestoneModel;
    protected $mainTaskModel;
    protected $userModel;
    protected $taskSubtaskCommentModel;

    public function __construct(){
        $this->workModel = new Work;
        $this->projectModel = new Project;
        $this->milestoneModel = new Milestone;
        $this->mainTaskModel = new MainTask;
        $this->userModel = new User;
        $this->taskSubtaskCommentModel = new TaskSubtaskComment;
    }

    /**
     * MainTask list 
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
                    $data = $this->mainTaskModel->where('deleted_at', '=', null)->get();
                }else{
                    $data = $this->mainTaskModel->where('deleted_at', '=', null)
                                            ->where('name', 'like', '%'.$request->search.'%')
                                            ->get();
                }
            
            }else{

                if($search==''){
                    $data = $this->mainTaskModel->where('deleted_at', '=', null)
                                                ->where('assigned_to', '=', $user_id)
                                                ->get();
                }else{
                    
                    $data = $this->mainTaskModel->where('deleted_at', '=', null)
                                                ->where('assigned_to', '=', $user_id)
                                                ->where('name', 'like', '%'.$request->search.'%')
                                                ->get();
                }
            }
            
            
            
            if(count($data)>0){
                return response(['status'=>"success", 'message'=>'MainTask list found.', 'data'=>$data]);
            }else{
                return response(['status'=>"failure", 'message'=>'MainTask not found!', 'data'=>$data]);
            }

        }else{
            return response([
                'status'=>"failure",
                'message'=>'Please provide a valid token!'
            ],401);
        }
        
    }




    public function milestonewise_list(Request $request){ 

        //return $request->decode;
        $role_type = $request->decode->role_type;
        $user_id = $request->decode->id;

        if($user_id!='' && ($role_type!='')){
            
            if($request->projectId!='' && $request->milestoneId!=''){

                $search = $request->search;

                if($role_type==1){
                    if($search==''){
                        $data = $this->mainTaskModel->where('deleted_at', '=', null)
                                                    ->where('project_id', '=', $request->projectId)
                                                    ->where('milestone_id', '=', $request->milestoneId)
                                                    ->get();
                    }else{
                        $data = $this->mainTaskModel->where('deleted_at', '=', null)
                                                ->where('project_id', '=', $request->projectId)
                                                ->where('milestone_id', '=', $request->milestoneId)
                                                ->where('name', 'like', '%'.$request->search.'%')
                                                ->get();
                    }
                
                }else{

                    if($search==''){
                        $data = $this->mainTaskModel->where('deleted_at', '=', null)
                                                    ->where('project_id', '=', $request->projectId)
                                                    ->where('milestone_id', '=', $request->milestoneId)
                                                    ->where('assigned_to', '=', $user_id)
                                                    ->get();
                    }else{
                        
                        $data = $this->mainTaskModel->where('deleted_at', '=', null)
                                                    ->where('project_id', '=', $request->projectId)
                                                    ->where('milestone_id', '=', $request->milestoneId)
                                                    ->where('assigned_to', '=', $user_id)
                                                    ->where('name', 'like', '%'.$request->search.'%')
                                                    ->get();
                    }
                }

                if(count($data)>0){
                    return response(['status'=>"success", 'message'=>'MainTask list found.', 'data'=>$data]);
                }else{
                    return response(['status'=>"failure", 'message'=>'MainTask not found!', 'data'=>$data]);
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
     * MainTask add 
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

        //if(count(array_filter($request->helpers)) == 0) {
        if($request->helpers == "[]") { 
            $validator = Validator::make($request->all(), [
                        'name' => 'required|string',
                        'project_id' => 'required|numeric',
                        'milestone_id' => 'required|numeric',
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

            /*$mainTaskName = $this->mainTaskModel->where(['name'=>$data->name])->get();
            if(count($mainTaskName)>0){
                return response([
                    'status'=>"failure",
                    'message'=>'MainTask name already exists!'
                ],200);
            }*/

            $mainTaskNameExistCheck = $this->workModel->where('deleted_at', '=', null)
                                                        ->where('category','=','maintask')
                                                        ->where('name','=',$data->name)
                                                        ->orderBy('name','asc')->get();

            if(count($mainTaskNameExistCheck)==0){
                return response([
                    'status'=>"failure",
                    'message'=>'MainTask name does not exists!'
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

            
            if($request->helpers == "[]") {
                $h = array();
                $helpers = json_encode($h); 
            }else{
                $helpers = json_encode($request->helpers);
            }

            $insertData=[
                            'project_id'=>$request->project_id,
                            'milestone_id'=>$request->milestone_id,
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

            $mainTaskId = $this->mainTaskModel->insertGetId($insertData);

            if($mainTaskId!=''){
                $activity = "New maintask created: ".ucfirst($request->name);
                $added_by = $request->decode->id;
                $assigned_to = $request->assigned_to;
                $project_id = $request->project_id;
                $milestone_id = $request->milestone_id;
                $main_task_id = $mainTaskId;
                $task_id = NULL;
                $sub_task_id = NULL;

                $activityId = addActivity($activity,$added_by,$assigned_to,$project_id,$milestone_id,$main_task_id,$task_id,$sub_task_id);

                if($request->helpers != "[]"){
                    if(count($request->helpers)>0){
                        $helperArr = array();
                        foreach ($request->helpers as $helper) {
                            $helperArr[] = $helper;

                            addActivity($activity,$added_by,$helper,$project_id,$milestone_id,$main_task_id,$task_id,$sub_task_id);
                        }
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

                $subject = 'New maintask has been created '.ucfirst($request->name).' for project: '.$projectName;
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
                'maintask_id'=>$mainTaskId,
                'message'=>'Maintask has been added successfully.'
            ]);
                
            
        }

    }



    /**
     * MainTask edit
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

            $mainTaskData = $this->mainTaskModel->where('id',$request->id)->first();  

            if($mainTaskData){

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

                $assignedToExistCheck = $this->userModel->where(['id'=>$request->assigned_to,'status'=>'active'])->get(); 
                if(count($assignedToExistCheck)==0){
                    return response([
                        'status'=>"failure",
                        'message'=>'Assigned to does not exists!'
                    ],200);
                }


                $projectData = $this->projectModel->where(['id'=>$mainTaskData->project_id])->first();
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
                    $mainTaskNameExistCheck = $this->workModel->where('deleted_at', '=', null)
                                                        ->where('category','=','maintask')
                                                        ->where('name','=',$request->name)
                                                        ->orderBy('name','asc')->get();

                    if(count($mainTaskNameExistCheck)==0){
                        return response([
                            'status'=>"failure",
                            'message'=>'MainTask name does not exists!'
                        ],200);
                    }else{
                        $updateData['name'] = ucfirst($request->name);
                    }

                    /*$maintask = $this->mainTaskModel->where(['name'=>$request->name])->get(); 
                    if(count($maintask)>0 && ucfirst($request->name) != $mainTaskData->name){
                        return response([
                            'status'=>"failure",
                            'message'=>'MainTask name already exists!'
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
                    $this->mainTaskModel->where('id',$request->id)->update($updateData);

                    $updatedData = $this->mainTaskModel->where('id',$request->id)->first();  
                    return response(['status'=>"success", 'message'=>'MainTask has been updated successfully.', 'data'=>$updatedData]);
                    
                }catch(Exception $e){
                    return response(['status'=>"failure", 'message'=>'Please try again!', 'error'=>$e],200);
                }

            }else{
                return response([
                                'status'=>"failure",
                                'message'=>'MainTask not found!'
                            ],200); 
            }
        }

    }





    /**
     * Add MainTask Comment
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

            $mainTaskData = $this->mainTaskModel->where('id',$request->id)->first();  

            if($mainTaskData){                
                
                try{
                    
                    $insertData=[
                                'project_id'=>$mainTaskData->project_id,
                                'milestone_id'=>$mainTaskData->milestone_id,
                                'main_task_id'=>$mainTaskData->id,
                                'comment'=>ucfirst($request->comment),
                                'added_by'=>$request->decode->id,
                                'created_at'=>date('Y-m-d H:i:s')
                            ];

                    $taskCommentId = $this->taskSubtaskCommentModel->insertGetId($insertData);

                    if($taskCommentId!=''){

                        $projectData = DB::table('project')->where('id', $mainTaskData->project_id)->first();
                        $projectName = $projectData->name;

                        $activity = "Comment has been added to ".$mainTaskData->name;
                        $added_by = $request->decode->id;
                        $assigned_to = $mainTaskData->assigned_to;
                        $project_id = $mainTaskData->project_id;
                        $milestone_id = $mainTaskData->milestone_id;
                        $main_task_id = $mainTaskData->id;
                        $task_id = NULL;
                        $sub_task_id = NULL;

                        $activityId = addActivity($activity,$added_by,$assigned_to,$project_id,$milestone_id,$main_task_id,$task_id,$sub_task_id);
                    }

                    $allComments = $this->taskSubtaskCommentModel->where('project_id',$mainTaskData->project_id)
                                                                ->where('milestone_id',$mainTaskData->milestone_id)
                                                                ->where('main_task_id',$mainTaskData->id)
                                                                ->get();  
                    return response(['status'=>"success", 'message'=>'Comment has been added successfully.', 'data'=>$allComments]);
                    
                }catch(Exception $e){
                    return response(['status'=>"failure", 'message'=>'Please try again!', 'error'=>$e],200);
                }

            }else{
                return response([
                                'status'=>"failure",
                                'message'=>'Main task not found!'
                            ],200); 
            }
        }

    }




    public function show_comments(Request $request){ 

        //return $request->decode;
        $role_type = $request->decode->role_type;
        $user_id = $request->decode->id;

        if($user_id!='' && ($role_type!='')){
        
            $data = DB::table('main_task')
                            ->join('task_subtask_comments','main_task.id', '=', 'task_subtask_comments.main_task_id')
                            ->join('users','task_subtask_comments.added_by', '=', 'users.id')
                            ->select('main_task.name as maintask_name','users.fname','users.lname','task_subtask_comments.comment','task_subtask_comments.created_at')
                            ->where('main_task.deleted_at', '=', null)
                            ->where('main_task.id', '=', $request->id)
                            ->orderBy('main_task.id','desc')->get(); 

            
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

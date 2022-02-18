<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Milestone;
use App\Models\Work;
use App\Models\User;
use App\Models\TaskSubtaskComment;
use Validator;
use Hash;
use DB;

use App\Mail\MilestoneCreation;
use Illuminate\Support\Facades\Mail;


/** 
 * @group Milestone Management
 * 
 * This api for Milestone management 
 */
class MilestoneController extends Controller
{
    protected $workModel;
    protected $projectModel;
    protected $milestoneModel;
    protected $userModel;
    protected $taskSubtaskCommentModel;

    public function __construct(){
        $this->workModel = new Work;
        $this->projectModel = new Project;
        $this->milestoneModel = new Milestone;
        $this->userModel = new User;
        $this->taskSubtaskCommentModel = new TaskSubtaskComment;
    }

    /**
     * Milestone list 
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
                    $data = $this->milestoneModel->where('deleted_at', '=', null)->get();
                }else{
                    $data = $this->milestoneModel->where('deleted_at', '=', null)
                                            ->where('name', 'like', '%'.$request->search.'%')
                                            ->get();
                }
            
            }else{

                if($search==''){
                    $data = $this->milestoneModel->where('deleted_at', '=', null)
                                                ->where('assigned_to', '=', $user_id)
                                                ->get();
                }else{
                    
                    $data = $this->milestoneModel->where('deleted_at', '=', null)
                                                ->where('assigned_to', '=', $user_id)
                                                ->where('name', 'like', '%'.$request->search.'%')
                                                ->get();
                }
            }

            
            if(count($data)>0){
                return response(['status'=>"success", 'message'=>'Milestone list found.', 'data'=>$data]);
            }else{
                return response(['status'=>"failure", 'message'=>'Milestone not found!', 'data'=>$data]);
            }

        }else{
            return response([
                'status'=>"failure",
                'message'=>'Please provide a valid token!'
            ],401);
        }
        
    }




    public function projectwise_milestone(Request $request){ 

        //return $request->decode;
        $role_type = $request->decode->role_type;
        $user_id = $request->decode->id;

        if($user_id!='' && ($role_type!='') && $request->projectId!=''){
            
            if($request->projectId!=''){

                    $search = $request->search;

                    if($role_type==1){
                        if($search==''){
                            $data = $this->milestoneModel->where('deleted_at', '=', null)
                                                        ->where('project_id', '=', $request->projectId)
                                                        ->get();
                        }else{
                            $data = $this->milestoneModel->where('deleted_at', '=', null)
                                                    ->where('project_id', '=', $request->projectId)
                                                    ->where('name', 'like', '%'.$request->search.'%')
                                                    ->get();
                        }
                    
                    }else{

                        if($search==''){
                            $data = $this->milestoneModel->where('deleted_at', '=', null)
                                                        ->where('project_id', '=', $request->projectId)
                                                        ->where('assigned_to', '=', $user_id)
                                                        ->get();
                        }else{
                            
                            $data = $this->milestoneModel->where('deleted_at', '=', null)
                                                        ->where('assigned_to', '=', $user_id)
                                                        ->where('project_id', '=', $request->projectId)
                                                        ->where('name', 'like', '%'.$request->search.'%')
                                                        ->get();
                        }
                    }

                    
                    if(count($data)>0){
                        return response(['status'=>"success", 'message'=>'Milestone list found.', 'data'=>$data]);
                    }else{
                        return response(['status'=>"failure", 'message'=>'Milestone not found!', 'data'=>$data]);
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
     * Milestone add 
     * @bodyParam project_id int required Project Id
     * @bodyParam name string required Milestone name  
     * @bodyParam milestone_no alphanumeric required Milestone number
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

        $validator = Validator::make($request->all(), [
                            'project_id' => 'required|numeric',
                            'name' => 'required|string',
                            'milestone_no' => 'required|string',
                            'assigned_to' => 'required|numeric',
                            'start_date' => 'required|date_format:Y-m-d',
                            'end_date' => 'required|date_format:Y-m-d|after_or_equal:start_date',
                            'description' => 'required'
                        ]);

        if ($validator->fails()) { 
            //return response($validator->errors(),200);
            return response()->json(['status' => "failure",'message' => $validator->messages()], 406);  
        }else{ 
            
            $data =(Object) $request->all();

            /*$milestoneName = $this->milestoneModel->where(['name'=>$data->name])->get();
            if(count($milestoneName)>0){
                return response([
                    'status'=>"failure",
                    'message'=>'Milestone name already exists!'
                ],200);
            }*/

            $milestoneNameExistCheck = $this->workModel->where('deleted_at', '=', null)
                                                        ->where('category','=','milestone')
                                                        ->where('name','=',$data->name)
                                                        ->orderBy('name','asc')->get();

            if(count($milestoneNameExistCheck)==0){
                return response([
                    'status'=>"failure",
                    'message'=>'Milestone name does not exists!'
                ],200);
            }


            $projectExistCheck = $this->projectModel->where(['id'=>$data->project_id])->get(); 
            if(count($projectExistCheck)==0){
                return response([
                    'status'=>"failure",
                    'message'=>'Project does not exists!'
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

            

            //return "......valid....";

            $insertData=[
                        'project_id'=>$request->project_id,
                        'name'=>ucfirst($request->name),
                        'milestone_no'=>$request->milestone_no,
                        'assigned_to'=>$request->assigned_to,
                        'description'=>$request->description,
                        'start_date'=>$start_date,
                        'end_date'=>$end_date,
                        'added_by'=>$request->decode->id,
                        'created_at'=>date('Y-m-d H:i:s')
                    ];

            $milestoneId = $this->milestoneModel->insertGetId($insertData);

            if($milestoneId!=''){
                $activity = "New milestone created: ".ucfirst($request->name);
                $added_by = $request->decode->id;
                $assigned_to = $request->assigned_to;
                $project_id = $request->project_id;
                $milestone_id = $milestoneId;
                $main_task_id = NULL;
                $task_id = NULL;
                $sub_task_id = NULL;

                $activityId = addActivity($activity,$added_by,$assigned_to,$project_id,$milestone_id,$main_task_id,$task_id,$sub_task_id);

                // Send Email =========================================================
                $createdData = DB::table('users')->where('id', $request->decode->id)->first();
                $createdBy = $createdData->fname.' '.$createdData->lname; 

                $assignedToData = DB::table('users')->where('id', $request->assigned_to)->first();
                $assignedTo = $assignedToData->fname.' '.$assignedToData->lname;
                $assignedToEmail = $assignedToData->email;

                $projectData = DB::table('project')->where('id', $request->project_id)->first();
                $projectName = $projectData->name;

                $subject = 'New milestone has been created '.ucfirst($request->name).' for project: '.$projectName;
                $to = $assignedToEmail;

                $details = [
                        'to' => $to,
                        'from' => env('MAIL_FROM_ADDRESS'),
                        'subject' => $subject,
                        'receiver' => $assignedTo,
                        'sender' => env('MAIL_FROM_NAME'), 
                        'project_name' => ucfirst($projectName), 
                        'milestone_name' => ucfirst($request->name), 
                        'created_by' => $createdBy,
                        'start_date'=>date('d-M-Y', strtotime($start_date)),
                        'end_date'=>date('d-M-Y', strtotime($end_date)),
                        'assigned_to'=>$assignedTo,
                        'description'=>$request->description
                    ];

                Mail::to($to)->send(new MilestoneCreation($details));
            }

            return response([
                'status'=>"success",
                'milestone_id'=>$milestoneId,
                'message'=>'Milestone has been added successfully.'
            ]);
                
            
        }

    }



    /**
     * Milestone edit
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
                            'project_id' => 'required|numeric',
                            'name' => 'required|string',
                            'milestone_no' => 'required|string',
                            'assigned_to' => 'required|numeric',
                            'start_date' => 'required|date_format:Y-m-d',
                            'end_date' => 'required|date_format:Y-m-d|after_or_equal:start_date',
                            'description' => 'required'
                        ]);
 

        if ($validator->fails()) { 
            //return response($validator->errors(),200);
            return response()->json(['status' => "failure",'message' => $validator->messages()], 406);  
        }else{ 

            $milestoneData = $this->milestoneModel->where('id',$request->id)->first();  

            if($milestoneData){

                $projectExistCheck = $this->projectModel->where(['id'=>$request->project_id])->get(); 
                if(count($projectExistCheck)==0){
                    return response([
                        'status'=>"failure",
                        'message'=>'Project does not exists!'
                    ],200);
                }

                $assignedToExistCheck = $this->userModel->where(['id'=>$request->assigned_to,'status'=>'active'])->get(); 
                if(count($assignedToExistCheck)==0){
                    return response([
                        'status'=>"failure",
                        'message'=>'Assigned to does not exists!'
                    ],200);
                }


                $projectData = $this->projectModel->where(['id'=>$milestoneData->project_id])->first();
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
                    $milestoneNameExistCheck = $this->workModel->where('deleted_at', '=', null)
                                                        ->where('category','=','milestone')
                                                        ->where('name','=',$request->name)
                                                        ->orderBy('name','asc')->get();

                    if(count($milestoneNameExistCheck)==0){
                        return response([
                            'status'=>"failure",
                            'message'=>'Milestone name does not exists!'
                        ],200);
                    }else{
                        $updateData['name'] = ucfirst($request->name);
                    }


                    /*$milestone = $this->milestoneModel->where(['name'=>$request->name])->get(); 
                    if(count($milestoneNameExistCheck)>0 && ucfirst($request->name) != $milestoneData->name){
                        return response([
                            'status'=>"failure",
                            'message'=>'Milestone name already exists!'
                        ],200);
                    }else{
                        $updateData['name'] = ucfirst($request->name);
                    }*/
                    
                }


                if($request->has('milestone_no')){
                    $updateData['milestone_no'] = $request->milestone_no; 
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
                
            
                
                try{
                    $this->milestoneModel->where('id',$request->id)->update($updateData);

                    $updatedData = $this->milestoneModel->where('id',$request->id)->first();  
                    return response(['status'=>"success", 'message'=>'Milestone has been updated successfully.', 'data'=>$updatedData]);
                    
                }catch(Exception $e){
                    return response(['status'=>"failure", 'message'=>'Please try again!', 'error'=>$e],200);
                }

            }else{
                return response([
                                'status'=>"failure",
                                'message'=>'Milestone not found!'
                            ],200); 
            }
        }

    }






    /**
     * Add Milestone Comment
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

            $milestoneData = $this->milestoneModel->where('id',$request->id)->first();  

            if($milestoneData){                
                
                try{
                    
                    $insertData=[
                                'project_id'=>$milestoneData->project_id,
                                'milestone_id'=>$milestoneData->id,
                                'comment'=>ucfirst($request->comment),
                                'added_by'=>$request->decode->id,
                                'created_at'=>date('Y-m-d H:i:s')
                            ];

                    $taskCommentId = $this->taskSubtaskCommentModel->insertGetId($insertData);

                    if($taskCommentId!=''){

                        $projectData = DB::table('project')->where('id', $milestoneData->project_id)->first();
                        $projectName = $projectData->name;

                        $activity = "Comment has been added to ".$milestoneData->name;
                        $added_by = $request->decode->id;
                        $assigned_to = $milestoneData->assigned_to;
                        $project_id = $milestoneData->project_id;
                        $milestone_id = $milestoneData->id;
                        $main_task_id = NULL;
                        $task_id = NULL;
                        $sub_task_id = NULL;

                        $activityId = addActivity($activity,$added_by,$assigned_to,$project_id,$milestone_id,$main_task_id,$task_id,$sub_task_id);
                    }

                    $allComments = $this->taskSubtaskCommentModel->where('project_id',$milestoneData->project_id)
                                                                ->where('milestone_id',$milestoneData->id)
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
        
            $data = DB::table('milestone')
                            ->join('task_subtask_comments','milestone.id', '=', 'task_subtask_comments.milestone_id')
                            ->join('users','task_subtask_comments.added_by', '=', 'users.id')
                            ->select('milestone.name as milestone_name','users.fname','users.lname','task_subtask_comments.comment','task_subtask_comments.created_at')
                            ->where('milestone.deleted_at', '=', null)
                            ->where('milestone.id', '=', $request->id)
                            ->orderBy('milestone.id','desc')->get(); 

            
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

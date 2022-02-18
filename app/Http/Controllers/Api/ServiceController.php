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
use App\Models\User;
//use App\Models\Service;
use Validator;
use Hash;
use DB;



/** 
 * @group Service Management
 * 
 * This api for service management 
 */
class ServiceController extends Controller
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
     * Service list 
     * 
     */
    public function list(Request $request){ 

        //return $request->decode;
        $role_type = $request->decode->role_type;
        $user_id = $request->decode->id;

        if($user_id!='' && ($role_type!=7 || $role_type!=8 || $role_type!=9)){
            $serviceName = $request->search;

            if($serviceName==''){
                $data = $this->taskModel->where('deleted_at', '=', null)
                                        ->where('type', '=', 'service')
                                        ->where('status', '<>', '4')
                                        ->where('status', '<>', '6')
                                        ->get();

            }else{

                $data = $this->taskModel->where('deleted_at', '=', null)
                                        ->where('name', 'like', '%'.$serviceName.'%')
                                        ->where('type', '=', 'service')
                                        ->where('status', '<>', '4')
                                        ->where('status', '<>', '6')
                                        ->get();
            }

            if(count($data)>0){
                $newArr = array();
                foreach ($data as $key => $value) {
                    $projectData = $this->projectModel->where('id',$value->project_id)->first();
                    $milestoneData = $this->milestoneModel->where('id',$value->milestone_id)->first();
                    $mainTaskData = $this->mainTaskModel->where('id',$value->main_task_id)->first();
                    $assignedToData = $this->userModel->where('id',$value->assigned_to)->first();

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

                    $newArr[] = array('id'=>$value->id,
                                    'type'=>$value->type,
                                    'work_id'=>$value->work_id,
                                    'project_id'=>$value->project_id,
                                    'project_name'=>$projectData->name,
                                    'milestone_id'=>$value->milestone_id,
                                    'milestone_name'=>$milestoneData->name,
                                    'main_task_id'=>$value->main_task_id,
                                    'main_task_name'=>$mainTaskData->name,
                                    'name'=>$value->name,
                                    'task_no'=>$value->task_no,
                                    'quantity'=>$value->quantity,
                                    'assigned_to'=>$value->assigned_to,
                                    'assigned_to_name'=>$assignedToData->fname.' '.$assignedToData->lname,
                                    'approved_by'=>$value->approved_by,
                                    'helpers'=>$value->helpers,
                                    'start_date'=>$value->start_date,
                                    'end_date'=>$value->end_date,
                                    'description'=>$value->description,
                                    'added_by'=>$value->added_by,
                                    'service_created_by'=>$value->service_created_by,
                                    'status'=>$status,
                                    'created_at'=>$value->created_at,
                                    'updated_at'=>$value->updated_at,
                                    'deleted_at'=>$value->deleted_at,
                                    );
                }

                return response(['status'=>"success", 'message'=>'Service list found.', 'data'=>$newArr]);
            }else{
                return response(['status'=>"failure", 'message'=>'Service not found!', 'data'=>$data]);
            }

            

        }else{
            return response([
                'status'=>"failure",
                'message'=>'Please provide a valid token!'
            ],401);
        }
        
    }

    




    
}

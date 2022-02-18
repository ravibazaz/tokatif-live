<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Milestone;
use App\Models\MainTask;
use App\Models\Work;
use App\Models\User;
use Validator;
use Hash;
use DB;

use App\Mail\MaintaskCreation;
use Illuminate\Support\Facades\Mail;


/** 
 * @group Calender Management
 * 
 * This api for Calender 
 */
class CalenderController extends Controller
{
    protected $workModel;
    protected $projectModel;
    protected $milestoneModel;
    protected $mainTaskModel;
    protected $userModel;

    public function __construct(){
        $this->workModel = new Work;
        $this->projectModel = new Project;
        $this->milestoneModel = new Milestone;
        $this->mainTaskModel = new MainTask;
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

        if($user_id!='' && ($role_type!='')){

            $validator = Validator::make($request->all(), [
                            'start_date' => 'required|date_format:Y-m-d',
                            'end_date' => 'required|date_format:Y-m-d|after_or_equal:start_date'
                        ]);

            if ($validator->fails()) { 
                return response()->json(['status' => "failure",'message' => $validator->messages()], 406);  
            }else{ 
                $projectData = DB::table('project')
                                        ->join('users','project.added_by', '=', 'users.id')
                                        ->select('project.*','users.fname as created_by')
                                        ->where('project.deleted_at', '=', null)
                                        ->where('project.start_date', '>=', $request->start_date)
                                        ->where('project.end_date', '<=', $request->end_date)
                                        ->orderBy('project.id','desc')->get();

                if(count($projectData)>0){
                    return response(['status'=>"success", 'message'=>'Project list found.', 'data'=>$projectData]);
                }else{
                    return response(['status'=>"failure", 'message'=>'No data found!']);
                }
            }
            
            

        }else{
            return response([
                'status'=>"failure",
                'message'=>'Please provide a valid token!'
            ],401);
        }
        
    }





    
}

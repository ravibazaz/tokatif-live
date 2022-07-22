<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Registration;
use App\Models\Lessons;
use App\Models\LessonPackages;
use App\Models\TeacherAvailability;

use Session;
use Validator;
use Hash;
use Carbon\Carbon;

use Illuminate\Support\Facades\Storage;


class CalendarController extends Controller
{
    protected $registrationModel;
    protected $lessonsModel;
    protected $lessonPackagesModel;
    protected $teacherAvailabilityModel;
    public function __construct(){
        $this->registrationModel = new Registration;
        $this->lessonsModel = new Lessons;
        $this->lessonPackagesModel = new LessonPackages;
        $this->teacherAvailabilityModel = new TeacherAvailability;
    }
    
    /*public function index(){ 
        $data['title']="Settings";
        $data['breadcrumb']='Settings';

        
        $data['user'] = $this->registrationModel->where('deleted_at', '=', null)->where(['id'=>session('id')])->first(); 
        //echo $data['user']->role; die();

        if($data['user']->role=='1'){
            return view('student.dashboard',$data);
        }else{
            return view('teacher.dashboard',$data);
        }

        
    }*/
    
    
    
    // Teacher Availability ===================================================================================================
    
    public function teacher_calendar(){
        
        $data['user'] = $this->registrationModel->where('deleted_at', '=', null)->where('status', '=', '1')->where(['id'=>session('id')])->first(); 
        
        
        if($data['user']->role=='2'){
            return view('teacher.availability-calendar',$data);
        }else{
            return view('student.dashboard',$data);
        }
        
    }
    
    
    
    public function teacher_view_calendar(){
        
        $data['user'] = $this->registrationModel->where('deleted_at', '=', null)->where('status', '=', '1')->where(['id'=>session('id')])->first(); 
        
        
        if($data['user']->role=='2'){
            return view('teacher.view-calendar',$data);
        }else{
            return view('student.dashboard',$data);
        }
        
    }
    
    
    
    public function add_teacher_time_slot(Request $request){
        $user_id = session('id');
        $date = $request->date;
        $from_time = $request->from_time;
        $to_time = $request->to_time;
        $applyBtnType = $request->applyBtnType;
        
        $calenderDay = date('l', strtotime($request->date));
        
        if($applyBtnType=='weekly'){
            $type = '2';
        }else{
            $type = '1';
        }
        
        $existCheck = $this->teacherAvailabilityModel->where('user_id', '=', $user_id)->where('date', '=', $date)->where('type', '=', $type)->get(); 
        if(count($existCheck)>0){
            // $deleteOldRecords = $this->teacherAvailabilityModel->where(['user_id'=>$user_id])->delete();
            if($request->ids)
            {
                $deleteOldRecords = $this->teacherAvailabilityModel->where(['user_id'=>$user_id])->whereIn('id', $request->ids)->delete();
            }
            
            if($deleteOldRecords){
                for ($i=0; $i < count($request->from_time); $i++ ) {
                    
                    if($request->from_time[$i]!='' && $request->to_time[$i]!=''){
                        $insertData  = [
                                        'user_id' => $user_id,
                                        'type' => $type,
                                        'date' => $date,
                                        'day' => $calenderDay,
                                        'from_time' => $request->from_time[$i],
                                        'to_time' => $request->to_time[$i]
                                    ];
                                    
                        $this->teacherAvailabilityModel->insertGetId($insertData); 
                    }
                    
                }
            }
            
            
        }else{
            for ($i=0; $i < count($request->from_time); $i++ ) {
                
                if($request->from_time[$i]!='' && $request->to_time[$i]!=''){
                    $insertData  = [
                                    'user_id' => $user_id,
                                    'type' => $type,
                                    'date' => $date,
                                    'day' => $calenderDay,
                                    'from_time' => $request->from_time[$i],
                                    'to_time' => $request->to_time[$i]
                                ];
                                
                    $this->teacherAvailabilityModel->insertGetId($insertData); 
                }
                
            }
        }
        
        
    }
    
    
    
    public function get_time_slot($selectedDate){
        $date = urldecode($selectedDate);
        $start = strtotime('00:00');
        $end   = strtotime('23:30');
        
        $timeSlots = $this->teacherAvailabilityModel->where('date', '=', $date)->where('user_id', '=', session('id'))->get();
        
        //$timeSlots = $this->teacherAvailabilityModel->where('user_id', '=', session('id'))->get();
    
        $html = '';                               
        if(count($timeSlots)>0){
            
            foreach($timeSlots as $key => $val){
                
                $html .= '<input type="hidden" class="edit_time_slot_ids" id="ids[]" value="'. $val->id .'">';

                $html .= '<div class="form-group col-md-5"><select class="custom-select mr-sm-2 from_time" name="from_time[]" id="from_time">';
                            
                            for ($i=$start; $i<=$end; $i = $i + 30*60){
                                if($val->from_time == date('H:i',$i)){$fromTimeSelected = 'selected';}else{$fromTimeSelected = '';} 
                                $html .= '<option value="'.date('H:i',$i).'"  '.$fromTimeSelected.'>'.date('H:i',$i).'</option>';
                            }
                            
                $html .= '</select></div><div class="form-group col-md-5"><select class="custom-select mr-sm-2 to_time" name="to_time[]" id="to_time">';
                
                            for ($i=$start; $i<=$end; $i = $i + 30*60){
                                if($val->to_time == date('H:i',$i)){$toTimeSelected = 'selected';}else{$toTimeSelected = '';} 
                                $html .= '<option value="'.date('H:i',$i).'"  '.$toTimeSelected.' >'.date('H:i',$i).'</option>';
                            }
                
                $html .='</select></div>';
                
                // if($key>0){
                    $html .='<div class="form-group deleteTimeSlot col-md-2 text-center"  data-id="'.$val->id.'" data-Date="'.$date.'"><a href="javascript:void(0);"><i class="fa fa-trash-o" aria-hidden="true"></i></a></div>';
                // }
                
            }
            
            
        }else{
            
            $html .= '<div class="form-group col-md-5"><select class="custom-select mr-sm-2 from_time" name="from_time[]" id="from_time">';
                        
                        for ($i=$start; $i<=$end; $i = $i + 30*60){
                            $html .= '<option value="'.date('H:i',$i).'">'.date('H:i',$i).'</option>';
                        }
                        
            $html .= '</select></div><div class="form-group col-md-5"><select class="custom-select mr-sm-2 to_time" name="to_time[]" id="to_time">';
                        
                        for ($i=$start; $i<=$end; $i = $i + 30*60){
                            $html .= '<option value="'.date('H:i',$i).'" >'.date('H:i',$i).'</option>';
                        }
                        
            $html .='</select></div><div class="form-group remove-time-row col-md-2 text-center"><a href="javascript:void(0);"><i class="fa fa-trash-o" aria-hidden="true"></i></a></div>';
        }
        
        return $html;
        
        
    }
    
    
    
    public function delete_teacher_time_slot(Request $request){
        $user_id = session('id');
        $date = $request->date;
        
        $existCheck = $this->teacherAvailabilityModel->where('user_id', '=', $user_id)->where('id', '=', $request->id)->get(); 
        
        if(count($existCheck)>0){
            $deleteTimeSlots = $this->teacherAvailabilityModel->where(['user_id'=>$user_id,'id'=>$request->id])->delete();
        
            if($deleteTimeSlots){
                echo 1;
            }else{
                echo 0;
            }
            
        }else{
            echo 0;
        } 
        
    }
        
        
    
    
    
    public function student_calendar(){
        
        $data['user'] = $this->registrationModel->where('deleted_at', '=', null)->where('status', '=', '1')->where(['id'=>session('id')])->first(); 
        
        
        if($data['user']->role=='1'){
            return view('student.calendar',$data);
        }else{
            return view('teacher.dashboard',$data);
        }
        
    }
    
    

}



?>
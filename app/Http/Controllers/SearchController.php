<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Registration;
use App\Models\Lessons;
use App\Models\LessonPackages;
use App\Models\TeacherAvailability;
use App\Models\Booking;
use App\Models\FeedbackRating;

use Session;
use Validator;
use Hash;
use Carbon\Carbon;

use Illuminate\Support\Facades\Storage;


class SearchController extends Controller
{
    protected $registrationModel;
    protected $lessonsModel;
    protected $lessonPackagesModel;
    protected $teacherAvailabilityModel;
    protected $bookingModel;
    protected $feedbackRatingModel;
    
    public function __construct(){
        $this->registrationModel = new Registration;
        $this->lessonsModel = new Lessons;
        $this->lessonPackagesModel = new LessonPackages;
        $this->teacherAvailabilityModel = new TeacherAvailability;
        $this->bookingModel = new Booking;
        $this->feedbackRatingModel = new FeedbackRating;
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
    
    
    
    public function getAllTeachers(){
        $data['title']="Teachers";
        $data['breadcrumb']='Teachers';
        
        $data['user'] = $this->registrationModel->where('role', '=', '2')->where('status', '=', '1')->where('deleted_at', '=', null)->get();
        
        $data['countries'] = DB::table('countries')->orderBy('name', 'ASC')->get();
        $data['languages'] = DB::table('languages')->where('deleted_at', '=', null)->orderBy('name', 'ASC')->get();
        $data['lessonType'] = DB::table('lesson_category')->select([ DB::raw('DISTINCT(name)')])->where('deleted_at', '=', null)->orderBy('name', 'ASC')->get();
        $data['lessonTags'] = DB::table('lesson_category')->select([ DB::raw('DISTINCT(tag)')])->where('deleted_at', '=', null)
                                                                                                ->whereNotNull('tag')->orderBy('tag', 'ASC')->get(); 
        //echo "<pre>"; echo count($data['user']); exit();
        
        return view('user.teachers',$data);
        
    }
    
    
    public function teachers_search(request $request){
        $data['title']="Teachers";
        $data['breadcrumb']='Teachers';
        
        $data['user'] = $this->registrationModel->where('role', '=', '2')->where('status', '=', '1')->where('deleted_at', '=', null)->get();  
        //echo "<pre>"; echo count($data['user']); exit();
        
        if($request->has('search')){
            
            if($request->type=='name'){
                $data['user'] = $this->registrationModel->where('role', '=', '2')->where('status', '=', '1')->where('deleted_at', '=', null)
                                                        ->where('name', 'like', '%'.$request->search.'%')
                                                        ->get();
                                                        
                return view('user.ajax-teachers',$data);
            }
            
            if($request->type=='country'){
                if(count($request->search)>0){
                    $data['user'] = $this->registrationModel->where('role', '2')->where('status', '1')->where('deleted_at', null)
                                                    ->whereIn('country_living_in', $request->search)
                                                    ->get();
                }
                
                return view('user.ajax-teachers',$data);
            }
            
            if($request->type=='language'){
                if(count($request->search)>0){
                    
                    $query = Registration::query();
                    $query->where('role', '2')->where('status', '1')->where('deleted_at', null);
                    foreach( $request->search as $lang) {
                        $query->orWhereJsonContains('languages_taught', [['language' => '".$lang."']]); 
                    }
                    $user = $query->orderBy('name')->get();
                    
                    return view('user.ajax-teachers', compact('user'));

                }  
            }
            
            
            if($request->type=='price'){
                $data['user'] = Registration::selectRaw('registrations.*, MAX(lesson_packages.total) AS max_price')
                                                    ->leftJoin('lessons','lessons.user_id','=','registrations.id')
                                                    ->leftJoin('lesson_packages','lesson_packages.lesson_id','=','lessons.id')
                                                    ->where('registrations.role', '=', '2')->where('registrations.status', '=', '1')
                                                    ->where('registrations.deleted_at', '=', null)
                                                    ->groupBy('registrations.id')
                                                    ->havingRaw("max_price <= $request->search")
                                                    ->orderBy('registrations.name', 'asc')->get();
                
                return view('user.ajax-teachers',$data);
            }
            
            
            if($request->type=='teacherType'){ 
                $data['user'] = $this->registrationModel->where('role', '2')->where('status', '1')->where('deleted_at', null)
                                                        ->where('teacher_type', $request->search)
                                                        ->get();
                                                        
                return view('user.ajax-teachers',$data); 
            }
            
            
            if($request->type=='lessonType'){ //print_r($request->search); exit();
                $data['user'] = $this->registrationModel
                                                ->leftJoin('lessons','lessons.user_id','=','registrations.id')
                                                ->select(DB::raw('registrations.*'))
                                                ->where('registrations.role', '2')->where('registrations.status', '1')
                                                ->where('registrations.deleted_at', null)
                                                ->whereIn('lessons.lesson_category', $request->search)
                                                ->groupBy('registrations.id')
                                                ->orderBy('registrations.name', 'asc')->get();
                                                        
                return view('user.ajax-teachers',$data); 
            }
            
            
            if($request->type=='nativeSpeaker'){
                $query = Registration::query();
                $query->where('role', '2')->where('status', '1')->where('deleted_at', null);
                
                if($request->search=='native'){
                    $query->whereJsonContains('languages_spoken', [['level' => 'Native']]); 
                }
                if($request->search=='non_native'){
                    $query->orWhereJsonContains('languages_spoken', [['level' => 'Elementary']]); 
                    $query->orWhereJsonContains('languages_spoken', [['level' => 'Upper Intermediate']]); 
                    $query->orWhereJsonContains('languages_spoken', [['level' => 'Intermediate']]); 
                    $query->orWhereJsonContains('languages_spoken', [['level' => 'Beginner']]);  
                    $query->orWhereJsonContains('languages_spoken', [['level' => 'Proficient']]); 
                    $query->orWhereJsonContains('languages_spoken', [['level' => 'Advanced']]);
                }
                if($request->search=='both'){
                    $query->orWhereJsonContains('languages_spoken', [['level' => 'Native']]);
                    $query->orWhereJsonContains('languages_spoken', [['level' => 'Elementary']]); 
                    $query->orWhereJsonContains('languages_spoken', [['level' => 'Upper Intermediate']]); 
                    $query->orWhereJsonContains('languages_spoken', [['level' => 'Intermediate']]); 
                    $query->orWhereJsonContains('languages_spoken', [['level' => 'Beginner']]);  
                    $query->orWhereJsonContains('languages_spoken', [['level' => 'Proficient']]); 
                    $query->orWhereJsonContains('languages_spoken', [['level' => 'Advanced']]);
                }
                
                $user = $query->orderBy('name')->get();
                
                return view('user.ajax-teachers', compact('user'));
            }
            
            
            
            if($request->type=='instantTutoring'){ 
                $data['user'] = Registration::selectRaw('registrations.*')
                                                    ->leftJoin('lessons','lessons.user_id','=','registrations.id')
                                                    ->leftJoin('lesson_packages','lesson_packages.lesson_id','=','lessons.id')
                                                    ->where('registrations.role', '2')->where('registrations.status', '1')
                                                    ->where('registrations.deleted_at', null) 
                                                    ->where('lesson_packages.time', $request->search) 
                                                    ->groupBy('registrations.id')
                                                    ->orderBy('registrations.name', 'asc')->get();
                                                        
                return view('user.ajax-teachers',$data); 
            }
            
            
            if($request->type=='focusAreas'){ 
                if(count($request->search)>0){
                    $data['user'] = $this->registrationModel
                                                ->leftJoin('lessons','lessons.user_id','=','registrations.id')
                                                ->select(DB::raw('registrations.*'))
                                                ->where('registrations.role', '2')->where('registrations.status', '1')
                                                //->where('registrations.deleted_at', null)
                                                ->whereIn('lessons.lesson_tag', $request->search) 
                                                ->groupBy('registrations.id')
                                                ->orderBy('registrations.name', 'asc')->get();
                                                
                    return view('user.ajax-teachers',$data); 
                }  
            }
            
            
        }else{
            $data['user'] = $this->registrationModel->where('role', '=', '2')->where('status', '=', '1')->where('deleted_at', '=', null)->get();
            
            return view('user.ajax-teachers',$data);
        }
        
        
            
    }
    
    
    public function get_teacher_search($language){
        $data['title']="Teachers";
        $data['breadcrumb']='Teachers';
        
        if($language){
            $data['user'] = $this->registrationModel
                                    ->where('role', '=', '2')
                                    ->where('status', '=', '1')
                                    ->where('deleted_at', '=', null)
                                    ->whereJsonContains('languages_taught', ['language' => $language])
                                    ->get();
            
            
        }else{
            $data['user'] = $this->registrationModel
                                    ->where('role', '=', '2')
                                    ->where('status', '=', '1')
                                    ->where('deleted_at', '=', null)
                                    ->get();
        }
        
        $data['countries'] = DB::table('countries')->orderBy('name', 'ASC')->get();
        $data['languages'] = DB::table('languages')->where('deleted_at', '=', null)->orderBy('name', 'ASC')->get();
        $data['lessonType'] = DB::table('lesson_category')->select([ DB::raw('DISTINCT(name)')])->where('deleted_at', '=', null)->orderBy('name', 'ASC')->get();
        $data['lessonTags'] = DB::table('lesson_category')->select([ DB::raw('DISTINCT(tag)')])->where('deleted_at', '=', null)
                                                                                                ->whereNotNull('tag')->orderBy('tag', 'ASC')->get(); 
        
        return view('user.teachers',$data);
            
    }
    
    
    public function get_teacher_detail($id){
        $data['title']="Teacher Detail";
        $data['breadcrumb']='Teacher Detail';
        
        if($id){
            $data['user'] = $this->registrationModel
                                    ->where('role', '=', '2')
                                    ->where('status', '=', '1')
                                    ->where('deleted_at', '=', null)
                                    ->where('id', '=', $id)
                                    ->first();
            
            $data['lessonCount'] = $this->lessonsModel->where('deleted_at', '=', null)->where(['user_id'=>$id])->count();
            $data['studentCount'] = $this->bookingModel->where(['teacher_id'=>$id])->distinct('student_id')->count('student_id');
            
            $data['lessons'] = $this->lessonsModel->leftJoin('lesson_packages', 'lessons.id', '=', 'lesson_packages.lesson_id')
                                                ->whereNull('lessons.deleted_at')
                                                ->where('lessons.user_id', '=', $id)
                                                ->orderBy('lessons.created_at', 'desc')->limit(10)->get();  
            
            $data['review_rating'] = $this->feedbackRatingModel->where('deleted_at', '=', null)->where(['teacher_id'=>$id])->get();
            
            $totalBadgesCount = 0;
            $badgesArr = array();
            if(count($data['review_rating'])>0){
                foreach($data['review_rating'] as $val){
                    $badgesArr[] = json_decode($val->badges);
                    
                    $badges = json_decode($val->badges);
                    $totalBadgesCount += count($badges);
                }
            }
            
            $newBadgesArr = array();
            if($totalBadgesCount>0){
                foreach($badges as $val){ 
                    $newBadgesArr[] = $val;
                }
            }
            
            
            $data['total_badges_count'] = $totalBadgesCount;
            $data['badges'] = $newBadgesArr;
            
        }else{
            $data['user'] = '';
            $data['lessons'] = '';
            $data['review_rating'] = '';
            $data['badges'] = '';
            
            $data['lessonCount'] = 0;
            $data['studentCount'] = 0;
            $data['total_badges_count'] = 0;
            
        }
        //echo "<pre>"; print_r($data['badges']); exit();
        
        return view('user.teacher-detail',$data);
            
    }
 
    

}



?>
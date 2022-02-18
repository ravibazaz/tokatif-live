<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Registration;
use App\Models\Lessons;
use App\Models\LessonPackages;
use App\Models\LessonInvitation;
use App\Models\Booking;
use App\Models\LessonLog;
use App\Models\FeedbackRating;

use Session;
use Validator;
use Hash;
use Carbon\Carbon;

use Illuminate\Support\Facades\Storage;

use App\Mail\LessonBooking;
use Illuminate\Support\Facades\Mail;

if (version_compare(PHP_VERSION, '7.2.0', '>=')) {
    // Ignores notices and reports all other kinds... and warnings
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
    // error_reporting(E_ALL ^ E_WARNING); // Maybe this is enough
}

class LessonController extends Controller
{
    protected $registrationModel;
    protected $lessonsModel;
    protected $lessonPackagesModel;
    protected $lessonInvitationModel;
    protected $bookingModel;
    protected $lessonLogModel;
    protected $feedbackRatingModel;
    
    public function __construct(){
        $this->registrationModel = new Registration;
        $this->lessonsModel = new Lessons;
        $this->lessonPackagesModel = new LessonPackages;
        $this->lessonInvitationModel = new LessonInvitation;
        $this->bookingModel = new Booking;
        $this->lessonLogModel = new LessonLog;
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
    
    
    public function lesson_management(){
        $data['lessons'] = $this->lessonsModel->where('deleted_at', '=', null)->where(['user_id'=>session('id')])->get(); 
        
        $data['user'] = $this->registrationModel->where('deleted_at', '=', null)->where(['id'=>session('id')])->first(); 
        
        if($data['user']->role=='2'){
            return view('teacher.lessons',$data);
        }else{
            return view('student.dashboard',$data);
        }
    }
    
    public function my_lesson(){
        
        $data['user'] = $this->registrationModel->where('deleted_at', '=', null)->where(['id'=>session('id')])->first(); 
        $data['lessonCategory'] = DB::table('lesson_category')->where('deleted_at', '=', null)->get()->unique('name');
        $data['students'] = $this->registrationModel->where('deleted_at', '=', null)->where('role', '=', '1')->get();
        $data['lessons'] = $this->lessonsModel->where('deleted_at', '=', null)->where(['user_id'=>session('id')])->get(); 
        
        //echo $data['user']->role; exit();
        if($data['user']->role=='2'){
            $data['pending'] = $this->bookingModel->leftJoin('lessons', 'booking.lesson_id', '=', 'lessons.id')
                                                ->leftJoin('lesson_packages', 'booking.lesson_package_id', '=', 'lesson_packages.id')
                                                ->select(DB::raw('booking.*,lessons.user_id,lessons.type,lessons.name,lessons.description,lessons.lesson_category,lessons.lesson_tag,lessons.language_taught,lessons.student_languages_level_from,lessons.student_languages_level_to,lesson_packages.time,lesson_packages.individual_lesson,lesson_packages.package,lesson_packages.total'))
                                                ->whereNull('lessons.deleted_at')
                                                ->where('booking.teacher_id', '=', session('id'))
                                                ->where('booking.booking_date', '>=', date('Y-m-d'))
                                                ->where('booking.teacher_accept_status', '=', '0')
                                                ->where('booking.status', '=', '1')
                                                ->orderBy('lessons.created_at', 'desc')->get(); 
                                                
              
            
            $data['upcoming'] = $this->bookingModel->leftJoin('lessons', 'booking.lesson_id', '=', 'lessons.id')
                                                ->leftJoin('lesson_packages', 'booking.lesson_package_id', '=', 'lesson_packages.id')
                                                ->whereNull('lessons.deleted_at')
                                                ->where('booking.teacher_id', '=', session('id'))
                                                ->where('booking.booking_date', '>', date('Y-m-d'))
                                                ->where('booking.status', '=', '1')
                                                ->orderBy('lessons.created_at', 'desc')->get(); 
                                                
                                                
            $data['waiting'] = $this->bookingModel->leftJoin('lessons', 'booking.lesson_id', '=', 'lessons.id')
                                                ->leftJoin('lesson_packages', 'booking.lesson_package_id', '=', 'lesson_packages.id')
                                                ->select(DB::raw('booking.*,lessons.user_id,lessons.type,lessons.name,lessons.description,lessons.lesson_category,lessons.lesson_tag,lessons.language_taught,lessons.student_languages_level_from,lessons.student_languages_level_to,lesson_packages.time,lesson_packages.individual_lesson,lesson_packages.package,lesson_packages.total'))
                                                ->whereNull('lessons.deleted_at')
                                                ->where('booking.teacher_id', '=', session('id'))
                                                ->where('booking.booking_date', '<=', date('Y-m-d'))
                                                ->where('booking.teacher_accept_status', '=', '1')
                                                ->where('booking.student_accept_status', '=', '1')
                                                ->whereNotNull('booking.lesson_started_at')
                                                ->whereNull('booking.lesson_completed_at')
                                                ->where('booking.status', '=', '3')
                                                ->orderBy('lessons.created_at', 'desc')->get(); 
                                                
            //echo "<pre>"; print_r($data['waiting']); exit(); 
            
            $data['completed'] = $this->bookingModel->leftJoin('lessons', 'booking.lesson_id', '=', 'lessons.id')
                                                ->leftJoin('lesson_packages', 'booking.lesson_package_id', '=', 'lesson_packages.id')
                                                ->whereNull('lessons.deleted_at')
                                                ->where('booking.teacher_id', '=', session('id'))
                                                ->where('booking.status', '=', '3')
                                                ->orderBy('lessons.created_at', 'desc')->get(); 
                                                
                                                
            $data['today_lesson'] = $this->bookingModel->leftJoin('lessons', 'booking.lesson_id', '=', 'lessons.id')
                                                ->leftJoin('lesson_packages', 'booking.lesson_package_id', '=', 'lesson_packages.id')
                                                ->whereNull('lessons.deleted_at')
                                                ->where('booking.teacher_id', '=', session('id'))
                                                ->where('booking_date', '=', date('Y-m-d'))
                                                ->orderBy('lessons.created_at', 'desc')->get(); 
                                                
                                                
            $data['today_start'] = $this->bookingModel->leftJoin('lessons', 'booking.lesson_id', '=', 'lessons.id')
                                                ->leftJoin('lesson_packages', 'booking.lesson_package_id', '=', 'lesson_packages.id')
                                                ->whereNull('lessons.deleted_at')
                                                ->where('booking.teacher_id', '=', session('id'))
                                                ->where('booking_date', '=', date('Y-m-d'))
                                                ->where('booking.teacher_accept_status', '=', '1')
                                                ->where('booking.status', '=', '1')
                                                ->orderBy('lessons.created_at', 'desc')->get(); 
                                                
                                                
            $data['cancelled'] = $this->bookingModel->leftJoin('lessons', 'booking.lesson_id', '=', 'lessons.id')
                                                ->leftJoin('lesson_packages', 'booking.lesson_package_id', '=', 'lesson_packages.id')
                                                ->whereNull('lessons.deleted_at')
                                                ->where('booking.teacher_id', '=', session('id'))
                                                ->where('booking.status', '=', '2')
                                                ->orderBy('lessons.created_at', 'desc')->get(); 
                                                
                                                
                                                
            //echo count($data['today_lesson']); exit();    
            
            
            $data['active_packages'] = $this->lessonsModel->leftJoin('lesson_packages', 'lessons.id', '=', 'lesson_packages.lesson_id')
                                                ->select(DB::raw('lessons.*,lesson_packages.time,lesson_packages.individual_lesson,lesson_packages.package,lesson_packages.total,lesson_packages.created_at,lessons.lesson_tag,lessons.language_taught,lessons.student_languages_level_from,lessons.student_languages_level_to'))
                                                ->whereNull('lessons.deleted_at')
                                                ->whereNull('lesson_packages.deleted_at')
                                                ->where('lessons.user_id', '=', session('id'))
                                                ->orderBy('lesson_packages.created_at', 'desc')->get();
                                                
            
            $data['inactive_packages'] = $this->lessonsModel->leftJoin('lesson_packages', 'lessons.id', '=', 'lesson_packages.lesson_id')
                                                ->select(DB::raw('lessons.*,lesson_packages.time,lesson_packages.individual_lesson,lesson_packages.package,lesson_packages.total,lesson_packages.created_at,lessons.lesson_tag,lessons.language_taught,lessons.student_languages_level_from,lessons.student_languages_level_to'))
                                                ->whereNull('lessons.deleted_at')
                                                ->whereNotNull('lesson_packages.deleted_at')
                                                ->where('lessons.user_id', '=', session('id'))
                                                ->orderBy('lesson_packages.created_at', 'desc')->get();
                                                
                                                
            //echo count($data['today_lesson']); print_r($data['today_lesson']); exit();
            
            return view('teacher.my-lesson',$data);
        }else{
            
            $data['pending'] = $this->bookingModel->leftJoin('lessons', 'booking.lesson_id', '=', 'lessons.id')
                                                ->leftJoin('lesson_packages', 'booking.lesson_package_id', '=', 'lesson_packages.id')
                                                ->select(DB::raw('booking.*,lessons.user_id,lessons.type,lessons.name,lessons.description,lessons.lesson_category,lessons.lesson_tag,lessons.language_taught,lessons.student_languages_level_from,lessons.student_languages_level_to,lesson_packages.time,lesson_packages.individual_lesson,lesson_packages.package,lesson_packages.total'))
                                                ->whereNull('lessons.deleted_at')
                                                ->where('booking.student_id', '=', session('id'))
                                                ->where('booking.booking_date', '>=', date('Y-m-d'))
                                                ->where('booking.student_accept_status', '=', '0')
                                                ->where('booking.status', '=', '1')
                                                ->orderBy('lessons.created_at', 'desc')->get(); 
                                                
            //echo "<pre>"; print_r($data['pending']); exit();   
            
            $data['invitation'] = DB::table('lesson_invitation')->where('student_id', '=', session('id'))
                                                                ->where('booking_date', '>=', date('Y-m-d')) 
                                                                ->where('status', '=', '0')->get(); 
                                                                
            //echo "aaaaaaaa:: ".count($data['invitation']); exit(); 
            
            $data['upcoming'] = $this->bookingModel->leftJoin('lessons', 'booking.lesson_id', '=', 'lessons.id')
                                                ->leftJoin('lesson_packages', 'booking.lesson_package_id', '=', 'lesson_packages.id')
                                                ->whereNull('lessons.deleted_at')
                                                ->where('booking.student_id', '=', session('id'))
                                                ->where('booking.booking_date', '>', date('Y-m-d'))
                                                ->where('booking.status', '=', '1')
                                                ->orderBy('lessons.created_at', 'desc')->get(); 
                                                
                                                
            /*$data['waiting'] = $this->bookingModel->leftJoin('lessons', 'booking.lesson_id', '=', 'lessons.id')
                                                ->leftJoin('lesson_packages', 'booking.lesson_package_id', '=', 'lesson_packages.id')
                                                ->whereNull('lessons.deleted_at')
                                                ->where('booking.student_id', '=', session('id'))
                                                ->where('booking.booking_date', '>', date('Y-m-d'))
                                                ->where('booking.status', '=', '0')
                                                ->orderBy('lessons.created_at', 'desc')->get(); */
                                                
            $data['waiting'] = $this->bookingModel->leftJoin('lessons', 'booking.lesson_id', '=', 'lessons.id')
                                                ->leftJoin('lesson_packages', 'booking.lesson_package_id', '=', 'lesson_packages.id')
                                                ->select(DB::raw('booking.*,lessons.user_id,lessons.type,lessons.name,lessons.description,lessons.lesson_category,lessons.lesson_tag,lessons.language_taught,lessons.student_languages_level_from,lessons.student_languages_level_to,lesson_packages.time,lesson_packages.individual_lesson,lesson_packages.package,lesson_packages.total'))
                                                ->whereNull('lessons.deleted_at')
                                                ->where('booking.student_id', '=', session('id'))
                                                ->where('booking.booking_date', '<=', date('Y-m-d'))
                                                ->where('booking.teacher_accept_status', '=', '1')
                                                ->where('booking.student_accept_status', '=', '1')
                                                ->whereNotNull('booking.lesson_started_at')
                                                ->whereNull('booking.lesson_completed_at')
                                                ->where('booking.status', '=', '3')
                                                ->orderBy('lessons.created_at', 'desc')->get(); 
                                                
            //echo "<pre>"; print_r($data['waiting']); exit(); 
            
            /*$d = $this->bookingModel->leftJoin('lessons', 'booking.lesson_id', '=', 'lessons.id')
                                                ->leftJoin('lesson_packages', 'booking.lesson_package_id', '=', 'lesson_packages.id')
                                                ->select(DB::raw('booking.*,lessons.user_id,lessons.type,lessons.name,lessons.description,lessons.lesson_category,lessons.lesson_tag,lessons.language_taught,lessons.student_languages_level_from,lessons.student_languages_level_to,lesson_packages.time,lesson_packages.individual_lesson,lesson_packages.package,lesson_packages.total'))
                                                ->whereNull('lessons.deleted_at')
                                                ->where('booking.student_id', '=', session('id'))
                                                ->where('booking.booking_date', '>=', date('Y-m-d'))
                                                ->where('booking.teacher_accept_status', '=', '1')
                                                ->where('booking.student_accept_status', '=', '1')
                                                ->whereNotNull('booking.lesson_started_at')
                                                ->whereNull('booking.lesson_completed_at')
                                                ->where('booking.status', '=', '3')
                                                ->orderBy('lessons.created_at', 'desc')->toSql(); 
                                                
            echo $d; exit();*/
                                                
                                                
            $data['completed'] = $this->bookingModel->leftJoin('lessons', 'booking.lesson_id', '=', 'lessons.id')
                                                ->leftJoin('lesson_packages', 'booking.lesson_package_id', '=', 'lesson_packages.id')
                                                ->whereNull('lessons.deleted_at')
                                                ->where('booking.student_id', '=', session('id'))
                                                ->where('booking.status', '=', '3')
                                                ->orderBy('lessons.created_at', 'desc')->get(); 
                                                
                                                
            $data['today'] = $this->bookingModel->leftJoin('lessons', 'booking.lesson_id', '=', 'lessons.id')
                                                ->leftJoin('lesson_packages', 'booking.lesson_package_id', '=', 'lesson_packages.id')
                                                ->whereNull('lessons.deleted_at')
                                                ->where('booking.student_id', '=', session('id'))
                                                ->where('booking_date', '=', date('Y-m-d'))
                                                ->orderBy('lessons.created_at', 'desc')->get(); 
                                                
                                                
            $data['today_start'] = $this->bookingModel->leftJoin('lessons', 'booking.lesson_id', '=', 'lessons.id')
                                                ->leftJoin('lesson_packages', 'booking.lesson_package_id', '=', 'lesson_packages.id')
                                                ->whereNull('lessons.deleted_at')
                                                ->where('booking.student_id', '=', session('id'))
                                                ->where('booking_date', '=', date('Y-m-d'))
                                                ->where('booking.teacher_accept_status', '=', '1')
                                                ->where('booking.status', '=', '1')
                                                ->orderBy('lessons.created_at', 'desc')->get(); 
                                                
                                                
            $data['cancelled'] = $this->bookingModel->leftJoin('lessons', 'booking.lesson_id', '=', 'lessons.id')
                                                ->leftJoin('lesson_packages', 'booking.lesson_package_id', '=', 'lesson_packages.id')
                                                ->whereNull('lessons.deleted_at')
                                                ->where('booking.student_id', '=', session('id'))
                                                ->where('booking.status', '=', '2')
                                                ->orderBy('lessons.created_at', 'desc')->get(); 
                                                
                                                
            $data['active_packages'] = '';
            $data['inactive_packages'] = '';
            
                                                
            return view('student.my-lesson',$data); 
        }
        
    }
    
    
    
    public function categoryWiseTagAjax($category){
        $category = urldecode($category);
        $tags = DB::table("lesson_category")
                        ->where("name",$category)
                        ->pluck('tag','tag');
        return json_encode($tags); 
    }
    
    
    
    public function add_lesson(request $request){
        
        $data['user'] = $this->registrationModel->where('deleted_at', '=', null)->where(['id'=>session('id')])->first(); 
        $data['lessonCategory'] = DB::table('lesson_category')->where('deleted_at', '=', null)->get()->unique('name');  
        //$data['currencies'] = DB::table('currency')->get();
        
        //echo "<pre>"; print_r($data['lessonCategory']); exit();
        
        if(count($request->all()) > 0) {   
            $validator = Validator::make($request->all(), [
                            'id' => 'required',
                            'role' => 'required',
                            'lesson_type' => 'required',
                            'lesson_name' => 'required',
                            'language_taught' => 'required',
                            'lesson_category' => 'required',
                        ]);
                        
            if ($validator->fails()) { 
                if($request->role=='2'){
                    return redirect('add-lesson')->withErrors($validator)->withInput(); 
                }else{
                    return redirect('student-dashboard')->withErrors($validator)->withInput(); 
                }
                
            }else{

                
                try{
                    
                    $lessonTagArr = array();
                    for ($i=0; $i < count($request->lesson_tag); $i++ )
                    {
                        if(!empty($request->lesson_tag)){
                            $lessonTagArr[] = $request->lesson_tag[$i];
                        }
                    }
                    
                    $lessonTags = implode(",",$lessonTagArr);
                    //echo "<pre>"; print_r($lessonTags); exit();
                    
                    $insertLessonData = [
                                        'user_id'=>session('id'),
                                        'type'=>$request->lesson_type,
                                        'name'=>ucfirst($request->lesson_name),
                                        'description'=>$request->lesson_description,
                                        'lesson_category'=>$request->lesson_category, 
                                        'lesson_tag'=> $lessonTags, 
                                        'language_taught'=>$request->language_taught,
                                        'student_languages_level_from'=>$request->student_languages_level_from,
                                        'student_languages_level_to'=>$request->student_languages_level_to,
                                        'created_at'=>date('Y-m-d H:i:s')
                                    ];
                                    
                    $lessionId = $this->lessonsModel->insertGetId($insertLessonData);
                    
                    //$packageArr = array();
                    for ($i=0; $i < count($request->package); $i++ )
                    {
                        if($request->individual_lesson[$i]!='' && $request->package[$i]!='' && $request->total[$i]!=''){ 
                            
                            $packageArr = [
                                                'lesson_id' => $lessionId,
                                                'individual_lesson' => $request->individual_lesson[$i],
                                                'time' => $request->time[$i],
                                                'package' => $request->package[$i],
                                                'total' => $request->total[$i],
                                                'created_at'=>date('Y-m-d H:i:s')
                                            ];
                                            
                            
                            $this->lessonPackagesModel->insertGetId($packageArr);
                        }
                    }
                    
                    
                    //$packageJson = json_encode($packageArr);   echo $packageJson; 
                            
                    //echo "<pre>"; print_r($insertLessonData); print_r($packageArr); exit(); 
                    
                    
                    
                    if($lessionId!='' && $request->role=='2'){
                        return redirect('add-lesson')->with('success','Lesson has been added successfully.');
                    }else{
                        return redirect('student-dashboard')->with('error','You are not authorized!'); 
                    }
                    
                }catch(Exception $e){
                    
                    if($request->role=='2'){
                        return redirect('add-lesson')->with('error','Please try again!');
                    }else{
                        return redirect('student-dashboard')->with('error','You are not authorized! Please try again!');
                    }
                }
                
                
            }
            
        }else{
            
            if($data['user']->role=='2'){
                return view('teacher.add-lesson',$data);
            }else{
                return view('student.dashboard',$data);
            }
        }
    }
    
    
    
    public function lesson_detail(Request $request){
        $data['title']="Lesson Detail";
        $data['breadcrumb']="lesson detail";
        
        $lessonData = $this->lessonsModel->where(['id'=>$request->lesson_id])->first();
        
        $html = '';
        if($lessonData){
            $level = $lessonData->student_languages_level_from.' - '.$lessonData->student_languages_level_to;
            
            $html .= '<div class="form-row"><div class="form-group col-md-12"><p>'.$lessonData->name.'<p/></div></div>';
            $html .= '<div class="form-row">
                       <div class="col-lg-4 col-md-4 col-sm-4 col-12"><h4>Language</h4> <span>'.$lessonData->language_taught.'</span></div>
                       <div class="col-lg-4 col-md-4 col-sm-4 col-12"><h4>Category </h4> <span>'.$lessonData->lesson_category.'</span></div>
                       <div class="col-lg-4 col-md-4 col-sm-4 col-12"><h4>Level</h4> <span>'.$level.'</span></div>
                     </div>';
                     
            $html .= '<div class="form-row">
                      <div class="col-lg-6 col-12 languages-box">
                       <h3>Focuse Areas</h3>
                       <ul><li><a href="javascript:void(0);">'.$lessonData->lesson_tag.'</a></li></ul>
                       </div>
                     </div>';
                     
            $html .= '<div class="form-row"><div class="col-lg-12 col-12 p-text">
                         <p>'.$lessonData->description.'</p>  
            		  </div></div>'; 
            
            $lessonPackages = $this->lessonPackagesModel->where(['lesson_id'=>$lessonData->id])->get(); 
            
            $html .= '<div class="form-row price-boxs">
                          <div class="col-lg-12 col-12">
                             <h2>Packages</h2></div>';
                             
            foreach($lessonPackages as $v){
                $html .= '<div class="col-lg-3 col-md-6 col-sm-6 col-12">
                             <div class="r-box">
                               <p><i class="fa fa-clock-o" aria-hidden="true"></i> '.$v->time.' </p>
                               <h3>USD '.number_format($v->total,2).' </h3>
                             </div>
                            </div>';
            }
                            
                                 
            $html .= '</div>';
            
            $html .= '<div class="form-row">
                        <div class="col-lg-12 col-12 notice">
                            <p>NOTICE: Some teachers may include a 5 minute break in the lesson time</p>
                        </div>
                     </div>';
			
        }else{
            $html .= '<div class="form-row"><div class="form-group col-md-12"><p>No data found!!<p/></div></div>'; 
        }
        
        return $html;
    }
    
    
    public function delete_lesson($id){  
        $lessonData = $this->lessonsModel->where('id',$id)->first();
        if($lessonData){ 
            $this->lessonsModel->where(['id'=>$id])->delete();
            return redirect('lesson-management')->with('success','Lesson has been deleted successfully.');
        }else{
            return redirect('lesson-management')->with('error','Lesson not found!');
        }
        
    }
    
    
    
    public function get_lesson_detail($id){
        $data['title']="Lesson Detail";
        $data['breadcrumb']="Lesson Detail";
        
        $lesson_id = $id;
        $lessonData = $this->lessonsModel->where(['id'=>$lesson_id])->first();
        
        //echo "<pre>"; print_r($lessonData); exit();
        
        $teacher_id = $lessonData->user_id;
        $teacherData = $this->registrationModel->where(['id'=>$teacher_id])->first(); 
        
        $exists = file_exists( storage_path() . '/app/user_photo/' . $teacherData->profile_photo );
        
        if($exists && $teacherData->profile_photo!=''){
            $photo = url('storage/app/user_photo/'.$teacherData->profile_photo);
        }else{
            $photo = Asset("public/assets/dist/img/transparent.png");
        }
        
        $flag = '';
        if($teacherData->country_living_in!=''){
            $countryFlagData = DB::table('countries')->where('name', '=', $teacherData->country_living_in)->first(); 
            $flag = strtolower($countryFlagData->sortname);
            
        }else{
            $getVisitorCountry = getVisitorCountry();
            $countryFlagData = DB::table('countries')->where('name', '=', $getVisitorCountry)->first(); 
            $flag = strtolower($countryFlagData->sortname);
            
        }
        
        if($flag){
            $country_flag = asset('public/frontendassets/images/flags/'.$flag.'.png');
        }else{
            $country_flag = asset('public/frontendassets/images/flage.png');
        }
        
    
    
        $getLoggedIndata = getLoggedinData();
        $data['booking_id'] = '';
        $data['student_id'] = '';
        $data['booking_status'] = '';
        $data['booking_date'] = '';
        $data['booking_time'] = '';
        $data['lesson_started_at'] = '';
        $data['lesson_completed_at'] = '';
        $data['lesson_count'] = '';
        $data['feedback_rating_count'] = '';
        
        //echo $teacher_id." >> ".$lesson_id." :: ".$getLoggedIndata->id; exit();
        
        if($getLoggedIndata->role=='1'){
            $bookingData = $this->bookingModel->where('status', '=', '3')->where('teacher_id', '=', $teacher_id)->where('student_id', '=', $getLoggedIndata->id)
                                            ->where('lesson_id', '=', $lesson_id)
                                            ->orderBy('created_at', 'desc')->first();
                                            
            $lesson_count = $this->bookingModel->where('status', '=', '3')->where('student_id', '=', $getLoggedIndata->id)
                                                ->where('lesson_id', '=', $lesson_id)->count(); 
            
            
            if(!$bookingData){
                $bookingData = $this->bookingModel->where('teacher_id', '=', $teacher_id)->where('student_id', '=', $getLoggedIndata->id)
                                            ->where('lesson_id', '=', $lesson_id)
                                            ->orderBy('created_at', 'desc')->first(); 
                                            
                
            }
            
            
            $feedbackRatingData = $this->feedbackRatingModel->where('teacher_id', '=', $bookingData->teacher_id)->where('student_id', '=', $getLoggedIndata->id)
                                            ->where('booking_id', '=', $bookingData->id)
                                            ->where('lesson_id', '=', $bookingData->lesson_id)
                                            ->orderBy('created_at', 'desc')->count(); 
            
            //echo "<pre>"; print_r($bookingData); exit();   
            
            
            $data['booking_id'] = $bookingData->id;
            $data['student_id'] = $bookingData->student_id;
            $data['booking_status'] = $bookingData->status;
            $data['bookingDate'] = $bookingData->booking_date;
            $data['booking_date'] = date('d M Y',strtotime($bookingData->booking_date));
            $data['booking_time'] = date('h:i a',strtotime($bookingData->booking_time));
            $data['lesson_started_at'] = date('h:i a',strtotime($bookingData->lesson_started_at));
            $data['lesson_completed_at'] = date('h:i a',strtotime($bookingData->lesson_completed_at));
            
            $data['lesson_log'] = $this->lessonLogModel->where('lesson_id', '=', $lesson_id)
                                                        ->where('teacher_id', '=', $teacher_id)
                                                        ->where('student_id', '=', $getLoggedIndata->id)
                                                        ->where('booking_id', '=', $bookingData->id)
                                                        ->orderBy('created_at', 'desc')->get(); 
            
            
            if($lesson_count){
                $data['lesson_count'] = $lesson_count.' lessons learned'; 
            }
            
            $data['feedback_rating_count'] = $feedbackRatingData;
        }
        
        if($getLoggedIndata->role=='2'){
            $bookingData = $this->bookingModel->where('status', '=', '3')->where('teacher_id', '=', $getLoggedIndata->id)
                                            ->where('lesson_id', '=', $lesson_id)
                                            ->orderBy('created_at', 'desc')->first(); 
                                            
            $lesson_count = $this->bookingModel->where('status', '=', '3')->where('teacher_id', '=', $getLoggedIndata->id)
                                                ->where('lesson_id', '=', $lesson_id)->count(); 
                                                
                   
            
            if(!$bookingData){
                $bookingData = $this->bookingModel->where('teacher_id', '=', $getLoggedIndata->id)
                                            ->where('lesson_id', '=', $lesson_id)
                                            ->orderBy('created_at', 'desc')->first(); 
            }
            
            
            $feedbackRatingData = $this->feedbackRatingModel->where('teacher_id', '=', $getLoggedIndata->id)->where('student_id', '=', $bookingData->student_id)
                                            ->where('booking_id', '=', $bookingData->id)
                                            ->where('lesson_id', '=', $bookingData->lesson_id)
                                            ->orderBy('created_at', 'desc')->count(); 
                                            
            
            $data['booking_id'] = $bookingData->id;
            $data['student_id'] = $bookingData->student_id;
            $data['booking_status'] = $bookingData->status;
            $data['bookingDate'] = $bookingData->booking_date;
            $data['booking_date'] = date('d M Y',strtotime($bookingData->booking_date));
            $data['booking_time'] = date('h:i a',strtotime($bookingData->booking_time));
            $data['lesson_started_at'] = date('h:i a',strtotime($bookingData->lesson_started_at));
            $data['lesson_completed_at'] = date('h:i a',strtotime($bookingData->lesson_completed_at));
            
            $data['lesson_log'] = $this->lessonLogModel->where('lesson_id', '=', $lesson_id)
                                                        ->where('teacher_id', '=', $getLoggedIndata->id)
                                                        ->where('booking_id', '=', $bookingData->id)
                                                        ->orderBy('created_at', 'desc')->get(); 
                                                            
            
            if($lesson_count){
                $data['lesson_count'] = $lesson_count.' lessons taught'; 
            }
            
            $data['feedback_rating_count'] = $feedbackRatingData;
        }
        
        
        $data['teacher_name'] = $teacherData->name;
        $data['teacher_photo'] = $photo;
        $data['teacher_country_flag'] = $country_flag;
        $data['teacher_communication_tool'] = $teacherData->video_conferencing_platform; 
        $data['teacher_communication_account_id'] = $teacherData->user_account_id; 
                                                
        //echo "<pre>"; print_r($bookingData); exit();
        
        if($lessonData){
            $data['lesson'] = $lessonData;  
        }else{
            return redirect('/')->with('error','Lesson detail not found!'); 
        }
        return view('teacher.lesson-detail',$data);

    }
    
    
    
    
    
    
    public function accept_lesson($id){
        $getLoggedIndata = getLoggedinData();
        $booking = $this->bookingModel->where('id', '=', $id)->first();
                                                
        if($booking){
            $updateData=[];
            $updateData['updated_at'] = date('Y-m-d H:i:s');
            
            if($getLoggedIndata->role=='1'){
                $updateData['student_accept_status'] = '1'; 
            }
            
            if($getLoggedIndata->role=='2'){
                $updateData['teacher_accept_status'] = '1'; 
            }
            
            try{
                $this->bookingModel->where('id',$id)->update($updateData); 
                
                if($getLoggedIndata->role=='1'){
                    $action = 'Lesson request accepted by student: '.$getLoggedIndata->name;
                }
                if($getLoggedIndata->role=='2'){
                    $action = 'Lesson request accepted by teacher: '.$getLoggedIndata->name;
                }
                
                $insertLessonLogData = [
                                            'lesson_id'=>$booking->lesson_id,
                                            'lesson_package_id'=>$booking->lesson_package_id,
                                            'teacher_id'=>$booking->teacher_id,
                                            'student_id'=>$booking->student_id,
                                            'booking_id'=>$id,
                                            'action'=>$action,
                                            'lesson_accept_reject'=>'1',
                                            'created_at'=>date('Y-m-d H:i:s')
                                        ];

                $lessonLogId = $this->lessonLogModel->insertGetId($insertLessonLogData);
                
                if($getLoggedIndata->role=='1' || $getLoggedIndata->role=='2'){
                    return redirect('my-lesson')->with('success','Booking has been accepted successfully.');
                }
            }catch(Exception $e){
                if($getLoggedIndata->role=='1' || $getLoggedIndata->role=='2'){
                    return redirect('my-lesson')->with('error','Please try again!');
                }
            }
            
            
        }else{
            if($getLoggedIndata->role=='1' || $getLoggedIndata->role=='2'){
                return redirect('my-lesson')->with('error','Booking not found!');
            }
        }
        
    }
    
    
    
    public function decline_lesson($id){
        $getLoggedIndata = getLoggedinData();
        $booking = $this->bookingModel->where('id', '=', $id)->first();
                                                
        if($booking){
            $updateData=[];
            $updateData['updated_at'] = date('Y-m-d H:i:s');
            
            if($getLoggedIndata->role=='1'){
                $updateData['student_accept_status'] = '2'; 
            }
            
            if($getLoggedIndata->role=='2'){
                $updateData['teacher_accept_status'] = '2'; 
            }
            
            try{
                $this->bookingModel->where('id',$id)->update($updateData); 
                
                if($getLoggedIndata->role=='1'){
                    $action = 'Lesson request declined by student: '.$getLoggedIndata->name;
                }
                if($getLoggedIndata->role=='2'){
                    $action = 'Lesson request declined by teacher: '.$getLoggedIndata->name;
                }
                
                $insertLessonLogData = [
                                            'lesson_id'=>$booking->lesson_id,
                                            'lesson_package_id'=>$booking->lesson_package_id,
                                            'teacher_id'=>$booking->teacher_id,
                                            'student_id'=>$booking->student_id,
                                            'booking_id'=>$id,
                                            'action'=>$action,
                                            'lesson_accept_reject'=>'2',
                                            'created_at'=>date('Y-m-d H:i:s')
                                        ];

                $lessonLogId = $this->lessonLogModel->insertGetId($insertLessonLogData);
                
                if($getLoggedIndata->role=='1' || $getLoggedIndata->role=='2'){
                    return redirect('my-lesson')->with('success','Booking has been declined successfully.');
                }
            }catch(Exception $e){
                if($getLoggedIndata->role=='1' || $getLoggedIndata->role=='2'){
                    return redirect('my-lesson')->with('error','Please try again!');
                }
            }
            
            
        }else{
            if($getLoggedIndata->role=='1' || $getLoggedIndata->role=='2'){
                return redirect('my-lesson')->with('error','Booking not found!');
            }
        }
        
    }
    
    
    
    public function enter_classroom($id){
        $getLoggedIndata = getLoggedinData();
        $booking = $this->bookingModel->where('id', '=', $id)->first();
                                                
        if($booking){
            $updateData=[];
            $updateData['updated_at'] = date('Y-m-d H:i:s'); 
            
            $updateData['lesson_started_at'] = date('Y-m-d H:i:s');
            
            try{
                $this->bookingModel->where('id',$id)->update($updateData); 
                
                if($getLoggedIndata->role=='1'){
                    $action = 'Student: '.$getLoggedIndata->name.' has entered the classroom and lesson added start time.';
                }
                if($getLoggedIndata->role=='2'){
                    $action = 'Teacher: '.$getLoggedIndata->name.' has entered the classroom and lesson added start time.';
                }
                
                $insertLessonLogData = [
                                            'lesson_id'=>$booking->lesson_id,
                                            'lesson_package_id'=>$booking->lesson_package_id,
                                            'teacher_id'=>$booking->teacher_id,
                                            'student_id'=>$booking->student_id,
                                            'booking_id'=>$id,
                                            'action'=>$action,
                                            'lesson_accept_reject'=>'2',
                                            'created_at'=>date('Y-m-d H:i:s')
                                        ];

                $lessonLogId = $this->lessonLogModel->insertGetId($insertLessonLogData);
                
                if($getLoggedIndata->role=='1' || $getLoggedIndata->role=='2'){
                    return redirect('my-lesson')->with('success','You have successfully started the lesson.');
                }
            }catch(Exception $e){
                if($getLoggedIndata->role=='1' || $getLoggedIndata->role=='2'){
                    return redirect('my-lesson')->with('error','Please try again!');
                }
            }
            
            
        }else{
            if($getLoggedIndata->role=='1' || $getLoggedIndata->role=='2'){
                return redirect('my-lesson')->with('error','Booking not found!');
            }
        }
        
    }
    
    
    
    public function update_lesson_completion_time($id){
        $getLoggedIndata = getLoggedinData();
        $booking = $this->bookingModel->where('id', '=', $id)->first();
                                                
        if($booking){

            $packageData =  $this->lessonPackagesModel->where('lesson_id', '=', $booking->lesson_id)->where('id', '=', $booking->lesson_package_id)->first(); 
            
            if($packageData){
                $totalTime = explode(' ',$packageData->time); //echo $totalTime[0];
                
                $startDateTime = $booking->booking_date." ".$booking->booking_time; 
                
                $endTime = date('H:i:s', strtotime($booking->booking_time.'+'.$totalTime[0].' minute'));
                
                $endDateTime = $booking->booking_date." ".$endTime; 
                
                try{
                    
                    $updateData=[];
                    $updateData['updated_at'] = date('Y-m-d H:i:s');
                    
                    $updateData['lesson_completed_at'] = $endDateTime;
                    
                    $this->bookingModel->where('id',$id)->update($updateData); 
                    
                    if($getLoggedIndata->role=='1'){
                        $action = 'Student: '.$getLoggedIndata->name.' has confirmed the lesson completion time.';
                    }
                    if($getLoggedIndata->role=='2'){
                        $action = 'Teacher: '.$getLoggedIndata->name.' has confirmed the lesson completion time.';
                    }
                    
                    $insertLessonLogData = [
                                                'lesson_id'=>$booking->lesson_id,
                                                'lesson_package_id'=>$booking->lesson_package_id,
                                                'teacher_id'=>$booking->teacher_id,
                                                'student_id'=>$booking->student_id,
                                                'booking_id'=>$id,
                                                'action'=>$action,
                                                'lesson_accept_reject'=>'0',
                                                'created_at'=>date('Y-m-d H:i:s')
                                            ];
    
                    $lessonLogId = $this->lessonLogModel->insertGetId($insertLessonLogData);
                    
                    if($lessonLogId && $getLoggedIndata->role=='1'){
                        $booking_amount = $booking->booking_amount;
                        
                        
                        
                        $teacherData = $this->registrationModel->where('id', '=', $booking->teacher_id)->first(); 
                        if($teacherData){
                            $teacher_wallet_amount = $teacherData->teacher_wallet_amount;
                            $newTeacherWalletAmount = ($teacher_wallet_amount + $booking_amount);
                            
                            $updateTeacherData=[];
                            $updateTeacherData['updated_at'] = date('Y-m-d H:i:s');  
                        
                            $updateTeacherData['teacher_wallet_amount'] = $newTeacherWalletAmount; 
                            
                            $this->registrationModel->where('id',$booking->teacher_id)->update($updateTeacherData); 
                        }
                        
                        $studentData = $this->registrationModel->where('id', '=', $booking->student_id)->first(); 
                        if($studentData){
                            $student_wallet_amount = $teacherData->student_wallet_amount;
                            $newStudentWalletAmount = ($student_wallet_amount - $booking_amount);
                            
                            $updateStudentData=[];
                            $updateStudentData['updated_at'] = date('Y-m-d H:i:s');  
                            $updateStudentData['student_wallet_amount'] = $newStudentWalletAmount; 
                            
                            $this->registrationModel->where('id',$booking->student_id)->update($updateStudentData); 
                        }
                    }
                    
                    if($getLoggedIndata->role=='1' || $getLoggedIndata->role=='2'){
                        return redirect('my-lesson')->with('success','You have successfully confirmed the lesson completion.');
                    }
                }catch(Exception $e){
                    if($getLoggedIndata->role=='1' || $getLoggedIndata->role=='2'){
                        return redirect('my-lesson')->with('error','Please try again!');
                    }
                }
            }
            
            //echo "<br>".$booking->lesson_package_id." :: ".$booking->booking_time." end:: ".$endDateTime;  exit();
            
            
            
            
        }else{
            if($getLoggedIndata->role=='1' || $getLoggedIndata->role=='2'){
                return redirect('my-lesson')->with('error','Booking not found!');
            }
        }
        
    }
    
    
    
    
    public function change_lesson_date($id){
        $getLoggedIndata = getLoggedinData();
        
        $data['booking'] = $this->bookingModel->where('id', '=', $id)->first();
        
        $lessonData = $this->lessonsModel->where('id', '=', $data['booking']->lesson_id)->first();
        
        if($getLoggedIndata->role=='2'){
            $student_id = $data['booking']->student_id;
            $studentData = $this->registrationModel->where(['id'=>$student_id])->first(); 
        
            $data['name'] = $studentData->name;
        }else{
            $teacher_id = $data['booking']->teacher_id;
            $teacherData = $this->registrationModel->where(['id'=>$teacher_id])->first(); 
        
            $data['name'] = $teacherData->name;
        }
        
        $data['lesson_name'] = $lessonData->name; 
        $data['lesson_category'] = $lessonData->lesson_category; 
        $data['lesson_tag'] = $lessonData->lesson_tag; 
        $data['language_taught'] = $lessonData->language_taught; 
        
        if($getLoggedIndata->role=='1' || $getLoggedIndata->role=='2'){
            return view('teacher.change-lesson-date',$data);
        }
    }
    
    
    
    public function update_new_lesson_date(request $request){
        //echo "<pre>"; print_r($_POST); exit();
        
        $getLoggedIndata = getLoggedinData();
        
        $bookingData = $this->bookingModel->where('id', '=', $request->booking_id)
                                        ->orderBy('created_at', 'desc')->first();
                                            
        if($bookingData){
            $updateData=[];
            $updateData['updated_at'] = date('Y-m-d H:i:s');
            
            $updateData['booking_date'] = $request->new_booking_date;  
            $updateData['booking_time'] = $request->new_booking_time;
            $updateData['status'] = '4'; 
            
            try{
                
                $this->bookingModel->where('id',$request->booking_id)->update($updateData);
                
                if($getLoggedIndata->role=='1'){
                    $action = 'Booking datetime has been changed from '.$bookingData->booking_date.' to '.$request->new_booking_date.' and '.$bookingData->booking_time.' to '.$request->new_booking_time.' by student: '.$getLoggedIndata->name;
                }
                if($getLoggedIndata->role=='2'){
                    $action = 'Booking datetime has been changed from '.$bookingData->booking_date.' to '.$request->new_booking_date.' and '.$bookingData->booking_time.' to '.$request->new_booking_time.' by teacher: '.$getLoggedIndata->name;
                }
                
                $insertLessonLogData = [
                                            'lesson_id'=>$bookingData->lesson_id,
                                            'lesson_package_id'=>$bookingData->lesson_package_id,
                                            'teacher_id'=>$bookingData->teacher_id,
                                            'student_id'=>$bookingData->student_id,
                                            'booking_id'=>$bookingData->id,
                                            'action'=>$action,
                                            'lesson_accept_reject'=>'0',
                                            'created_at'=>date('Y-m-d H:i:s')
                                        ];

                $lessonLogId = $this->lessonLogModel->insertGetId($insertLessonLogData);
                
                // Send Email =========================================================
                
                if($getLoggedIndata->role=='1'){
                    
                    $user = $this->registrationModel->where('deleted_at', '=', null)->where('id', '=', $bookingData->student_id)->first();  
                    $studentName = $user->name;
                    
                    $teacherData = $this->registrationModel->where('deleted_at', '=', null)->where('id', '=', $bookingData->teacher_id)->first(); 
                    $teacherName = $teacherData->name;
                    $teacherEmail = $teacherData->email;
                
                    $lessonData = $this->lessonsModel->where('deleted_at', '=', null)->where('id', '=', $bookingData->lesson_id)->first(); 
                    $lessonName = $lessonData->name;
                    $lessonID = $lessonData->id;
                    $lessonDateTime = date('d M Y',strtotime($request->new_booking_date))."/".$request->new_booking_time; 
                    $lessonPrice = number_format($bookingData->booking_amount,2).' USD';
                    $lessonUrl = url('/lesson-detail/'.$lessonData->id);
                    
                
                    $subject = $getLoggedIndata->name.' has requested to reschedule a lesson'; 
	                $message = 'A student has requested to change the scheduled time/date of one of their lessons. Please see details below.';
	                
	                $details = [
	                        'to' => $teacherEmail,
	                        'from' => env('MAIL_FROM_ADDRESS'),
	                        'subject' => $subject,
	                        'receiver' => ucfirst($teacherName),
	                        'sender' => env('MAIL_FROM_NAME'), 
	                        'msg'=>$message,
	                        'student_name'=>$studentName,
	                        'course_name'=>$lessonName,
	                        'lesson_id'=>$lessonID,
	                        'lesson_date'=>$lessonDateTime,
	                        'lesson_price'=>$lessonPrice,
	                        'lesson_url'=>$lessonUrl
	                    ];

	               Mail::to($teacherEmail)->send(new LessonBooking($details));
	                   
                }
                 
                
                return redirect('change-lesson-date/'.$request->booking_id)->with('success','Scheduled date has been changed successfully.');
                
            }catch(Exception $e){
                return redirect('change-lesson-date/'.$request->booking_id)->with('error','Please try again!'); 
            }
            
            
        }else{
            return redirect('change-lesson-date/'.$request->booking_id)->with('error','Booking not found!'); 
        }
    }
    
    
    
    
    public function lesson_packages(){
        
        $getLoggedIndata = getLoggedinData();
        
        if($getLoggedIndata->role=='2'){
            $data['active_packages'] = $this->lessonsModel->leftJoin('lesson_packages', 'lessons.id', '=', 'lesson_packages.lesson_id')
                                                ->select(DB::raw('lessons.*,lesson_packages.time,lesson_packages.individual_lesson,lesson_packages.package,lesson_packages.total,lesson_packages.created_at,lessons.lesson_tag,lessons.language_taught,lessons.student_languages_level_from,lessons.student_languages_level_to'))
                                                ->whereNull('lessons.deleted_at')
                                                ->whereNull('lesson_packages.deleted_at')
                                                ->where('lessons.user_id', '=', session('id'))
                                                ->orderBy('lesson_packages.created_at', 'desc')->get();
                                                
            
            $data['inactive_packages'] = $this->lessonsModel->leftJoin('lesson_packages', 'lessons.id', '=', 'lesson_packages.lesson_id')
                                                ->select(DB::raw('lessons.*,lesson_packages.time,lesson_packages.individual_lesson,lesson_packages.package,lesson_packages.total,lesson_packages.created_at,lessons.lesson_tag,lessons.language_taught,lessons.student_languages_level_from,lessons.student_languages_level_to'))
                                                ->whereNull('lessons.deleted_at')
                                                ->whereNotNull('lesson_packages.deleted_at')
                                                ->where('lessons.user_id', '=', session('id'))
                                                ->orderBy('lesson_packages.created_at', 'desc')->get();
            
            
            return view('teacher.lesson-packages',$data);
            
        }else{
            return redirect('student-dashboard');
        }
        
    }
    
    
    
    /*public function fetch_communication_tool($studentID){
        $user = $this->registrationModel->where('deleted_at', '=', null)->where('status', '=', '1')->where(['id'=>$studentID])->first(); 
        return $user->video_conferencing_platform;
    }
    
    public function fetch_communication_tool_id($studentID){
        $user = $this->registrationModel->where('deleted_at', '=', null)->where('status', '=', '1')->where(['id'=>$studentID])->first(); 
        return $user->user_account_id;
    }*/
    
    
    public function fetch_lesson_name($lessonID){
        $lesson = $this->lessonModel->where('deleted_at', '=', null)->where(['id'=>$lessonID])->first(); 
        return $lesson->name;
    }
    
    public function fetch_lesson_packages($lessonID){
        $packages = $this->lessonPackagesModel->where('deleted_at', '=', null)->where('lesson_id', '=', $lessonID)->get(); 
        
        $html = '';
        foreach($packages as $val){
            $html .= '<div class="col-lg-3 col-md-3 col-sm-6">';
            $html .= '<div class="slot-box">';
            $html .= '<p>'.$val->time.'</p>';
            $html .= '<h4>USD '.number_format($val->total,2).'</h4>';
            $html .= '<input class="form-check-input durationClass" type="radio" name="package_id" id="" value="'.$val->id.'" data-duration="'.$val->time.'" data-price="'.number_format($val->total,2).'" checked="">'; 
            $html .= '</div>';
            $html .= '</div>';
        }
        
        echo $html;
    }
    
    
    public function fetch_student_purchased_packages($studentID,$invitationType){
        $packages = $this->bookingModel->where('deleted_at', '=', null)->where('student_id', '=', $studentID)->get(); 
        //echo "<pre>"; print_r($packages); exit();
        
        $packageIds = array();
        foreach($packages as $val){
            $packageIds[$val->lesson_package_id] = $val->lesson_package_id;
        }
        
        $html = '';
        if(count($packageIds)>0){
            foreach($packageIds as $val){
                $packageData = $this->lessonPackagesModel->where('deleted_at', '=', null)->where('id', '=', $val)->first(); 
                
                $html .= '<div class="col-lg-3 col-md-3 col-sm-6">';
                $html .= '<div class="slot-box">';
                $html .= '<p>'.$packageData->time.'</p>';
                $html .= '<h4>USD '.number_format($packageData->total,2).'</h4>';
                $html .= '<input class="form-check-input durationClass" type="radio" name="package_id" id="" value="'.$packageData->id.'" data-duration="'.$packageData->time.'" data-price="'.number_format($packageData->total,2).'" checked="">'; 
                $html .= '</div>';
                $html .= '</div>';
            }
        }
        
        echo $html;
    }
    
    
    public function fetch_student_purchased_timing($studentID,$packageID){ //echo $packageID; exit(); 
        $packages = $this->bookingModel->where('deleted_at', '=', null)->where('student_id', '=', $studentID)->where('lesson_package_id', '=', $packageID)->first(); 
        //echo "<pre>"; print_r($packages); exit();
        
        if($packages){
            echo $packages->booking_time;
        }
        
    }
    
    public function fetch_student_purchased_date($studentID,$packageID){ //echo $packageID; exit(); 
        $packages = $this->bookingModel->where('deleted_at', '=', null)->where('student_id', '=', $studentID)->where('lesson_package_id', '=', $packageID)->first(); 
        //echo "<pre>"; print_r($packages); exit();
        
        if($packages){
            echo $packages->booking_date;
        }
        
    }
    
    public function fetch_student_purchased_communication_tool($studentID,$packageID){ 
        $packages = $this->bookingModel->where('deleted_at', '=', null)->where('student_id', '=', $studentID)->where('lesson_package_id', '=', $packageID)->first(); 
        //echo "<pre>"; print_r($packages); exit();
        
        if($packages){
            echo $packages->communication_tool;
        }
        
    }
    
    public function fetch_student_purchased_communication_tool_id($studentID,$packageID){ 
        $packages = $this->bookingModel->where('deleted_at', '=', null)->where('student_id', '=', $studentID)->where('lesson_package_id', '=', $packageID)->first(); 
        //echo "<pre>"; print_r($packages); exit();
        
        if($packages){
            echo $packages->communication_account_id;
        }
        
    }
    
    public function fetch_student_purchased_amount($studentID,$packageID){ 
        $packages = $this->bookingModel->where('deleted_at', '=', null)->where('student_id', '=', $studentID)->where('lesson_package_id', '=', $packageID)->first(); 
        //echo "<pre>"; print_r($packages); exit();
        
        if($packages){
            echo $packages->booking_amount;
        }
        
    }
    
    public function fetch_student_purchased_language($studentID,$packageID){ 
        $packages = $this->lessonPackagesModel->where('deleted_at', '=', null)->where('id', '=', $packageID)->first(); 
        //echo "<pre>"; print_r($packages); exit();
        
        if($packages){
            $lesson_id = $packages->lesson_id;
            
            $lessonData = $this->lessonsModel->where('id', '=', $packages->lesson_id)->first();
            
            echo $lessonData->language_taught;
        }
        
    }
    
    public function fetch_student_purchased_lesson($studentID,$packageID){ 
        $packages = $this->lessonPackagesModel->where('deleted_at', '=', null)->where('id', '=', $packageID)->first(); 
        //echo "<pre>"; print_r($packages); exit();
        
        if($packages){
            echo $packages->lesson_id;
        }
        
    }
    
    
    public function send_lesson_invitation(request $request){
        
        $getLoggedIndata = getLoggedinData();

        $validator = Validator::make($request->all(), [
                                'student_id' => 'required',
                                'type' => 'required',
                                //'language_taught'=>'required',
                                //'lesson_id'=>'required',
                                'communication_tool' => 'required',
                                'communication_tool_id'=>'required',
                                'schedule_time'=>'required',
                                'i_date'=>'required',
                                'from_time'=>'required',
                                'to_time'=>'required',
                            ]);
                            
        if ($validator->fails()) { 
            
            if($getLoggedIndata->role=='2'){
                return redirect('my-lesson')->withErrors($validator)->withInput();
            }else{
                return redirect('student-dashboard')->withErrors($validator)->withInput(); 
            }
                
        }else{ 
            
            //echo "<pre>"; print_r($_POST); exit(); 
            
            $invitationExistCheck = $this->lessonInvitationModel->where('teacher_id', '=', session('id'))
                                                                ->where('student_id', '=', $request->student_id)
                                                                ->where('booking_date', '=', $request->i_date)
                                                                ->where('from_time', '=', $request->from_time)->get(); 
            

            if(count($invitationExistCheck)>0){
                return redirect('my-lesson')->with('error','You have already sent an invitation to the student on same date & time!!');
                
            }
            
            $insertLessonLogData = [
                                        'teacher_id'=>session('id'),
                                        'student_id'=>$request->student_id,
                                        'type'=>$request->type,
                                        'language'=>$request->language_taught,
                                        'lesson_id'=>$request->lesson_id,
                                        'lesson_package_id'=>$request->package_id,
                                        'communication_tool'=>$request->communication_tool,
                                        'communication_account_id'=>$request->communication_tool_id,
                                        'offer_price'=>$request->offer_price,
                                        'booking_date'=>$request->i_date,
                                        'from_time'=>$request->from_time,
                                        'to_time'=>$request->to_time,
                                        'schedule_time'=>$request->schedule_time,
                                        'status'=>'0',
                                        'created_at'=>date('Y-m-d H:i:s')
                                    ];

            $invitationId = $this->lessonInvitationModel->insertGetId($insertLessonLogData);
            
            if($getLoggedIndata->role=='2'){
                if($invitationId!=''){
                    
                    // Send Email =========================================================
                            
                    $user = $this->registrationModel->where('deleted_at', '=', null)->where('id', '=', $request->student_id)->first();  
                    $studentName = $user->name;
                    $studentEmail = $user->email;
                    
                    $teacher = $this->registrationModel->where('deleted_at', '=', null)->where('id', '=', session('id'))->first();  
                    $teacherName = $teacher->name;
                    $teacherEmail = $teacher->email;
                        
                    $lessonData = $this->lessonsModel->where('deleted_at', '=', null)->where('id', '=', $request->lesson_id)->first(); 
                    $lessonName = $lessonData->name;
                    $lessonID = $lessonData->id;
                    $lessonDateTime = date('d M Y',strtotime($request->i_date))."/".$request->from_time; 
                    $lessonPrice = number_format($request->offer_price,2).' USD';
                    $lessonUrl = url('/lesson-detail/'.$lessonData->id);
                        
	                $subject = 'Lesson invitation from '.$teacherName; 
	                $message = 'A teacher has sent a lesson invitation to you. Please click the button below to accept or modify the lesson request.';
	                    
                    $details = [
                        'to' => $studentEmail,
                        'from' => env('MAIL_FROM_ADDRESS'),
                        'subject' => $subject,
                        'receiver' => ucfirst($studentName),
                        'sender' => env('MAIL_FROM_NAME'), 
                        'msg'=>$message,
                        'student_name'=>$studentName,
                        'course_name'=>$lessonName,
                        'lesson_id'=>$lessonID,
                        'lesson_date'=>$lessonDateTime,
                        'lesson_price'=>$lessonPrice,
                        'lesson_url'=>$lessonUrl
                    ];

                    Mail::to($teacherEmail)->send(new LessonBooking($details));
	                    
                    return redirect('my-lesson')->with('success','Lesson invitation has been sent successfully.'); 
                }else{
                    return redirect('my-lesson')->with('error','Please try again!'); 
                }
                
            }else{
                return redirect('student-dashboard')->with('error','You are not authorized!'); 
            }

                
        }
        
    }
    
    
    
    
    
    
    
    public function accept_lesson_invitation($id){
        $getLoggedIndata = getLoggedinData();
        $invitation = $this->lessonInvitationModel->where('id', '=', $id)->first();
                                                
        if($invitation){
            $updateData=[];
            $updateData['updated_at'] = date('Y-m-d H:i:s');
            
            if($getLoggedIndata->role=='1'){
                $updateData['status'] = '1';
                
                try{
                    $this->lessonInvitationModel->where('id',$id)->update($updateData); 
                    
                    $bookingExistCheck = $this->bookingModel->where('teacher_id', '=', $invitation->teacher_id)
                                                    ->where('student_id', '=', session('id'))
                                                    ->where('booking_date', '=', $invitation->booking_date)
                                                    ->where('booking_time', '=', $invitation->from_time)->get(); 
                    
                    $booking_id = $invitation->id;
                    if(count($bookingExistCheck)==0){
                        
                        $price = $invitation->offer_price;
                        if($invitation->offer_price==''){
                            $packageData = $this->lessonPackagesModel->where('lesson_id', '=', $invitation->lesson_id)->where('id', '=', $invitation->lesson_package_id)->first(); 
                            $price = $packageData->total;
                        }
                        
                        $insertData = [
                            'teacher_id'=>$invitation->teacher_id,
                            'lesson_id'=>$invitation->lesson_id,
                            'lesson_package_id'=>$invitation->lesson_package_id, 
                            'booking_date'=>$invitation->booking_date, 
                            'booking_time'=>$invitation->from_time,
                            'booking_amount'=>$price,
                            'communication_tool'=>$invitation->communication_tool,
                            'communication_account_id'=>$invitation->communication_account_id,
                            'student_id'=>session('id'),
                            'status'=>'1',
                            'teacher_accept_status'=>'1',
                            'student_accept_status'=>'1',
                            'created_at'=>date('Y-m-d H:i:s')
                        ];
                
                        $booking_id = $this->bookingModel->insertGetId($insertData);
                    }
                                                    
                                                    
                    
                    $action = 'Lesson invitation has been accepted by student: '.$getLoggedIndata->name;
                    
                    
                    $insertLessonLogData = [
                                                'lesson_id'=>$invitation->lesson_id,
                                                'lesson_package_id'=>$invitation->lesson_package_id,
                                                'teacher_id'=>$invitation->teacher_id,
                                                'student_id'=>$invitation->student_id,
                                                'booking_id'=>$booking_id,
                                                'action'=>$action,
                                                'lesson_accept_reject'=>'1',
                                                'created_at'=>date('Y-m-d H:i:s')
                                            ];
    
                    $lessonLogId = $this->lessonLogModel->insertGetId($insertLessonLogData);
                    
                    if($lessonLogId!=''){
                        return redirect('my-lesson')->with('success','Lesson invitation has been accepted successfully.');
                    }
                }catch(Exception $e){
                    return redirect('my-lesson')->with('error','Please try again!');
                }
                
                
            }else{
                return redirect('student-dashboard')->with('error','You are not authorized! Please login as a student!'); 
            }
            
            
        }else{
            if($getLoggedIndata->role=='1' || $getLoggedIndata->role=='2'){
                return redirect('my-lesson')->with('error','Invitation not found!');
            }
        }
        
    }
    
    
    
    public function decline_lesson_invitation($id){
        $getLoggedIndata = getLoggedinData();
        $invitation = $this->lessonInvitationModel->where('id', '=', $id)->first();
                                                
        if($invitation){
            $updateData=[];
            $updateData['updated_at'] = date('Y-m-d H:i:s');
            
            if($getLoggedIndata->role=='1'){
                $updateData['status'] = '2'; 
                
                try{
                    $this->lessonInvitationModel->where('id',$id)->update($updateData); 
                    
                    $action = 'Lesson invitation request has been declined by student: '.$getLoggedIndata->name;
                    
                    
                    $insertLessonLogData = [
                                                'lesson_id'=>$invitation->lesson_id,
                                                'lesson_package_id'=>$invitation->lesson_package_id,
                                                'teacher_id'=>$invitation->teacher_id,
                                                'student_id'=>$invitation->student_id,
                                                'booking_id'=>null,
                                                'action'=>$action,
                                                'lesson_accept_reject'=>'2',
                                                'created_at'=>date('Y-m-d H:i:s')
                                            ];
    
                    $lessonLogId = $this->lessonLogModel->insertGetId($insertLessonLogData);
                    
                    return redirect('my-lesson')->with('success','Lesson invitation request has been declined successfully.');
                    
                }catch(Exception $e){
                    return redirect('my-lesson')->with('error','Please try again!');
                }
                
            }else{
                return redirect('student-dashboard')->with('error','You are not authorized! Please login as a student!'); 
            }
            
            
        }else{
            if($getLoggedIndata->role=='1' || $getLoggedIndata->role=='2'){
                return redirect('my-lesson')->with('error','Booking not found!');
            }
        }
        
    }
    
    
    
    
    
    
    
    
    
    
    
    
}



?>
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
use App\Models\Community;
use App\Models\FavoriteTeachers;
use App\Models\BlockList;
use App\Models\WalletLog;
use App\Models\CardDetail;
use App\Models\FeedbackRating;

use Session;
use Validator;
use Hash;
use Carbon\Carbon;

use Illuminate\Support\Facades\Storage;


class DashboardController extends Controller
{
    protected $registrationModel;
    protected $lessonsModel;
    protected $lessonPackagesModel;
    protected $teacherAvailabilityModel;
    protected $bookingModel;
    protected $communityModel;
    protected $favoriteTeachersModel;
    protected $blockListModel;
    protected $walletLogModel;
    protected $cardDetailModel;
    protected $feedbackRatingModel;
    
    public function __construct(){
        $this->registrationModel = new Registration;
        $this->lessonsModel = new Lessons;
        $this->lessonPackagesModel = new LessonPackages;
        $this->teacherAvailabilityModel = new TeacherAvailability;
        $this->bookingModel = new Booking;
        $this->communityModel = new Community;
        $this->favoriteTeachersModel = new FavoriteTeachers;
        $this->blockListModel = new BlockList;
        $this->walletLogModel = new WalletLog;
        $this->cardDetailModel = new CardDetail;
        $this->feedbackRatingModel = new FeedbackRating;
    }
    
    public function index(){ 
        $data['title']="Dashboard";
        $data['breadcrumb']='Dashboard';

        
        $data['user'] = $this->registrationModel->where('deleted_at', '=', null)->where(['id'=>session('id')])->first(); 

        //echo "<pre>"; print_r($data['user']); exit(); 
        

        if($data['user']->role=='1'){
            $data['myLessons'] = $this->bookingModel->leftJoin('lessons', 'booking.lesson_id', '=', 'lessons.id')
                                                ->leftJoin('lesson_packages', 'booking.lesson_package_id', '=', 'lesson_packages.id')
                                                ->whereNull('lessons.deleted_at')
                                                ->where('booking.student_id', '=', session('id'))
                                                ->orderBy('lessons.created_at', 'desc')->limit(5)->get(); 
                                                
            $data['myTeachers'] = $this->bookingModel->select([ DB::raw('DISTINCT(teacher_id)')])->where('student_id', '=', session('id'))->get(); 
            //echo "<pre>"; print_r($data['myTeachers']); exit(); 
            
            $myTeacherIds = $this->bookingModel->where('student_id', '=', session('id'))->select('teacher_id')->distinct()->get(); 
            if(count($myTeacherIds)>0){
                $myTeacherIdsArr = array();
                foreach($myTeacherIds as $value){
                    $myTeacherIdsArr[] = $value->teacher_id;
                }
                $data['recommendedTeachers'] = $this->registrationModel->where('deleted_at', '=', null)->where('role', '=', '2')
                                                                        ->whereNotIn('id', [$myTeacherIdsArr])->limit(5)->get(); 
            }else{
                $data['recommendedTeachers'] = $this->registrationModel->where('deleted_at', '=', null)->where('role', '=', '2')->limit(5)->get(); 
            }
            
            
            $data['communities'] = $this->communityModel->where('post_type', '=', 'article')->where('status', '=', '1')
                                                        ->where('deleted_at', '=', null)
                                                        ->orderBy('created_at', 'desc')->limit(5)->get(); 
                                                        
                                                        
            //For Chart
            $data['chartTotalLessons'] = $this->bookingModel->where('student_id', '=', session('id'))->count(); 
                                                       
            //echo "<pre>"; print_r($data['recommendedTeachers']); exit();       
            
            return view('student.dashboard',$data);
        }else{
            $data['booking'] = $this->bookingModel->where('booking_date', '>=', date('Y-m-d'))->where(['teacher_id'=>session('id')])->get(); 
            $data['lessonCount'] = $this->lessonsModel->where('deleted_at', '=', null)->where(['user_id'=>session('id')])->count(); 
            $data['studentCount'] = $this->bookingModel->where('teacher_id', '=', session('id'))->distinct('student_id')->count('student_id'); 
            $data['upcomingLessons'] = $this->bookingModel->where('teacher_id', '=', session('id'))->whereDate('booking_date', '>', date('Y-m-d'))->count(); 
            $data['totalBooking'] = $this->bookingModel->where(['teacher_id'=>session('id')])->count(); 
            
            $data['review_rating'] = $this->feedbackRatingModel->where('deleted_at', '=', null)->where(['teacher_id'=>session('id')])->get();
            
            $totalBadgesCount = 0;
            $numberOfReviews = 0;
            $totalStars = 0;
            $average = 0;
            if(count($data['review_rating'])>0){
                foreach($data['review_rating'] as $val){
                    $badges = json_decode($val->badges);
                    $totalBadgesCount += count($badges);
                    
                    $numberOfReviews++;
                    $totalStars += $val->rating;
                }
                
                if($numberOfReviews>0){
                    $average = $totalStars/$numberOfReviews;
                }
            }
            
            $data['totalBadges'] = $totalBadgesCount;
            $data['average_rating'] = number_format($average,1);
            
            return view('teacher.dashboard',$data);
        }

        
    }
    
    
    public function profile(){ 
        $data['title']="Profile";
        $data['breadcrumb']='Profile';

        
        $data['user'] = $this->registrationModel->where('deleted_at', '=', null)->where(['id'=>session('id')])->first(); 
        //echo $data['user']->role; die();
        
        $data['age'] = '';
        if($data['user']->dob!=''){
            $dob = $data['user']->dob;
            $age = Carbon::parse($data['user']->dob)->diff(Carbon::now())->y;
            $data['age'] = $age;
        }

        if($data['user']->role=='1'){
            $data['myTeachers'] = $this->bookingModel->select([ DB::raw('DISTINCT(teacher_id)')])->where('student_id', '=', session('id'))->get(); 
            $data['completedLessonCount'] = $this->bookingModel->where('student_id', '=', session('id'))->where('status', '=', '3')->count(); 
            $data['postedArticleCount'] = $this->communityModel->where('added_by', '=', session('id'))->where('post_type', '=', 'article')
                                                                ->where('status', '=', '1')->where('deleted_at', '=', null)->count(); 
            
            $data['postedForumCount'] = $this->communityModel->where('added_by', '=', session('id'))->where('post_type', '=', 'forum')
                                                                ->where('status', '=', '1')->where('deleted_at', '=', null)->count(); 
            
            return view('student.profile',$data);
        }else{
            
            $data['myStudentIds'] = $this->bookingModel->select([ DB::raw('DISTINCT(student_id)')])->where('teacher_id', '=', session('id'))->get(); 
            $data['completedLessonCount'] = $this->bookingModel->where('teacher_id', '=', session('id'))->where('status', '=', '3')->count(); 
            $data['postedArticleCount'] = $this->communityModel->where('added_by', '=', session('id'))->where('post_type', '=', 'article')
                                                                ->where('status', '=', '1')->where('deleted_at', '=', null)->count(); 
            
            $data['postedForumCount'] = $this->communityModel->where('added_by', '=', session('id'))->where('post_type', '=', 'forum')
                                                                ->where('status', '=', '1')->where('deleted_at', '=', null)->count(); 
            
            return view('teacher.profile',$data);
        }

        
    }
    
    
    
    public function edit_profile(){ 
        $data['title']="Edit Profile";
        $data['breadcrumb']='Edit Profile';
        
        $data['countries'] = DB::table('countries')->orderBy('name', 'ASC')->get();
        $data['languages'] = DB::table('languages')->where('deleted_at', '=', null)->orderBy('name', 'ASC')->get();
        
        $data['user'] = $this->registrationModel->where('deleted_at', '=', null)->where(['id'=>session('id')])->first(); 
        
        //echo $data['user']->role; die(); 

        if($data['user']->role=='1'){
            return view('student.edit-profile',$data);
        }else{
            return view('teacher.edit-profile',$data);
        }

    }
    
    
    
    public function basic_info_update(request $request){
        
        $data['user'] = $this->registrationModel->where(['id'=>$request->id])->first();
        
        if(count($request->all()) > 0) {   
            $validator = Validator::make($request->all(), [
                            'display_name' => 'required',
                            /*'video_conferencing_platform' => 'required',
                            'user_account_id' => 'required',
                            'dob' => 'required|date_format:Y-m-d',
                            'gender' => 'required',
                            'address'=>'required',
                            'country_of_origin'=>'required',
                            'country_living_in'=>'required',*/
                        ]);
                        
            if ($validator->fails()) { 
                if($request->role=='1'){
                    return redirect('student-profile-edit')->withErrors($validator)->withInput(); 
                }else{
                    return redirect('teacher-profile-edit')->withErrors($validator)->withInput(); 
                }
                
            }else{
                
                $error_filesImage = $_FILES['my_profile_photo']['size'];
                if($error_filesImage == 0){
                    $img = $request->earlier_img;
                }else{
                    
                    if($request->earlier_img!=''){
                        $exists = file_exists( storage_path() . '/app/user_photo/' . $request->earlier_img );
                        if($exists) {
                           unlink(storage_path('app/user_photo/'.$request->earlier_img));
                        }
                    }
                    
                    $filenameWithExt = $request->file('my_profile_photo')->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);    // Get just filename 
                    $filename = str_replace(' ', '_', $filename);
                    
                    
                    $extension = $request->file('my_profile_photo')->getClientOriginalExtension();  // Get just ext
                    
                    if($request->role=='1'){
                        $img = 's_'.$filename.'_'.time().'.'.$extension;         //Filename to store   
                    }else{
                        $img = 't_'.$filename.'_'.time().'.'.$extension;         //Filename to store   
                    }
                    $destinationPath = storage_path('app/user_photo');
                    
                    $request->file('my_profile_photo')->move($destinationPath, $img);
                }
                
                $updateData=[];

                $updateData['updated_at'] = date('Y-m-d H:i:s'); 
                
                
                if($request->has('email')){
                    $email = $this->registrationModel->where(['email'=>$request->email,deleted_at=>null])->get();  
                    if(count($email)>0 && $request->email != $data['user']->email){
                        if($request->role=='1'){
                            return redirect('student-profile-edit')->with('error','Email already exists!');
                        }else{
                            return redirect('teacher-profile-edit')->with('error','Email already exists!');
                        }
                        
                    }else{
                        $updateData['email'] = $request->email;  
                    }
                }
                
                
                if($request->has('display_name')){
                    $updateData['name'] = ucfirst($request->display_name); 
                }
                
                if($request->has('dob')){
                    $updateData['dob'] = $request->dob; 
                }
                
                if($request->has('gender')){
                    $updateData['gender'] = $request->gender; 
                }
                
                if($request->has('country_of_origin')){
                    $updateData['country_of_origin'] = $request->country_of_origin; 
                }
                
                if($request->has('country_living_in')){
                    $updateData['country_living_in'] = $request->country_living_in; 
                }
                
                if($request->has('teacher_type')){
                    $updateData['teacher_type'] = $request->teacher_type; 
                }
                
                if($request->has('address')){
                    $updateData['address'] = $request->address; 
                }
                
                if($request->hasFile('my_profile_photo')) {
                    $updateData['profile_photo'] = $img; 
                }
                
                try{
                    $this->registrationModel->where('id',$request->id)->update($updateData);
                    
                    if($request->role=='1'){
                        return redirect('student-profile-edit')->with('success','Basic information has been updated successfully.');
                    }else{
                        return redirect('teacher-profile-edit')->with('success','Basic information has been updated successfully.');
                    }
                    
                }catch(Exception $e){
                    
                    if($request->role=='1'){
                        return redirect('student-profile-edit')->with('error','Please try again!');
                    }else{
                        return redirect('teacher-profile-edit')->with('error','Please try again!');
                    }
                }
                
                
            }
            
        }
    }
    
    
    public function communication_tool_update(request $request){
        
        $data['user'] = $this->registrationModel->where(['id'=>$request->id])->first();
        
        if(count($request->all()) > 0) {   
            $validator = Validator::make($request->all(), [
                            'video_conferencing_platform' => 'required',
                            'user_account_id' => 'required',
                        ]);
                        
            if ($validator->fails()) { 
                if($request->role=='1'){
                    return redirect('student-profile-edit')->withErrors($validator)->withInput(); 
                }else{
                    return redirect('teacher-profile-edit')->withErrors($validator)->withInput(); 
                }
                
            }else{
                
                
                $updateData=[];

                $updateData['updated_at'] = date('Y-m-d H:i:s'); 
                
                if($request->has('video_conferencing_platform')){
                    $updateData['video_conferencing_platform'] = $request->video_conferencing_platform; 
                }
                
                if($request->has('user_account_id')){
                    $updateData['user_account_id'] = $request->user_account_id; 
                }
                
                
                try{
                    $this->registrationModel->where('id',$request->id)->update($updateData);
                    
                    if($request->role=='1'){
                        return redirect('student-profile-edit')->with('success','Communication tool has been updated successfully.');
                    }else{
                        return redirect('teacher-profile-edit')->with('success','Communication tool has been updated successfully.');
                    }
                    
                }catch(Exception $e){
                    
                    if($request->role=='1'){
                        return redirect('student-profile-edit')->with('error','Please try again!');
                    }else{
                        return redirect('teacher-profile-edit')->with('error','Please try again!');
                    }
                }
                
                
            }
            
        }
    }
    
    
    
    
    public function introduction_update(request $request){
        $data['user'] = $this->registrationModel->where(['id'=>$request->id])->first();
        
        if(count($request->all()) > 0) {   
            $validator = Validator::make($request->all(), [
                            'about_me' => 'required|min:10',
                            //'about_my_lessons' => 'required',
                        ]);
                        
            if ($validator->fails()) { 
                if($request->role=='1'){
                    return redirect('student-profile-edit')->withErrors($validator)->withInput(); 
                }else{
                    return redirect('teacher-profile-edit')->withErrors($validator)->withInput(); 
                }
                
            }else{
                
                
                
                $updateData=[];

                $updateData['updated_at'] = date('Y-m-d H:i:s'); 
                
                if($request->has('about_me')){
                    $updateData['about_me'] = $request->about_me; 
                }
                
                if($request->has('about_my_lessons')){
                    $updateData['about_my_lessons'] = $request->about_my_lessons; 
                }
                
                if($request->has('my_teaching_material')){
                    $updateData['my_teaching_material'] = json_encode($request->my_teaching_material); 
                }
                
                
                try{
                    $this->registrationModel->where('id',$request->id)->update($updateData);
                    
                    if($request->role=='1'){
                        return redirect('student-profile-edit')->with('success','Introduction has been updated successfully.');
                    }else{
                        return redirect('teacher-profile-edit')->with('success','Introduction has been updated successfully.');
                    }
                    
                }catch(Exception $e){
                    
                    if($request->role=='1'){
                        return redirect('student-profile-edit')->with('error','Please try again!');
                    }else{
                        return redirect('teacher-profile-edit')->with('error','Please try again!');
                    }
                }
                
                
            }
            
        }
    }
    
    
    
    
    public function languages_update(request $request){
        
        $data['user'] = $this->registrationModel->where(['id'=>$request->id])->first();
        
        if(count($request->all()) > 0) {   
            $validator = Validator::make($request->all(), [
                            'id' => 'required',
                            'role' => 'required',
                        ]);
                        
            if ($validator->fails()) { 
                if($request->role=='1'){
                    return redirect('student-profile-edit')->withErrors($validator)->withInput(); 
                }else{
                    return redirect('teacher-profile-edit')->withErrors($validator)->withInput(); 
                }
                
            }else{
                
                //echo "<pre>"; echo "<br>"; print_r($request->language); print_r($request->taught_lang); 
                
                $languageArrState = array_filter($request->language);
                $languageTaughtArrState = array_filter($request->taught_lang);
                
                $updateData=[];

                $updateData['updated_at'] = date('Y-m-d H:i:s'); 
                

                if (!empty($languageArrState)) {
                    if(count($request->language)>0){
                        $languageArr = array();
                        for ($i=0; $i < count($request->language); $i++ )
                        {
                            if(!empty($request->language)){
                                $languageArr[] = [
                                                    'language' => $request->language[$i],
                                                    'level' => $request->lang_level[$i]
                                                ];
                            }else{
                                $languageArr = null;
                            }
                        }
                        
                        $newArr = array_values( array_unique( $languageArr, SORT_REGULAR ) );
                        $languageJson = json_encode($newArr);
                    }
                    
                    
                    if($request->has('language')){
                        $updateData['languages_spoken'] = $languageJson; 
                    }
                } 
                
                
                
                
                if (!empty($languageTaughtArrState)) {
                    if(count($request->taught_lang)>0){
                        $taughtLanguageArr = array();
                        
                        for ($j=0; $j < count($request->taught_lang); $j++ )
                        {
                            if(!empty($request->taught_lang)){
                                $taughtLanguageArr[] = [
                                                            'language' => $request->taught_lang[$j]
                                                        ];
                            }else{
                                $taughtLanguageArr = null;
                            }
                        }
                        
                        
                        $newArr = array_values( array_unique( $taughtLanguageArr, SORT_REGULAR ) );
                        
                        $taughtLanguageJson = json_encode($newArr); 
                        
                    }
                    
                    
                    if($request->has('taught_lang')){
                        $updateData['languages_taught'] = $taughtLanguageJson; 
                    }
                } 
                
                
                //echo $taughtLanguageJson; exit();
                
                
                try{
                    $this->registrationModel->where('id',$request->id)->update($updateData);
                    
                    if($request->role=='1'){
                        return redirect('student-profile-edit')->with('success','Languages has been updated successfully.');
                    }else{
                        return redirect('teacher-profile-edit')->with('success','Languages has been updated successfully.');
                    }
                    
                }catch(Exception $e){
                    
                    if($request->role=='1'){
                        return redirect('student-profile-edit')->with('error','Please try again!');
                    }else{
                        return redirect('teacher-profile-edit')->with('error','Please try again!');
                    }
                }
                
                
            }
            
        }
    }
    
    
    
    
    
    
    public function settings_update(request $request){
        
        $data['user'] = $this->registrationModel->where('deleted_at', '=', null)->where(['id'=>session('id')])->first(); 
        
        if(count($request->all()) > 0) {   
            $validator = Validator::make($request->all(), [
                            'display_name' => 'required',
                            /*'video_conferencing_platform' => 'required',
                            'user_account_id' => 'required',
                            'dob' => 'required|date_format:Y-m-d',
                            'gender' => 'required',
                            'address'=>'required',
                            'country_of_origin'=>'required',
                            'country_living_in'=>'required',*/
                        ]);
                        
            if ($validator->fails()) { 
                if($request->role=='1'){
                    return redirect('student-profile-edit')->withErrors($validator)->withInput(); 
                }else{
                    return redirect('teacher-profile-edit')->withErrors($validator)->withInput(); 
                }
                
            }else{
                
                $error_filesImage = $_FILES['my_profile_photo']['size'];
                if($error_filesImage == 0){
                    $img = $request->earlier_img;
                }else{
                    
                    if($request->earlier_img!=''){
                        $exists = file_exists( storage_path() . '/app/user_photo/' . $request->earlier_img );
                        if($exists) {
                           unlink(storage_path('app/user_photo/'.$request->earlier_img));
                        }
                    }
                    
                    $filenameWithExt = $request->file('my_profile_photo')->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);    // Get just filename 
                    $filename = str_replace(' ', '_', $filename);
                    
                    
                    $extension = $request->file('my_profile_photo')->getClientOriginalExtension();  // Get just ext
                    
                    if($request->role=='1'){
                        $img = 's_'.$filename.'_'.time().'.'.$extension;         //Filename to store   
                    }else{
                        $img = 't_'.$filename.'_'.time().'.'.$extension;         //Filename to store   
                    }
                    $destinationPath = storage_path('app/user_photo');
                    
                    $request->file('my_profile_photo')->move($destinationPath, $img);
                }
                
                $updateData=[];

                $updateData['updated_at'] = date('Y-m-d H:i:s'); 
                
                
                if($request->has('email')){
                    $email = $this->registrationModel->where(['email'=>$request->email,deleted_at=>null])->get();  
                    if(count($email)>0 && $request->email != $data['user']->email){
                        if($request->role=='1'){
                            return redirect('student-profile-edit')->with('error','Email already exists!');
                        }else{
                            return redirect('student-profile-edit')->with('error','Email already exists!');
                        }
                        
                    }else{
                        $updateData['email'] = $request->email;  
                    }
                }
                
                
                if($request->has('display_name')){
                    $updateData['name'] = ucfirst($request->display_name); 
                }
                
                if($request->has('dob')){
                    $updateData['dob'] = $request->dob; 
                }
                
                if($request->has('gender')){
                    $updateData['gender'] = $request->gender; 
                }
                
                if($request->has('country_of_origin')){
                    $updateData['country_of_origin'] = $request->country_of_origin; 
                }
                
                if($request->has('country_living_in')){
                    $updateData['country_living_in'] = $request->country_living_in; 
                }
                
                if($request->has('address')){
                    $updateData['address'] = $request->address; 
                }
                
                if($request->hasFile('my_profile_photo')) {
                    $updateData['profile_photo'] = $img; 
                }
                
                try{
                    $this->registrationModel->where('id',$request->id)->update($updateData);
                    
                    if($request->role=='1'){
                        return redirect('student-profile-edit')->with('success','Basic information has been updated successfully.');
                    }else{
                        return redirect('teacher-profile-edit')->with('success','Basic information has been updated successfully.');
                    }
                    
                }catch(Exception $e){
                    
                    if($request->role=='1'){
                        return redirect('student-profile-edit')->with('error','Please try again!');
                    }else{
                        return redirect('teacher-profile-edit')->with('error','Please try again!');
                    }
                }
                
                
            }
            
        }else{
            
            if($data['user']->role=='1'){
                return view('student.setting',$data);
            }else{
                return view('teacher.setting',$data);
            }
        }
    }
    

    
    public function messages(request $request){
        
        $data['user'] = $this->registrationModel->where('deleted_at', '=', null)->where(['id'=>session('id')])->first(); 
        
        if(count($request->all()) > 0) {   
            $validator = Validator::make($request->all(), [
                            'display_name' => 'required',
                            /*'video_conferencing_platform' => 'required',
                            'user_account_id' => 'required',
                            'dob' => 'required|date_format:Y-m-d',
                            'gender' => 'required',
                            'address'=>'required',
                            'country_of_origin'=>'required',
                            'country_living_in'=>'required',*/
                        ]);
                        
            if ($validator->fails()) { 
                if($request->role=='1'){
                    return redirect('student-profile-edit')->withErrors($validator)->withInput(); 
                }else{
                    return redirect('teacher-profile-edit')->withErrors($validator)->withInput(); 
                }
                
            }else{
                
                $error_filesImage = $_FILES['my_profile_photo']['size'];
                if($error_filesImage == 0){
                    $img = $request->earlier_img;
                }else{
                    
                    if($request->earlier_img!=''){
                        $exists = file_exists( storage_path() . '/app/user_photo/' . $request->earlier_img );
                        if($exists) {
                           unlink(storage_path('app/user_photo/'.$request->earlier_img));
                        }
                    }
                    
                    $filenameWithExt = $request->file('my_profile_photo')->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);    // Get just filename 
                    $filename = str_replace(' ', '_', $filename);
                    
                    
                    $extension = $request->file('my_profile_photo')->getClientOriginalExtension();  // Get just ext
                    
                    if($request->role=='1'){
                        $img = 's_'.$filename.'_'.time().'.'.$extension;         //Filename to store   
                    }else{
                        $img = 't_'.$filename.'_'.time().'.'.$extension;         //Filename to store   
                    }
                    $destinationPath = storage_path('app/user_photo');
                    
                    $request->file('my_profile_photo')->move($destinationPath, $img);
                }
                
                $updateData=[];

                $updateData['updated_at'] = date('Y-m-d H:i:s'); 
                
                
                if($request->has('email')){
                    $email = $this->registrationModel->where(['email'=>$request->email,deleted_at=>null])->get();  
                    if(count($email)>0 && $request->email != $data['user']->email){
                        if($request->role=='1'){
                            return redirect('student-profile-edit')->with('error','Email already exists!');
                        }else{
                            return redirect('student-profile-edit')->with('error','Email already exists!');
                        }
                        
                    }else{
                        $updateData['email'] = $request->email;  
                    }
                }
                
                
                if($request->has('display_name')){
                    $updateData['name'] = ucfirst($request->display_name); 
                }
                
                if($request->has('dob')){
                    $updateData['dob'] = $request->dob; 
                }
                
                if($request->has('gender')){
                    $updateData['gender'] = $request->gender; 
                }
                
                if($request->has('country_of_origin')){
                    $updateData['country_of_origin'] = $request->country_of_origin; 
                }
                
                if($request->has('country_living_in')){
                    $updateData['country_living_in'] = $request->country_living_in; 
                }
                
                if($request->has('address')){
                    $updateData['address'] = $request->address; 
                }
                
                if($request->hasFile('my_profile_photo')) {
                    $updateData['profile_photo'] = $img; 
                }
                
                try{
                    $this->registrationModel->where('id',$request->id)->update($updateData);
                    
                    if($request->role=='1'){
                        return redirect('student-profile-edit')->with('success','Basic information has been updated successfully.');
                    }else{
                        return redirect('teacher-profile-edit')->with('success','Basic information has been updated successfully.');
                    }
                    
                }catch(Exception $e){
                    
                    if($request->role=='1'){
                        return redirect('student-profile-edit')->with('error','Please try again!');
                    }else{
                        return redirect('teacher-profile-edit')->with('error','Please try again!');
                    }
                }
                
                
            }
            
        }else{
            
            if($data['user']->role=='1'){
                return view('student.messages',$data);
            }else{
                return view('teacher.messages',$data);
            }
        }
    }
    
    
    
    public function wallet(request $request){
        
        $data['user'] = $this->registrationModel->where('deleted_at', '=', null)->where(['id'=>session('id')])->first(); 
        
        if(count($request->all()) > 0) {   
            $validator = Validator::make($request->all(), [
                            'display_name' => 'required',
                            /*'video_conferencing_platform' => 'required',
                            'user_account_id' => 'required',
                            'dob' => 'required|date_format:Y-m-d',
                            'gender' => 'required',
                            'address'=>'required',
                            'country_of_origin'=>'required',
                            'country_living_in'=>'required',*/
                        ]);
                        
            if ($validator->fails()) { 
                if($request->role=='1'){
                    return redirect('student-profile-edit')->withErrors($validator)->withInput(); 
                }else{
                    return redirect('teacher-profile-edit')->withErrors($validator)->withInput(); 
                }
                
            }else{
                
                $error_filesImage = $_FILES['my_profile_photo']['size'];
                if($error_filesImage == 0){
                    $img = $request->earlier_img;
                }else{
                    
                    if($request->earlier_img!=''){
                        $exists = file_exists( storage_path() . '/app/user_photo/' . $request->earlier_img );
                        if($exists) {
                           unlink(storage_path('app/user_photo/'.$request->earlier_img));
                        }
                    }
                    
                    $filenameWithExt = $request->file('my_profile_photo')->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);    // Get just filename 
                    $filename = str_replace(' ', '_', $filename);
                    
                    
                    $extension = $request->file('my_profile_photo')->getClientOriginalExtension();  // Get just ext
                    
                    if($request->role=='1'){
                        $img = 's_'.$filename.'_'.time().'.'.$extension;         //Filename to store   
                    }else{
                        $img = 't_'.$filename.'_'.time().'.'.$extension;         //Filename to store   
                    }
                    $destinationPath = storage_path('app/user_photo');
                    
                    $request->file('my_profile_photo')->move($destinationPath, $img);
                }
                
                $updateData=[];

                $updateData['updated_at'] = date('Y-m-d H:i:s'); 
                
                
                if($request->has('email')){
                    $email = $this->registrationModel->where(['email'=>$request->email,deleted_at=>null])->get();  
                    if(count($email)>0 && $request->email != $data['user']->email){
                        if($request->role=='1'){
                            return redirect('student-profile-edit')->with('error','Email already exists!');
                        }else{
                            return redirect('teacher-profile-edit')->with('error','Email already exists!');
                        }
                        
                    }else{
                        $updateData['email'] = $request->email;  
                    }
                }
                
                
                if($request->has('display_name')){
                    $updateData['name'] = ucfirst($request->display_name); 
                }
                
                if($request->has('dob')){
                    $updateData['dob'] = $request->dob; 
                }
                
                if($request->has('gender')){
                    $updateData['gender'] = $request->gender; 
                }
                
                if($request->has('country_of_origin')){
                    $updateData['country_of_origin'] = $request->country_of_origin; 
                }
                
                if($request->has('country_living_in')){
                    $updateData['country_living_in'] = $request->country_living_in; 
                }
                
                if($request->has('address')){
                    $updateData['address'] = $request->address; 
                }
                
                if($request->hasFile('my_profile_photo')) {
                    $updateData['profile_photo'] = $img; 
                }
                
                try{
                    $this->registrationModel->where('id',$request->id)->update($updateData);
                    
                    if($request->role=='1'){
                        return redirect('student-profile-edit')->with('success','Basic information has been updated successfully.');
                    }else{
                        return redirect('teacher-profile-edit')->with('success','Basic information has been updated successfully.');
                    }
                    
                }catch(Exception $e){
                    
                    if($request->role=='1'){
                        return redirect('student-profile-edit')->with('error','Please try again!');
                    }else{
                        return redirect('teacher-profile-edit')->with('error','Please try again!');
                    }
                }
                
                
            }
            
        }else{
            
            if($data['user']->role=='1'){
                $data['walletLog'] = $this->walletLogModel->where('deleted_at', '=', null)->where(['user_id'=>session('id')])->get(); 
                $data['userCardDetail'] = $this->cardDetailModel->where('deleted_at', '=', null)->where('user_id', '=', session('id'))->get();  
                
                return view('student.my-wallet',$data);
            }else{
                return view('teacher.my-wallet',$data);
            }
        }
    }
    
    
    public function my_favorite_teacher(Request $request){
        $teacher_id = $request->teacher_id;
        $action = $request->action;
        
        $favoriteExistCheck = $this->favoriteTeachersModel->where('teacher_id', '=', $teacher_id)
                                                        ->where('student_id', '=', session('id'))
                                                        ->first(); 
        
        if($action=='add'){
            //echo "cc ".$teacher_id." >> ".session('id'); print_r($favoriteExistCheck); exit();                     
            if($favoriteExistCheck){
                $updateData=[];

                $updateData['updated_at'] = date('Y-m-d H:i:s');
                $updateData['deleted_at'] = NULL;
                
                try{
                    $this->favoriteTeachersModel->where('id',$favoriteExistCheck->id)->update($updateData);
                    echo 1;
                }catch(Exception $e){
                    echo 0;
                }
            }else{
                
                $insertData = [
                        'student_id'=>session('id'),
                        'teacher_id'=>$teacher_id,
                        'created_at'=>date('Y-m-d H:i:s')
                    ];
                    
                $favoriteId = $this->favoriteTeachersModel->insertGetId($insertData);
                echo 1;
            }
            
        }else{
            
            if($favoriteExistCheck){
                $delete = $this->favoriteTeachersModel->where('id', '=', $favoriteExistCheck->id)->delete();
                
                if($delete){
                    echo 1;
                }else{
                    echo 0;
                }
            }else{
                echo 0;
            }
            
            
            
        }
        
    }
    
    
    
    public function block_student($id){
        
        $blockList = $this->blockListModel->where('user_id','=',$id)->where('blocked_by','=',session('id'))->where('deleted_at', '=', null)->get(); 
        
        if(count($blockList) > 0) { 
            return redirect('my-students')->with('error','Already blocked by you!'); 
            
        } else{   
            $insertData = [
                                'user_id'=>$id,
                                'blocked_by'=>session('id'),
                                'created_at'=>date('Y-m-d H:i:s')
                            ];
            
            $blockListId = $this->blockListModel->insertGetId($insertData);    
                
            if($blockListId!=''){
                return redirect('my-students')->with('success','Student has been blocked successfully.');
            }else{
                return redirect('my-students')->with('error','Please try again!');
            }
        }
    }
    
    public function unblock_user($id){
        
        $blockList = $this->blockListModel->where('user_id','=',$id)->where('blocked_by','=',session('id'))->where('deleted_at', '=', null)->get(); 
        
        if(count($blockList) > 0) { 
            $this->blockListModel->where('user_id','=',$id)->where('blocked_by','=',session('id'))->delete();
            
            if(session('role')=='1'){
                return redirect('student-settings')->with('success','User has been unblocked successfully.');
            }else{
                return redirect('teacher-settings')->with('success','User has been unblocked successfully.');
            }
            
        } else{   
            
            if(session('role')=='1'){
                return redirect('student-settings')->with('error','Please try again!');
            }else{
                return redirect('teacher-settings')->with('error','Please try again!');
            }
            
        }
    }
    
    
    public function my_students() {
        $data['myStudentIds'] = $this->bookingModel->select([ DB::raw('DISTINCT(student_id)')])->where('teacher_id', '=', session('id'))->get(); 
        //echo "<pre>"; print_r($data['myStudentIds']); exit();
        
        if(session('role')=='2'){
            $data['active'] = $this->bookingModel->leftJoin('registrations', 'booking.student_id', '=', 'registrations.id')
                                                ->select(DB::raw('DISTINCT(student_id)'))
                                                ->whereNull('registrations.deleted_at')
                                                ->where('booking.teacher_id', '=', session('id'))
                                                ->orderBy('booking.created_at', 'desc')->get();
                                                
            $data['inactive'] = $this->bookingModel->leftJoin('registrations', 'booking.student_id', '=', 'registrations.id')
                                                ->select(DB::raw('DISTINCT(student_id)'))
                                                ->whereNotNull('registrations.deleted_at')
                                                ->where('booking.teacher_id', '=', session('id'))
                                                ->orderBy('booking.created_at', 'desc')->get();
                                                
            $data['potential'] = $this->favoriteTeachersModel->select(DB::raw('DISTINCT(student_id)'))
                                                ->where('teacher_id', '=', session('id'))->get(); 
            
                                                
            //echo "<pre>"; print_r($data['potential']); exit(); 
            
            return view('teacher.my-students',$data);
        }else{
            return view('student.dashboard',$data);
        }
        
    }
    
    
    public function my_wallet(){
        $data['user'] = $this->registrationModel->where('deleted_at', '=', null)->where(['id'=>session('id')])->first(); 
        
        if(session('role')=='2'){
            return view('teacher.my-wallet',$data);
        }else{
            return view('student.my-wallet',$data);
        }
    }
    
    
    
    public function add_credit(){
        $data['user'] = $this->registrationModel->where('deleted_at', '=', null)->where(['id'=>session('id')])->first(); 
        
        if(session('role')=='2'){
            return view('teacher.dashboard',$data);
        }else{
            
            $data['userCardDetail'] = $this->cardDetailModel->where('deleted_at', '=', null)->where('user_id', '=', session('id'))->get();
            
            return view('student.credit',$data);
        }
    }
    
    
    
    
    public function switch_to_teacher_mode(){
        $data['user'] = $this->registrationModel->where('deleted_at', '=', null)->where(['id'=>session('id')])->first(); 
        
        if($data['user']){
            if($data['user']->role=='1'){
                
                $updateData=[];

                $updateData['updated_at'] = date('Y-m-d H:i:s');
                $updateData['role'] = '2';
                
                try{
                    $updt = $this->registrationModel->where('id',session('id'))->update($updateData);
                    
                    if($updt){
                        
                        Session::forget('role');
                        Session::put('role', '2');
                        
                        $insertData = [
                                        'user_id'=>session('id'),
                                        'current_mode'=>session('role'),
                                        'switched_mode'=>'2',
                                        'created_at'=>date('Y-m-d H:i:s')
                                    ];
                                    
                        DB::table('switch_mode_log')->insert($insertData);
                        
                        return redirect('teacher-dashboard');
                        
                        //session()->flush();
                        //return redirect('login');
                    }
                    
                }catch(Exception $e){
                    return redirect('student-settings')->with('error','Please try again!');
                }
            }
        }
    }
    
    
    public function switch_to_student_mode(){
        $data['user'] = $this->registrationModel->where('deleted_at', '=', null)->where(['id'=>session('id')])->first(); 
        
        if($data['user']){
            if($data['user']->role=='2'){
                
                $updateData=[];

                $updateData['updated_at'] = date('Y-m-d H:i:s');
                $updateData['role'] = '1';
                
                try{
                    $updt = $this->registrationModel->where('id',session('id'))->update($updateData);
                    
                    if($updt){
                        
                        Session::forget('role');
                        Session::put('role', '1');
                        
                        $insertData = [
                                        'user_id'=>session('id'),
                                        'current_mode'=>session('role'),
                                        'switched_mode'=>'1',
                                        'created_at'=>date('Y-m-d H:i:s')
                                    ];
                                    
                        DB::table('switch_mode_log')->insert($insertData);
                        
                        return redirect('student-dashboard');
                        
                        //session()->flush();
                        //return redirect('login');
                    }
                    
                }catch(Exception $e){
                    return redirect('student-settings')->with('error','Please try again!');
                }
            }
        }
    }
    
    
    public function logout(){
        session()->flush();
        return redirect('login');
    }
    

}



?>
<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Registration;
use App\Models\BlockList;
use App\Models\Transaction;
use App\Models\WalletLog;
use App\Models\CardDetail;

use Session;
use Validator;
use Hash;
use Carbon\Carbon;

use Illuminate\Support\Facades\Storage;


class SettingsController extends Controller
{
    protected $registrationModel;
    protected $blockListModel;
    protected $transactionModel;
    protected $walletLogModel;
    protected $cardDetailModel;
    
    public function __construct(){
        $this->registrationModel = new Registration;
        $this->blockListModel = new BlockList;
        $this->transactionModel = new Transaction;
        $this->walletLogModel = new WalletLog;
        $this->cardDetailModel = new CardDetail;
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
    
    
    
    public function settings_update(Request $request){
        
        $data['user'] = $this->registrationModel->where('deleted_at', '=', null)->where(['id'=>session('id')])->first(); 
        $data['timezone'] = DB::table('timezone')->get(); 
        $data['currencies'] = DB::table('currency')->get(); 
        
        $data['saved_card_details'] = $this->cardDetailModel->where('deleted_at', '=', null)->where('user_id','=',session('id'))->get();   
        $data['blockedUsers'] = $this->blockListModel->where('deleted_at', '=', null)->where('blocked_by','=',session('id'))->get();   
        
        if(count($request->all()) > 0) { 
            
            if($request->has('email')){
                $validator = Validator::make($request->all(), [
                            'email' => 'required|email|regex:/(.+)@(.+)\.(.+)/i',
                            'id' => 'required',
                            'role' => 'required',
                        ]);
            }else{
                $validator = Validator::make($request->all(), [
                            'id' => 'required',
                            'role' => 'required',
                        ]);
            }
            
                        
            if ($validator->fails()) { 
                if($request->role=='1'){
                    return redirect('student-settings')->withErrors($validator)->withInput(); 
                }else{
                    return redirect('teacher-settings')->withErrors($validator)->withInput(); 
                }
                
            }else{
                
                
                $updateData=[];

                $updateData['updated_at'] = date('Y-m-d H:i:s'); 
                
                
                if($request->has('email')){
                    $email = $this->registrationModel->where('email','=',$request->email)->where('deleted_at','=',null)->get();  
                    if(count($email)>0 && $request->email != $data['user']->email){
                        if($request->role=='1'){
                            return redirect('student-settings')->with('error','Email already exists!');
                        }else{
                            return redirect('teacher-settings')->with('error','Email already exists!');
                        }
                        
                    }else{
                        $updateData['email'] = $request->email;  
                    }
                }
                
                if($request->has('phone')){
                    $phone = $this->registrationModel->where(['phone_number'=>$request->phone,'deleted_at'=>null])->get();  
                    if(count($phone)>0 && $request->phone != $data['user']->phone_number){
                        if($request->role=='1'){
                            return redirect('student-settings')->with('error','Phone number already exists!');
                        }else{
                            return redirect('teacher-settings')->with('error','Phone number already exists!');
                        }
                        
                    }else{
                        $updateData['phone_number'] = $request->phone;  
                    }
                }
                
                
                if($request->has('timezone')){
                    $updateData['timezone'] = ucfirst($request->timezone); 
                }
                
                if($request->has('time_format')){
                    $updateData['time_format'] = $request->time_format; 
                }
                
                if($request->has('currency')){
                    $updateData['currency'] = $request->currency; 
                }
                
                
                
                try{
                    $this->registrationModel->where('id',$request->id)->update($updateData);
                    
                    if($request->role=='1'){
                        return redirect('student-settings')->with('success','Settings has been updated successfully.');
                    }else{
                        return redirect('teacher-settings')->with('success','Settings has been updated successfully.');
                    }
                    
                }catch(Exception $e){
                    
                    if($request->role=='1'){
                        return redirect('student-settings')->with('error','Please try again!');
                    }else{
                        return redirect('teacher-settings')->with('error','Please try again!');
                    }
                }
                
                
            }
            
        }else{
            
            if($data['user']->role=='1'){
                $data['transactions'] = $this->transactionModel->where('user_id','=',session('id'))->get();   

                return view('student.setting',$data);
            }else{
                return view('teacher.setting',$data);
            }
        }
    }
    

    
    
    public function password_update(Request $request){
        
        $data['user'] = $this->registrationModel->where('deleted_at', '=', null)->where(['id'=>session('id')])->first(); 
        //$data['timezone'] = DB::table('timezone')->get(); 
        //$data['currencies'] = DB::table('currency')->get(); 
        
        if(count($request->all()) > 0) {   
            $validator = Validator::make($request->all(), [
                            'id' => 'required',
                            'role' => 'required',
                            'old_password' => 'required',
                            'new_password' => 'required|min:6',
                            'confirm_password' => 'required|same:new_password|min:6',
                        ]);
                        
            if ($validator->fails()) { 
                if($request->role=='1'){
                    return redirect('student-settings')->withErrors($validator)->withInput(); 
                }else{
                    return redirect('teacher-settings')->withErrors($validator)->withInput(); 
                }
                
            }else{
                
                
                $updateData=[];

                $updateData['updated_at'] = date('Y-m-d H:i:s'); 
                
                
                if($request->has('old_password')){
                    if(Hash::check($request->old_password,$data['user']->password)){
                        
                    }else{
                        
                        if($request->role=='1'){
                            return redirect('student-settings')->with('error','Incorrect old password!');
                        }else{
                           return redirect('teacher-settings')->with('error','Incorrect old password!'); 
                        }
                        
                    }
                }
                
                
                if($request->has('new_password')){
                    $updateData['password'] = Hash::make($request->new_password);
                }
                
                
                
                try{
                    $this->registrationModel->where('id',$request->id)->update($updateData);
                    
                    if($request->role=='1'){
                        return redirect('student-settings')->with('success','Password has been updated successfully.');
                    }else{
                        return redirect('teacher-settings')->with('success','Password has been updated successfully.');
                    }
                    
                }catch(Exception $e){
                    
                    if($request->role=='1'){
                        return redirect('student-settings')->with('error','Please try again!');
                    }else{
                        return redirect('teacher-settings')->with('error','Please try again!');
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
    
    
    
    public function video_update(Request $request){ //echo "aaaaa"; exit();
        
        $data['user'] = $this->registrationModel->where('deleted_at', '=', null)->where(['id'=>session('id')])->first(); 
        
        if(count($request->all()) > 0) {   
            $validator = Validator::make($request->all(), [
                            'id' => 'required',
                            'role' => 'required',
                            'video' => 'required',
                        ]);
                        
            if ($validator->fails()) { 
                if($request->role=='1'){
                    return redirect('student-dashboard');  
                }else{
                    return redirect('teacher-settings')->withErrors($validator)->withInput(); 
                }
                
            }else{
                
                
                $updateData=[];

                $updateData['updated_at'] = date('Y-m-d H:i:s'); 
                
                if($request->hasFile('video')) {
                    $videoFilenameWithExt = $request->file('video')->getClientOriginalName();
                    $vfilename = pathinfo($videoFilenameWithExt, PATHINFO_FILENAME);    // Get just filename 
                    $vfilename = str_replace(' ', '_', $vfilename);
                   
                    $vExtension = $request->file('video')->getClientOriginalExtension();  // Get just ext
                    
                    $videoFileNameToStore = 't_'.$vfilename.'_'.time().'.'.$vExtension;         //Filename to store              
                    $vDestinationPath = storage_path('app/video');
                    
                    $request->file('video')->move($vDestinationPath, $videoFileNameToStore);
                            
                } else {
                    $videoFileNameToStore = '';
                }
                
                
                $updateData['video'] = $videoFileNameToStore;
                
                
                
                try{
                    $this->registrationModel->where('id',$request->id)->update($updateData);
                    
                    if($request->role=='1'){
                        return redirect('student-dashboard');  
                    }else{
                        return redirect('teacher-settings')->with('success','Video has been updated successfully.');
                    }
                    
                }catch(Exception $e){
                    
                    if($request->role=='1'){
                        return redirect('student-dashboard');  
                    }else{
                        return redirect('teacher-settings')->with('error','Please try again!');
                    }
                }
                
                
            }
            
        }else{
            
            if($data['user']->role=='1'){
                return redirect('student-dashboard');  
            }else{
                return view('teacher.setting',$data);
            }
        }
    }
    
    
    public function youtube_link_update(Request $request)
    {
        $data['user'] = $this->registrationModel->where('deleted_at', '=', null)->where(['id'=>session('id')])->first(); 
        
        if(count($request->all()) > 0) {   
            $validator = Validator::make($request->all(), [
                            'id' => 'required',
                            'role' => 'required',
                            'youtube_link' => 'required',
                        ]);
                        
            if ($validator->fails()) { 
                if($request->role=='1'){
                    return redirect('student-dashboard');  
                }else{
                    return redirect('teacher-settings')->withErrors($validator)->withInput(); 
                }
                
            }else{
                
                try{
                    $this->registrationModel->where('id',$request->id)->update(['youtube_link' => $request->youtube_link]);
                    
                    if($request->role=='1'){
                        return redirect('student-dashboard');  
                    }else{
                        return redirect('teacher-profile-edit')->with('success','Youtube link has been updated successfully.');
                    }
                    
                }catch(Exception $e){
                    
                    if($request->role=='1'){
                        return redirect('student-dashboard');  
                    }else{
                        return redirect('teacher-profile-edit')->with('error','Please try again!');
                    }
                }
                
                
            }
            
        }else{
            
            if($data['user']->role=='1'){
                return redirect('student-dashboard');  
            }else{
                return view('teacher.setting',$data);
            }
        }
    }
    
    
    
    
    public function teacher_availability_settings_update(Request $request){
        
        $data['user'] = $this->registrationModel->where('deleted_at', '=', null)->where(['id'=>session('id')])->first(); 
        //echo "<pre>"; print_r($_POST); exit();
        
        if(count($request->all()) > 0) {   
            $validator = Validator::make($request->all(), [
                            'id' => 'required',
                            'role' => 'required',
                            'teacher_auto_accept_from' => 'required',
                            'lesson_request_from' => 'required',
                            'teacher_auto_accept_status' => 'required',
                        ]);
                        
            if ($validator->fails()) { 
                if($request->role=='1'){
                    return redirect('student-dashboard'); 
                }else{
                    return redirect('lesson-management')->withErrors($validator)->withInput(); 
                }
                
            }else{
                
                
                $updateData=[];

                $updateData['updated_at'] = date('Y-m-d H:i:s'); 
                
                
                if($request->has('lesson_request_from')){
                    $updateData['lesson_request_from'] = $request->lesson_request_from;
                }
                if($request->has('teacher_auto_accept_status')){
                    $updateData['teacher_auto_accept_status'] = $request->teacher_auto_accept_status;
                }
                if($request->has('teacher_auto_accept_from')){
                    $updateData['teacher_auto_accept_from'] = $request->teacher_auto_accept_from;
                }
                
                
                try{
                    $this->registrationModel->where('id',$request->id)->update($updateData);
                    
                    if($request->role=='1'){
                        return redirect('student-dashboard'); 
                    }else{
                        return redirect('lesson-management')->with('success','Availability settings has been updated successfully.');
                    }
                    
                }catch(Exception $e){
                    
                    if($request->role=='1'){
                        return redirect('student-dashboard'); 
                    }else{
                        return redirect('lesson-management')->with('error','Please try again!');
                    }
                }
                
                
            }
            
        }else{
            
            if($data['user']->role=='1'){
                return view('student.dashboard',$data);
            }else{
                return view('teacher.lessons',$data);
            }
        }
    }
 
    
    
    public function teacher_booking_settings_update(Request $request){
        
        $data['user'] = $this->registrationModel->where('deleted_at', '=', null)->where(['id'=>session('id')])->first(); 
        //echo "<pre>"; print_r($_POST); exit();
        
        if(count($request->all()) > 0) {   
            $validator = Validator::make($request->all(), [
                            'id' => 'required',
                            'role' => 'required',
                            'instant_tutoring' => 'required',
                            'booking_window' => 'required',
                        ]);
                        
            if ($validator->fails()) { 
                if($request->role=='1'){
                    return redirect('student-dashboard'); 
                }else{
                    return redirect('lesson-management')->withErrors($validator)->withInput(); 
                }
                
            }else{
                
                
                $updateData=[];

                $updateData['updated_at'] = date('Y-m-d H:i:s'); 
                
                
                if($request->has('instant_tutoring')){
                    $updateData['instant_tutoring'] = $request->instant_tutoring;
                }
                if($request->has('booking_window')){
                    $updateData['booking_window'] = $request->booking_window;
                }
                
                
                try{
                    $this->registrationModel->where('id',$request->id)->update($updateData);
                    
                    if($request->role=='1'){
                        return redirect('student-dashboard'); 
                    }else{
                        return redirect('lesson-management')->with('success','Lesson booking settings has been updated successfully.');
                    }
                    
                }catch(Exception $e){
                    
                    if($request->role=='1'){
                        return redirect('student-dashboard'); 
                    }else{
                        return redirect('lesson-management')->with('error','Please try again!');
                    }
                }
                
                
            }
            
        }else{
            
            if($data['user']->role=='1'){
                return view('student.dashboard',$data);
            }else{
                return view('teacher.lessons',$data);
            }
        }
    }
    
    
    
    public function teacher_education_update(Request $request){
        
        if(count($request->all()) > 0) { 
            
            $validator = Validator::make($request->all(), [
                            'education_year' => 'required',
                            'education_lang' => 'required',
                            'education_file' => 'required',
                        ]);
            
            
                        
            if ($validator->fails()) { 
                if($request->role=='1'){
                    return redirect('student-settings')->withErrors($validator)->withInput(); 
                }else{
                    return redirect('teacher-profile-edit')->withErrors($validator)->withInput(); 
                }
                
            }else{
                
                
                $updateData=[];

                $updateData['updated_at'] = date('Y-m-d H:i:s'); 
                
                
                $educationArr = array();
                
                if($request->hasFile('education_file')) {
                    $educationFilenameWithExt = $request->file('education_file')->getClientOriginalName();
                    $educationFilename = pathinfo($educationFilenameWithExt, PATHINFO_FILENAME);    // Get just filename    
                    $educationFilename = str_replace(' ', '_', $educationFilename);
                   
                    $educationFilename_extension = $request->file('education_file')->getClientOriginalExtension();  // Get just ext
                    
                    $educationFileNameToStore = 't_'.$educationFilename.'_'.time().'.'.$educationFilename_extension;         //Filename to store              
                    $educationFilename_destinationPath = storage_path('app/education_file');
                    
                    $request->file('education_file')->move($educationFilename_destinationPath, $educationFileNameToStore);
                            
                } else {
                    $educationFileNameToStore = '';
                }
                
                $educationArr[] = [
                                    'education_year' => $request->education_year,
                                    'education_lang' => $request->education_lang,
                                    'education_file' => $educationFileNameToStore
                                ];
                
                $educationJson = json_encode($educationArr);
                
                if($request->has('education_year') && $request->has('education_lang')){
                    $updateData['education'] = $educationJson; 
                }
                
                
                
                try{
                    $this->registrationModel->where('id',session('id'))->update($updateData);
                    
                    if($request->role=='1'){
                        return redirect('student-settings')->with('success','Education has been added successfully.');
                    }else{
                        return redirect('teacher-profile-edit')->with('success','Education has been added successfully.');
                    }
                    
                }catch(Exception $e){
                    
                    if($request->role=='1'){
                        return redirect('student-settings')->with('error','Please try again!');
                    }else{
                        return redirect('teacher-profile-edit')->with('error','Please try again!');
                    }
                }
                
                
            }
            
        }else{
            
            
        }
    }
    
    
    public function teacher_work_exp_update(Request $request){
        
        if(count($request->all()) > 0) { 
            
            $validator = Validator::make($request->all(), [
                            'experience_year' => 'required',
                            'designation' => 'required',
                            'organization' => 'required',
                        ]);
            
            
                        
            if ($validator->fails()) { 
                if($request->role=='1'){
                    return redirect('student-settings')->withErrors($validator)->withInput(); 
                }else{
                    return redirect('teacher-profile-edit')->withErrors($validator)->withInput(); 
                }
                
            }else{
                
                
                $updateData=[];

                $updateData['updated_at'] = date('Y-m-d H:i:s'); 
                
                
                $experienceArr = array();
                
                $experienceArr[] = [
                                    'experience_year' => $request->experience_year,
                                    'designation' => $request->designation,
                                    'organization' => $request->organization
                                ];
                
                $experienceJson = json_encode($experienceArr);
                
                if($request->has('experience_year') && $request->has('designation') && $request->has('organization')){
                    $updateData['experience'] = $experienceJson; 
                }
                
                
                
                try{
                    $this->registrationModel->where('id',session('id'))->update($updateData);
                    
                    if($request->role=='1'){
                        return redirect('student-settings')->with('success','Work experience has been added successfully.');
                    }else{
                        return redirect('teacher-profile-edit')->with('success','Work experience has been added successfully.');
                    }
                    
                }catch(Exception $e){
                    
                    if($request->role=='1'){
                        return redirect('student-settings')->with('error','Please try again!');
                    }else{
                        return redirect('teacher-profile-edit')->with('error','Please try again!');
                    }
                }
                
                
            }
            
        }else{
            
            
        }
    }
    
    
    public function teacher_certificate_update(Request $request){
        
        if(count($request->all()) > 0) { 
            
            $validator = Validator::make($request->all(), [
                            'certificate_year' => 'required',
                            'certificate_designation' => 'required',
                            'certificate_organization' => 'required',
                        ]);
            
            
                        
            if ($validator->fails()) { 
                if($request->role=='1'){
                    return redirect('student-settings')->withErrors($validator)->withInput(); 
                }else{
                    return redirect('teacher-profile-edit')->withErrors($validator)->withInput(); 
                }
                
            }else{
                
                
                $updateData=[];

                $updateData['updated_at'] = date('Y-m-d H:i:s'); 
                
                
                $certificateArr = array();
                
                $certificateArr[] = [
                                    'certificate_year' => $request->certificate_year,
                                    'certificate_designation' => $request->certificate_designation,
                                    'certificate_organization' => $request->certificate_organization
                                ];
                
                $certificateJson = json_encode($certificateArr);
                
                if($request->has('certificate_year') && $request->has('certificate_designation') && $request->has('certificate_organization')){
                    $updateData['certificate'] = $certificateJson; 
                }
                
                
                
                try{
                    $this->registrationModel->where('id',session('id'))->update($updateData);
                    
                    if($request->role=='1'){
                        return redirect('student-settings')->with('success','Work experience has been added successfully.');
                    }else{
                        return redirect('teacher-profile-edit')->with('success','Work experience has been added successfully.');
                    }
                    
                }catch(Exception $e){
                    
                    if($request->role=='1'){
                        return redirect('student-settings')->with('error','Please try again!');
                    }else{
                        return redirect('teacher-profile-edit')->with('error','Please try again!');
                    }
                }
                
                
            }
            
        }else{
            
            
        }
    }
    
}



?>
<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Session;
use Validator;
use Hash;
use DB;

use App\Models\Registration;

use Illuminate\Support\Facades\Storage;

use App\Mail\Register;
use Illuminate\Support\Facades\Mail;


class RegistrationController extends Controller
{
    protected $registrationModel;
    public function __construct(){
        $this->registrationModel = new Registration;
    }
    
    public function index()
    {

        Session::put('email_verify_stat', 0);
        Session::put('phone_verify_stat', 0);
        
        if(session('role')=='1'){
            return redirect('student-dashboard');
        }elseif(session('role')=='2'){
            return redirect('teacher-dashboard');
        }else{
            return view('user/register');
        }
        
    }
    
    public function teacher_registration(Request $request)
    {
 
        if(count($request->all()) > 0) {   
            
        
            $validator = Validator::make($request->all(), [
                            'display_name' => 'required',
                            'teacher_type' => 'required',
                            'video_conferencing_platform' => 'required',
                            'user_account_id' => 'required',
                            'dob' => 'required|date_format:Y-m-d',
                            'email' => 'required',
                            'phone' => 'required',
                            'password' => 'required',
                            'gender' => 'required',
                            'street_address'=>'required',
                            'about_me'=>'required',
                            'about_my_lessons'=>'required',
                            //'scanned_id_proof'=>'required',
                        ]);


            if ($validator->fails()) { 
                return redirect('teacher-registration')->withErrors($validator)->withInput(); 
            }else{
                
                $rowCount = $this->registrationModel->select(DB::raw('count(*) as count'))->where('email', '=', $request->email)->where('deleted_at', '=', null)->count();
                if($rowCount>0){
                    return redirect('teacher-registration')->with('error','Email id already exist!')->withInput();
                }
                
                if($request->phone!=''){
                    $rowCount = $this->registrationModel->select(DB::raw('count(*) as count'))->where('phone_number', '=', $request->phone)->where('deleted_at', '=', null)->count();
                    if($rowCount>0){
                        return redirect('teacher-registration')->with('error','Phone number already exist!')->withInput();
                    }
                }
                
                $youtubeLink = '';
                if($request->has('youtube_link')){
                    /*$headers = get_headers('http://www.youtube.com/oembed?url='.$request->youtube_link); 
                    if (!strpos($headers[0], '200')) {
                        return redirect('teacher-registration')->with('error','The YouTube video you entered does not exist!')->withInput();
                    }else{*/
                        $youtubeLink = $request->youtube_link;
                    //}
                }
                
                
                
                // Handle Profile Photo File Upload ================================================================
                if($request->hasFile('teacher_phpto')) {
                    $filenameWithExt = $request->file('teacher_phpto')->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);    // Get just filename 
                    $filename = str_replace(' ', '_', $filename);
                   
                    $extension = $request->file('teacher_phpto')->getClientOriginalExtension();  // Get just ext
                    
                    $photoFileNameToStore = 't_'.$filename.'_'.time().'.'.$extension;         //Filename to store              
                    $destinationPath = storage_path('app/user_photo');
                    
                    $request->file('teacher_phpto')->move($destinationPath, $photoFileNameToStore);
                            
                } else {
                    $photoFileNameToStore = 'noimage.jpg';
                }
                
                
                // Handle Profile Video File Upload ================================================================
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
                
                
                
                // Handle Photo ID File Upload ======================================================================
                if($request->hasFile('scanned_id_proof')) {
                    $photoIDFilenameWithExt = $request->file('scanned_id_proof')->getClientOriginalName();
                    $photoIDFilename = pathinfo($photoIDFilenameWithExt, PATHINFO_FILENAME);    // Get just filename   
                    $photoIDFilename = str_replace(' ', '_', $photoIDFilename);
                   
                    $photoID_extension = $request->file('scanned_id_proof')->getClientOriginalExtension();  // Get just ext
                    
                    $photoIDFileNameToStore = 't_'.$photoIDFilename.'_'.time().'.'.$photoID_extension;         //Filename to store              
                    $photoID_destinationPath = storage_path('app/photoID');
                    
                    $request->file('scanned_id_proof')->move($photoID_destinationPath, $photoIDFileNameToStore);
                            
                } else {
                    $photoIDFileNameToStore = 'noimage.jpg';
                }
                
                
                
                
                // Handle Photo ID File Upload ======================================================================
                if($request->hasFile('applicant_with_scanned_id_proof')) {
                    $photoIDwithApplicantFilenameWithExt = $request->file('applicant_with_scanned_id_proof')->getClientOriginalName();
                    $photoIDwithApplicantFilename = pathinfo($photoIDwithApplicantFilenameWithExt, PATHINFO_FILENAME);    // Get just filename  
                    $photoIDwithApplicantFilename = str_replace(' ', '_', $photoIDwithApplicantFilename);
                   
                    $photoID_withApplicant_extension = $request->file('applicant_with_scanned_id_proof')->getClientOriginalExtension();  // Get just ext
                    
                    $photoIDwithApplicantFileNameToStore = 't_'.$photoIDwithApplicantFilename.'_'.time().'.'.$photoID_withApplicant_extension;         //Filename to store              
                    $photoIDwithApplicant_destinationPath = storage_path('app/applicant_with_photoID_proof');
                    
                    $request->file('applicant_with_scanned_id_proof')->move($photoIDwithApplicant_destinationPath, $photoIDwithApplicantFileNameToStore);
                            
                } else {
                    $photoIDwithApplicantFileNameToStore = 'noimage.jpg';
                }
                
                //echo "photoID:== <pre>".$photoIDwithApplicantFileNameToStore;  //print_r($_FILES);
                //exit();
                
                
                $languageArr = array();
                for ($i=0; $i < count($request->language); $i++ )
                {
                    if(!empty($request->language)){
                        $languageArr[] = [
                                            'language' => $request->language[$i],
                                            'level' => $request->lang_level[$i]
                                        ];
                    }
                }
                
                $languageJson = json_encode($languageArr);
                
                
                
                $taughtLanguageArr = array();
                if(($request->taught_lang)){
                    for ($j=0; $j < count($request->taught_lang); $j++ )
                    {
                        if(!empty($request->taught_lang)){
                            $taughtLanguageArr[] = [
                                                        'language' => $request->taught_lang[$j]
                                                    ];
                        }
                    }
                    
                    $taughtLanguageJson = json_encode($taughtLanguageArr);
                }
                
                
                
                
                
                $educationArr = array();
                if($request->education_year){
                    for ($k=0; $k < count($request->education_year); $k++ )
                    {
                        if($request->education_year[$k]!='' && $request->education_lang[$k]!=''){
                            if($request->education_file[$k]==''){$request->education_file[$k] = '';}
                            
                            if($request->hasFile('education_file')) {
                                $educationFilenameWithExt = $request->file('education_file')[$k]->getClientOriginalName();
                                $educationFilename = pathinfo($educationFilenameWithExt, PATHINFO_FILENAME);    // Get just filename    
                                $educationFilename = str_replace(' ', '_', $educationFilename);
                               
                                $educationFilename_extension = $request->file('education_file')[$k]->getClientOriginalExtension();  // Get just ext
                                
                                $educationFileNameToStore = 't_'.$educationFilename.'_'.time().'.'.$educationFilename_extension;         //Filename to store              
                                $educationFilename_destinationPath = storage_path('app/education_file');
                                
                                $request->file('education_file')[$k]->move($educationFilename_destinationPath, $educationFileNameToStore);
                                        
                            } else {
                                $educationFileNameToStore = '';
                            }
                            
                            $educationArr[] = [
                                                'education_year' => $request->education_year[$k],
                                                'education_lang' => $request->education_lang[$k],
                                                'education_file' => $educationFileNameToStore
                                            ];
                        }
                    }
                    
                    $educationJson = json_encode($educationArr);
                }
                
                
                
                
                
                $educationArr = array();
                if($request->education_year){
                    for ($m=0; $m < count($request->education_year); $m++ )
                    {
                        if(!empty($request->education_year) && !empty($request->education_lang) && !empty($request->education_file)){
                            $educationArr[] = [
                                                'education_year' => $request->education_year[$m],
                                                'education_lang' => $request->education_lang[$m],
                                                'education_file' => $request->education_file[$m]
                                            ];
                        }else{
                            $educationArr = null;
                        }
                    }
                    
                    $educationJson = json_encode($educationArr);
                }
                
                
                
                
                
                
                $experienceArr = array();
                if($request->experience_year){
                    for ($n=0; $n < count($request->experience_year); $n++ )
                    {
                        if(!empty($request->experience_year)){
                            $experienceArr[] = [
                                                'experience_year' => $request->experience_year[$n],
                                                'designation' => $request->designation[$n],
                                                'organization' => $request->organization[$n]
                                            ];
                        }
                    }
                    
                    $experienceJson = json_encode($experienceArr);
                }
                
                
                
                
                
                $certificateArr = array();
                if($request->certificate_year){
                    for ($p=0; $p < count($request->certificate_year); $p++ )
                    {
                        if(!empty($request->certificate_year)){
                            $certificateArr[] = [
                                                'certificate_year' => $request->certificate_year[$p],
                                                'certificate_designation' => $request->certificate_designation[$p],
                                                'certificate_organization' => $request->certificate_organization[$p]
                                            ];
                        }
                    }
                    
                    $certificateJson = json_encode($certificateArr);
                }
                
                
                


                
                $password = Hash::make($request->password);
                
                $insertData = [
                                'role'=>'2',
                                'original_mode'=>'2',
                                'password'=>$password,
                                'name'=>ucfirst($request->display_name),
                                'teacher_type'=>$request->teacher_type, 
                                'email'=>$request->email,
                                'phone_number'=>$request->phone,
                                'video_conferencing_platform'=>$request->video_conferencing_platform,  
                                'user_account_id'=>$request->user_account_id, 
                                'country_of_origin'=>$request->country_of_origin, 
                                'country_living_in'=>$request->country_living_in, 
                                'dob'=>$request->dob,
                                'gender'=>$request->gender, 
                                'address'=>$request->street_address, 
                                'languages_spoken'=>$languageJson,
                                'languages_taught'=>$taughtLanguageJson,
                                'education'=>$educationJson,
                                'experience'=>$experienceJson,
                                'certificate'=>$certificateJson,
                                'about_me'=>$request->about_me, 
                                'about_my_lessons'=>$request->about_my_lessons,
                                'profile_photo'=>$photoFileNameToStore,
                                'video'=>$videoFileNameToStore,
                                'youtube_link'=>$youtubeLink,
                                'scanned_id_proof'=>$photoIDFileNameToStore,
                                'applicant_with_scanned_id_proof'=>$photoIDwithApplicantFileNameToStore,
                                'status'=>'0',
                                'created_at'=>date('Y-m-d H:i:s')
                            ];
                            
                $insertId = $this->registrationModel->insertGetId($insertData); 
                
                //echo "<pre>"; print_r($insertData); 
                //exit(); 
                
                if($insertId!=''){
                    // Send Email =========================================================
                    
                    $subject = 'We received your application!';
                    $message = 'Thank you for registering to be a teacher with Tokatif. We will review your application and respond to you within 3 business days.';
                    
                    $details = [
                        'to' => $request->email,
                        'from' => env('MAIL_FROM_ADDRESS'),
                        'subject' => $subject,
                        'receiver' => ucfirst($request->display_name),
                        'sender' => env('MAIL_FROM_NAME'), 
                        'msg'=>$message
                    ];

                    Mail::to($request->email)->send(new Register($details));
                    
                    return redirect('teacher-registration')->with('success','Thank you for submitting your application. A Tokatif team member will be in touch with you shortly.');
                }else{
                    return redirect('teacher-registration')->with('error','Please try again!'); 
                }
                            
                            
            }
        }
        
        
        $data['countries'] = DB::table('countries')->get();
        $data['languages'] = DB::table('languages')->get();
        //echo "<pre>"; print_r($data['countries']); exit(); 
        
        if(session('role')=='1'){
            return redirect('student-dashboard');
        }elseif(session('role')=='2'){
            return redirect('teacher-dashboard');
        }else{
            return view('user/teacher-registration',$data); 
        }
        
    }
    
    public function registeruser(Request $req)
    {
        //register user by mail

        $status_of_mail = Session::get('email_verify_stat');
        
        $rowCount = $this->registrationModel->select(DB::raw('count(*) as count'))->where('email', '=', $req->user_email)->where('deleted_at', '=', null)->count();
        

        if($status_of_mail == 1)
        {
            if($rowCount==0){
                
                $registration = new Registration;
                $password = Hash::make($req->user_password);
                $registration->name	 = $req->user_name;
                $registration->email =  $req->user_email;
                $registration->role  =  1;
                $registration->original_mode = '1';
                $registration->password = $password;
        
                $data =  $registration->save();
                
                if($data){
                    Session::put('email_verify_stat', 0);
                    $res = array("status"=>200,"message"=>"Registered Successfully");
                }else{
                    $res = array("status"=>201,"message"=>"Some Other Data"); 
                }
                
            }else{
                $res = array("status"=>202,"message"=>"Email is already registered with us. Please try another email!!");  
            }
            
            
        }else{
                $res = array("status"=>202,"message"=>"Your email is not verified.Please verify your Email."); 
        }

        return json_encode($res);


    }


    public function authorisationcode(Request $req)
    {
        $user_email =  $req->user_email;
        $user_present = Registration::where('email',$user_email)->where('role',1)->first();
      
      
        if($user_present == null)
        {
        $rand_number=rand(0000,9999);
        
        $message = "<p>Your authorization code For Registration is :- ".$rand_number."</p>";
        
        //$to  = $user_email;

        $emailres = emailsend($user_email,$message);

        if($emailres['Stat'] == 1)
        {
            Session::put('authorization_code', $rand_number);
            Session::put('email_mail_sent', $user_email);
            $res = array("status"=>200,"message"=>"Code Has Been Sent.Please Verify Your Email.");
        }
        
         }
         else if($user_present)
         {
            $res = array("status"=>201,"message"=>"Your Email Already Exists.Try with another Email");
         }
        

        return json_encode($res);
        
    }


     
    public function authorisationcode_check(Request $req)
    {
        
        $authorization_code = $req->verificationcode;
        $email = Session::get('email_mail_sent');
        $code = Session::get('authorization_code');
        if(Session::get('authorization_code') == $authorization_code)
        {
            Session::put('email_verify_stat', 1);
            $res = array("status"=>200,"message"=>"Authorization Code Verified Successfully"); 
        }
        else
        {
             $res = array("status"=>201,"message"=>"Invalid Authorization Code.Please Enter Valid Authorization Code");
        }
        
        echo json_encode($res);
    }



    public function registeruserphone(Request $req)
    {
        //register user by phone

        $status_of_phone = Session::get('phone_verify_stat');


        if($status_of_phone == 1)
        {
            $password = Hash::make($req->user_password);

            $registration = new Registration;
            $registration->name	 = $req->user_name_phone;
            $registration->country_code	 = $req->country_code;
            $registration->phone_number =  $req->phone_number;
            $registration->role  =  1;
            $registration->original_mode = '1';
            $registration->password = $password;
    
            $data =  $registration->save();
    
            if($data)
            {
                Session::put('phone_verify_stat', 0);
                $res = array("status"=>200,"message"=>"Registered Successfully");
            }
            else{
    
                $res = array("status"=>201,"message"=>"Some Other Data"); 
            }
        }
        else{
                $res = array("status"=>202,"message"=>"Your Phone Number is not verified.Please verify your Phone."); 
        }

     

        return json_encode($res);

    }


    // Register with phone area

    public function authorisationcodephone(Request $req)
    {
        $user_phone_number =  $req->phone_number;
        $user_present = Registration::where('phone_number',$user_phone_number)->first();
      
      
        if($user_present == null)
        {
        $rand_number= "1234";
        //$rand_number=rand(0000,9999);
        
        $message = "<p>Your authorization code For Registration is :- ".$rand_number."</p>";
        
        $emailres['Stat'] = 1;
        if($emailres['Stat'] == 1)
        {
            Session::put('authorization_code_phone', $rand_number);
            Session::put('code_phone_sent', $user_phone_number);
            $res = array("status"=>200,"message"=>"Code Has Been Sent.Please Verify Your Phone Number.");
        }
        
         }
         else if($user_present)
         {
            $res = array("status"=>201,"message"=>"Your Phone Number Already Exists.Try with another Phone Number");
         }
        

        return json_encode($res);
        
    }

    
    
    public function authorisationcode_checkphone(Request $req)
    {
        
        
       
        $authorization_code = $req->verification_code_phone;
        $phone_number = Session::get('code_phone_sent');
        $code = Session::get('authorization_code_phone');
        // echo $code;
        // echo $authorization_code;
        /* echo $number."===========".$this->session->userdata('tenant_id');
        echo $otp."===========".$this->session->userdata('otp_number');*/
        if(Session::get('authorization_code_phone') == $authorization_code)
        {
            Session::put('phone_verify_stat', 1);
            $res = array("status"=>200,"message"=>"Authorization Code Verified Successfully"); 
        }
        else
        {
             $res = array("status"=>201,"message"=>"Invalid Authorization Code.Please Enter Valid Authorization Code");
        }
        
        echo json_encode($res);
    }

    public function login()
    {
        return view('user/login');
    }


    public function loginuser(Request $req)
    {
        $user_password =  $req->password;
        $user_name =  $req->user_name;

    

          if(filter_var($user_name, FILTER_VALIDATE_EMAIL)) 
          {
            // echo "email";
           $response =  Registration::where('email',$user_name)->where('role',1)->first();
       
           if($response != null)
           {
      
           if(Hash::check($user_password , $response->password)) {
            
            $results = array("status"=>200,"message"=>"Login Successfull");

        } else {

            $results = array("status"=>201,"message"=>"Invalid Username Or Password");
            // return response()->json(['status'=>'false', 'message'=>'password is wrong']);
        }

         }
         else
         {
            $results = array("status"=>201,"message"=>"Invalid Username Or Password");  
         }

          }
          else{
           // echo "numbers";
           $response = Registration::where('phone_number',$user_name)->where('role',1)->first();
          // print_r($response);
          
           //$arcount = count($response);

           if($response != null)
           {

           

                if(Hash::check($user_password , $response->password)) {
                    
                    $results = array("status"=>200,"message"=>"Login Successfull");

                } else {

                    $results = array("status"=>201,"message"=>"Invalid Username Or Password");
                    // return response()->json(['status'=>'false', 'message'=>'password is wrong']);
                }
           }
           else{

                    $results = array("status"=>201,"message"=>"Invalid Username Or Password");
           }
           
          }


          echo json_encode($results);
    }


}

<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Registration;
use App\Models\Lessons;
use App\Models\LessonPackages;
use App\Models\TeacherAvailability;
use App\Models\Booking;
use App\Models\Transaction;
use App\Models\WalletLog;
use App\Models\CardDetail;
use App\Models\LessonLog;
use App\Models\AdminWallet;
use App\Models\AdminWalletLog;
use App\Models\FeedbackRating;
use App\Models\StudentLesson;

use Session;
use Validator;
use Hash;
use DB;
use Carbon\Carbon;

use Illuminate\Support\Facades\Storage;

use App\Mail\LessonBooking;
use Illuminate\Support\Facades\Mail;


class BookingController extends Controller
{
    protected $registrationModel;
    protected $lessonsModel;
    protected $lessonPackagesModel;
    protected $teacherAvailabilityModel;
    protected $bookingModel;
    protected $transactionModel;
    protected $walletLogModel;
    protected $cardDetailModel;
    protected $lessonLogModel;
    protected $adminWalletModel;
    protected $adminWalletLogModel;
    protected $feedbackRatingModel;
    
    public function __construct(){
        $this->registrationModel = new Registration;
        $this->lessonsModel = new Lessons;
        $this->lessonPackagesModel = new LessonPackages;
        $this->teacherAvailabilityModel = new TeacherAvailability;
        $this->bookingModel = new Booking;
        $this->transactionModel = new Transaction;
        $this->walletLogModel = new WalletLog;
        $this->cardDetailModel = new CardDetail;
        $this->lessonLogModel = new LessonLog;
        $this->adminWalletModel = new AdminWallet;
        $this->adminWalletLogModel = new AdminWalletLog;
        $this->feedbackRatingModel = new FeedbackRating;
    }
    
    /*public function index(){ 
        $data['title']="Booking";
        $data['breadcrumb']='Booking';

        
        $data['user'] = $this->registrationModel->where('deleted_at', '=', null)->where(['id'=>session('id')])->first(); 
        //echo $data['user']->role; die();

        if($data['user']->role=='1'){
            return view('student.dashboard',$data);
        }else{
            return view('teacher.dashboard',$data);
        }

        
    }*/
    
    
    
    public function lesson_booking($id){ //echo "qqqqq:: ".$id; exit(); 
        $data['title']="Booking";
        $data['breadcrumb']='Booking';
        
        
        $data['user'] = $this->registrationModel->where('deleted_at', '=', null)->where('status', '=', '1')->where(['id'=>session('id')])->first(); 
        //echo $data['user']->role; die();

        $teacher_id = $id;
        $data['lessons'] = $this->lessonsModel->where('deleted_at', '=', null)->where(['user_id'=>$teacher_id])->get(); 

        $data['availability'] = $this->teacherAvailabilityModel->where('user_id', '=', $teacher_id)->get(); 

        $data['selected_teacher'] = $this->registrationModel->where('deleted_at', '=', null)->where('status', '=', '1')->where(['id'=>$teacher_id])->first();

        $booking_data = StudentLesson::select('booking_date','booking_time','slots')->where('teacher_id',$teacher_id)->get();

        $data['bookings'] = [];
        foreach($booking_data as $booking)
        {
            $data['bookings'][] = [ 'booking_date' => $booking->booking_date, 'booking_time' => $booking->booking_time];
            if($booking->slots == 2)
            {
                $time = strtotime($booking->booking_time);
                $second_slot_time = date("H:i", strtotime('+30 minutes', $time));
                $data['bookings'][] = [ 'booking_date' => $booking->booking_date, 'booking_time' => $second_slot_time];
            }
            else if($booking->slots == 3)
            {
                $time = strtotime($booking->booking_time);
                $second_slot_time = date("H:i", strtotime('+30 minutes', $time));
                $third_slot_time = date("H:i", strtotime('+60 minutes', $time));

                $data['bookings'][] = [ 'booking_date' => $booking->booking_date, 'booking_time' => $second_slot_time];
                $data['bookings'][] = [ 'booking_date' => $booking->booking_date, 'booking_time' => $third_slot_time];
            }
        }

        if($data['user']->role=='2'){
            return redirect('teacher-dashboard');
        }else{
            return view('student.lesson-booking',$data);
        }
    }


    public function next_month_calendar(Request $request)
    {
        $data['title']="Booking";
        $data['breadcrumb']='Booking';

        $data['week'] = $request->week;
        $data['year'] = $request->year;

        $data['user'] = $this->registrationModel->where('deleted_at', '=', null)->where('status', '=', '1')->where(['id'=>session('id')])->first();

        $teacher_id = $request->id;
        $data['lessons'] = $this->lessonsModel->where('deleted_at', '=', null)->where(['user_id'=>$teacher_id])->get(); 

        $data['availability'] = $this->teacherAvailabilityModel->where('user_id', '=', $teacher_id)->get(); 

        $data['selected_teacher'] = $this->registrationModel->where('deleted_at', '=', null)->where('status', '=', '1')->where(['id'=>$teacher_id])->first();

        $data['exists'] = file_exists( storage_path() . '/app/user_photo/' . $data['selected_teacher']->profile_photo );

        $booking_data = StudentLesson::select('booking_date','booking_time','slots')->where('teacher_id',$teacher_id)->get();

        $data['bookings'] = [];
        foreach($booking_data as $booking)
        {
            $data['bookings'][] = [ 'booking_date' => $booking->booking_date, 'booking_time' => $booking->booking_time];
            if($booking->slots == 2)
            {
                $time = strtotime($booking->booking_time);
                $second_slot_time = date("H:i", strtotime('+30 minutes', $time));
                $data['bookings'][] = [ 'booking_date' => $booking->booking_date, 'booking_time' => $second_slot_time];
            }
            else if($booking->slots == 3)
            {
                $time = strtotime($booking->booking_time);
                $second_slot_time = date("H:i", strtotime('+30 minutes', $time));
                $third_slot_time = date("H:i", strtotime('+60 minutes', $time));

                $data['bookings'][] = [ 'booking_date' => $booking->booking_date, 'booking_time' => $second_slot_time];
                $data['bookings'][] = [ 'booking_date' => $booking->booking_date, 'booking_time' => $third_slot_time];
            }
        }

        $data['flag'] = $request->flag;
        $data['teacherType'] = $request->teacherType;
        $data['id'] = $request->id;

        return view('student.next_month_calendar', $data);
    }

    public function bookPendingLesson($booking_id)
    {
        $data['title']="Booking";
        $data['breadcrumb']='Booking';

        $data['week'] = (isset($_GET['week'])) ? $_GET['week'] : null;
        $data['year'] = (isset($_GET['year'])) ? $_GET['year'] : null;

        $booking = Booking::select(['lessons.*','booking.*','lesson_packages.*','booking.id as booking_id'])
                            ->join('lessons','lessons.id','=','booking.lesson_id')
                            ->join('lesson_packages', 'booking.lesson_package_id', '=', 'lesson_packages.id')
                            ->where('booking.id', $booking_id)->first();

        $data['booking_data'] = $booking;

        $data['user'] = $this->registrationModel->where('deleted_at', '=', null)->where('status', '=', '1')->where(['id'=>session('id')])->first(); 
        //echo $data['user']->role; die();
        $data['student_booked_lessons'] = StudentLesson::where('booking_id', $booking_id)->get();

        $teacher_id = $booking->teacher_id;
        $data['lessons'] = $this->lessonsModel->where('deleted_at', '=', null)->where(['user_id'=>$teacher_id])->get(); 

        $data['availability'] = $this->teacherAvailabilityModel->where('user_id', '=', $teacher_id)->get(); 

        $data['selected_teacher'] = $this->registrationModel->where('deleted_at', '=', null)->where('status', '=', '1')->where(['id'=>$teacher_id])->first();

        $booking_data = StudentLesson::select('booking_date','booking_time','slots')->where('teacher_id',$teacher_id)->get();

        $package_lesson = 0;
        if($booking->package == "5 lessons")
        {
            $package_lesson = 5;
        }
        else if($booking->package == "10 lessons")
        {
            $package_lesson = 10;
        }
        else if($booking->package == "20 lessons")
        {
            $package_lesson = 20;
        }

        $data['pending_lesson'] = ($package_lesson - count($booking_data));

        $data['bookings'] = [];
        foreach($booking_data as $booking)
        {
            $data['bookings'][] = [ 'booking_date' => $booking->booking_date, 'booking_time' => $booking->booking_time];
            if($booking->slots == 2)
            {
                $time = strtotime($booking->booking_time);
                $second_slot_time = date("H:i", strtotime('+30 minutes', $time));
                $data['bookings'][] = [ 'booking_date' => $booking->booking_date, 'booking_time' => $second_slot_time];
            }
            else if($booking->slots == 3)
            {
                $time = strtotime($booking->booking_time);
                $second_slot_time = date("H:i", strtotime('+30 minutes', $time));
                $third_slot_time = date("H:i", strtotime('+60 minutes', $time));

                $data['bookings'][] = [ 'booking_date' => $booking->booking_date, 'booking_time' => $second_slot_time];
                $data['bookings'][] = [ 'booking_date' => $booking->booking_date, 'booking_time' => $third_slot_time];
            }
        }

        $student_lessons = StudentLesson::where('lesson_package_id', $booking->lesson_package_id)->get();

        $data['id'] = $teacher_id;

        return view('student.book_pending_lessons', $data);
    }

    public function postBookPendingLesson($booking_id, Request $request)
    {
        if($request->booking_dates)
        {
            $booking = Booking::select(['booking.*','lesson_packages.*','booking.id as booking_id'])
                                ->join('lessons','lessons.id','=','booking.lesson_id')
                                ->join('lesson_packages', 'booking.lesson_package_id', '=', 'lesson_packages.id')
                                ->where('booking.id', $booking_id)->first();

            $package_lesson = 0;
            if($booking->package == "5 lessons")
            {
                $package_lesson = 5;
            }
            else if($booking->package == "10 lessons")
            {
                $package_lesson = 10;
            }
            else if($booking->package == "20 lessons")
            {
                $package_lesson = 20;
            }

            $student_lessons_data = [];
            $booking_dates = explode(",", $request->booking_dates);
            $booking_times = explode(",", $request->booking_times);

            for($i=0; $i<(count($booking_dates)); $i++)
            {
                $student_lessons_data[] = [
                    'booking_id' => $booking_id,
                    'lesson_id' => (int)$booking->lesson_id,
                    'lesson_package_id' => (int)$booking->lesson_package_id,
                    'slots' => (int)$booking->booking_slots,
                    'teacher_id'=>(int)$booking->teacher_id,
                    'student_id'=>session('id'),
                    'booking_date' => $booking_dates[$i],
                    'booking_time' => $booking_times[$i],
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
            }

            if(count($student_lessons_data))
            {
                StudentLesson::insert($student_lessons_data);
            }

            $student_lessons = StudentLesson::where('booking_id', $booking_id)->get();
            if(count($student_lessons) == $package_lesson)
            {
                Booking::where('id', $booking_id)->update(['status' => '1']);
            }

            return redirect('my-lesson')->with('success','Booking has been created successfully.');
        }
        else
        {
            return redirect('my-lesson')->with('error','Please select available slots.');
        }
    }

    public function get_booking_dates(Request $request)
    {
        Session::forget('b_lesson_package');
        session(['b_lesson_package'=>$request->package_lessons]);

        $booking_data = StudentLesson::select('booking_date','booking_time','slots')->where('teacher_id', $request->teacher_id)->get();

        $bookings = [];
        foreach($booking_data as $booking)
        {
            $bookings[] = [ 'booking_date' => $booking->booking_date, 'booking_time' => $booking->booking_time];
            if($booking->slots == 2)
            {
                $time = strtotime($booking->booking_time);
                $second_slot_time = date("H:i", strtotime('+30 minutes', $time));
                $bookings[] = [ 'booking_date' => $booking->booking_date, 'booking_time' => $second_slot_time];
            }
            else if($booking->slots == 3)
            {
                $time = strtotime($booking->booking_time);
                $second_slot_time = date("H:i", strtotime('+30 minutes', $time));
                $third_slot_time = date("H:i", strtotime('+60 minutes', $time));

                $bookings[] = [ 'booking_date' => $booking->booking_date, 'booking_time' => $second_slot_time];
                $bookings[] = [ 'booking_date' => $booking->booking_date, 'booking_time' => $third_slot_time];
            }
        }

        // $data['booking_date_array'] = [];
        // $data['booking_time_array'] = [];

        // foreach ($bookings as $booking) {
        //     $data['booking_date_array'][] = $booking['booking_date'];
        //     $data['booking_time_array'][] = $booking['booking_time'];
        // }

        echo json_encode($bookings);
    }
    
    
    
    public function insert_booking_data(request $request){  //echo "le:: ".session('b_lesson_id'); exit();
        
        $teacher_id = $_POST['payment_teacher_id'];
        
        if($_POST['payment_lesson_id']!=''){
            $lesson_id = $_POST['payment_lesson_id'];
        }else{
            $lesson_id = session('b_lesson_id');
        }
        
        if($_POST['payment_lesson_package_id']!=''){
            $lesson_package_id = $_POST['payment_lesson_package_id'];
        }else{
            $lesson_package_id = session('b_lesson_package_id');
        }
        
        
        $communication_tool = $_POST['payment_communication_tool'];
        $communication_account_id = $_POST['payment_communication_account_id'];
        
        $booking_date = $_POST['payment_booking_date'];
        $booking_time = $_POST['payment_booking_time'];
        
        if($_POST['payment_booking_amount']!=''){
            $booking_amount = $_POST['payment_booking_amount'];
        }else{
            $booking_amount = session('b_booking_amt');
        }
        
        
        $validator = Validator::make($request->all(), [
                                'payment_teacher_id' => 'required',
                                'payment_booking_date' => 'required|date_format:Y-m-d',
                                'payment_booking_time'=>'required',
                                //'booking_amount'=>'required|numeric',
                            ]);
            

        if ($validator->fails()) { 
            return redirect('lesson-booking/'.$teacher_id)->withErrors($validator)->withInput(); 
        }else{
            
            
            if($booking_amount==''){
                $package = $this->lessonPackagesModel->where('deleted_at', '=', null)->where(['id'=>$lesson_package_id])->first(); 
                $booking_amount = $package->total;
            }
            
            
            $bookingExistCheck = $this->bookingModel->where('teacher_id', '=', $teacher_id)
                                                    ->where('student_id', '=', session('id'))
                                                    ->where('booking_date', '=', $booking_date)
                                                    ->where('booking_time', '=', $booking_time)->get(); 
            

            if(count($bookingExistCheck)>0){
                return redirect('lesson-booking/'.$teacher_id)->with('error','You have already booked a lesson on same date & time!!');
                
            }else{
                
                $teacherData = $this->registrationModel->where('deleted_at', '=', null)->where('id', '=', $teacher_id)->first(); 
                $teacherName = $teacherData->name;
                $teacherEmail = $teacherData->email;
                $teacherAutoAcceptStatus = $teacherData->teacher_auto_accept_status;
                
                if($teacherAutoAcceptStatus=='true'){
                    $teacher_accept_status = '1';
                    $lesson_accept_reject = '1';
                    $action = 'Student sent a lesson request. Teacher also accepted the lesson request.';
                }else{
                    $teacher_accept_status = '0';
                    $lesson_accept_reject = '0';
                    $action = 'Student sent a lesson request. Awaiting response from the teacher.';
                }

                $booking_status = '5';

                $lesson_package = LessonPackages::find($lesson_package_id);
                $booking_dates = explode(",", $request->booking_dates);
                $booking_times = explode(",", $request->booking_times);

                if($lesson_package->package == "5 lessons" && count($booking_dates) == 5)
                {
                    $booking_status = '1';
                }
                else if($lesson_package->package == "10 lessons" && count($booking_dates) == 10)
                {
                    $booking_status = '1';
                }
                else if($lesson_package->package == "20 lessons" && count($booking_dates) == 20)
                {
                    $booking_status = '1';
                }

                $insertData = [
                    'teacher_id'=>$teacher_id,
                    'lesson_id'=>$lesson_id,
                    'lesson_package_id'=>$lesson_package_id, 
                    'booking_date'=>$booking_date, 
                    'booking_time'=>$booking_time,
                    'booking_slots'=> (int)$request->booking_slots,
                    'booking_amount'=>$booking_amount,
                    'communication_tool'=>$communication_tool,
                    'communication_account_id'=>$communication_account_id,
                    'student_id'=>session('id'),
                    'status'=>$booking_status,
                    'teacher_accept_status'=>$teacher_accept_status,
                    'student_accept_status'=>'1',
                    'created_at'=>date('Y-m-d H:i:s')
                ];

                $BookingId = $this->bookingModel->insertGetId($insertData);

                $student_lessons_data = [];

                for($i=0; $i<(count($booking_dates)); $i++)
                {
                    $student_lessons_data[] = [
                        'booking_id' => $BookingId,
                        'lesson_id' => (int)$lesson_id,
                        'lesson_package_id' => (int)$lesson_package_id,
                        'slots' => (int)$request->booking_slots,
                        'teacher_id'=>(int)$teacher_id,
                        'student_id'=>session('id'),
                        'booking_date' => $booking_dates[$i],
                        'booking_time' => $booking_times[$i],
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ];
                }

                if(count($student_lessons_data))
                {
                    StudentLesson::insert($student_lessons_data);
                }


                if($BookingId!=''){
                    $insertTransactionData = [
                                                'booking_id'=>$BookingId,
                                                'user_id'=>session('id'),
                                                'cardholder_name'=>$_POST['payment_cardholder_name'],
                                                'card_no'=>$_POST['payment_card_no'], 
                                                'expiry_month'=>$_POST['payment_expiry_month'], 
                                                'expiry_year'=>$_POST['payment_expiry_year'],
                                                'cvv'=>$_POST['payment_cvv'],
                                                'amount'=>$booking_amount,
                                                'saveinformation'=>$_POST['payment_saveinformation'],
                                                'status'=>null,
                                                'transaction_id'=>null,
                                                'brand'=>null,
                                                'country'=>null,
                                                'created_at'=>date('Y-m-d H:i:s')
                                            ];
                                                
                    $transactionId = $this->transactionModel->insertGetId($insertTransactionData);
                    
                    if($transactionId!=''){
                        $insertWalletLogData = [
                                                'user_id'=>session('id'),
                                                'wallet_amount'=>$booking_amount,
                                                'purpose'=>'tokatif credit debited',
                                                'credit_debit'=>'debit',
                                                'transaction_id'=>null,
                                                'created_at'=>date('Y-m-d H:i:s')
                                            ];
                                            
                                            
                        $walletLogId = $this->walletLogModel->insertGetId($insertWalletLogData);
                        
                        
                        $insertLessonLogData = [
                                                    'lesson_id'=>$lesson_id,
                                                    'lesson_package_id'=>$lesson_package_id,
                                                    'teacher_id'=>$teacher_id,
                                                    'student_id'=>session('id'),
                                                    'booking_id'=>$BookingId,
                                                    'action'=>$action,
                                                    'lesson_accept_reject'=>$lesson_accept_reject,
                                                    'created_at'=>date('Y-m-d H:i:s')
                                                ];

                        $lessonLogId = $this->lessonLogModel->insertGetId($insertLessonLogData);
                        
                        
                        $existAdminWalletData = $this->adminWalletModel->where('deleted_at', '=', null)->where('user_id', '=', session('id'))->first();  
                        
                        if($existAdminWalletData){
                            $adminWalletId = $existAdminWalletData->id;
                            
                            $updateAdminData=[];

                            $updateAdminData['updated_at'] = date('Y-m-d H:i:s'); 
                            
                            $new_wallet_amount = ($existAdminWalletData->wallet_amount + $booking_amount);
                            
                            $updateAdminData['wallet_amount'] = $new_wallet_amount; 
                            
                            try{
                                $this->adminWalletModel->where('id',$existAdminWalletData->id)->update($updateAdminData);
                            }catch(Exception $e){ }
                            
                        }else{
                            
                            $new_wallet_amount = $booking_amount;
                            
                            $insertAdminWalletData = [
                                                    'admin_id'=>1,
                                                    'user_id'=>session('id'),
                                                    'wallet_amount'=>$new_wallet_amount,
                                                    'created_at'=>date('Y-m-d H:i:s')
                                                ];
                            $adminWalletId = $this->adminWalletModel->insertGetId($insertAdminWalletData);
                        }
                        
                        
                        
                        $insertAdminWalletLogData = [
                                                    'admin_wallet_id'=>$adminWalletId,
                                                    'user_id'=>session('id'),
                                                    'amount'=>$booking_amount,
                                                    'purpose'=>$action,
                                                    'credit_debit'=>'credit',
                                                    'booking_id'=>$BookingId,
                                                    'transaction_id'=>null,
                                                    'created_at'=>date('Y-m-d H:i:s')
                                                ];
                        $adminWalletLogId = $this->adminWalletLogModel->insertGetId($insertAdminWalletLogData);
                        
                        
                        
                        
                        // Send Email =========================================================
                            
                        $user = $this->registrationModel->where('deleted_at', '=', null)->where('id', '=', session('id'))->first();  
                        $studentName = $user->name;
                        
                        
                        
                        $lessonData = $this->lessonsModel->where('deleted_at', '=', null)->where('id', '=', $lesson_id)->first(); 
                        $lessonName = $lessonData->name;
                        $lessonID = $lessonData->id;
                        $lessonDateTime = date('d M Y',strtotime($booking_date))."/".$booking_time; 
                        $lessonPrice = number_format($booking_amount,2).' USD';
                        $lessonUrl = url('/lesson-detail/'.$lessonData->id);
                        
                        $subject = 'New lesson request from '.$studentName; 
                        $message = 'A student has requested to schedule lessons with you. Please click the button below to accept or modify the lesson request.';
                        
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
                          
                            
                        // Update student wallet ========================================================================== 
                        if($user){
                            $updateData=[];

                            $updateData['updated_at'] = date('Y-m-d H:i:s'); 
                            
                            $newStudentWalletAmount = ($user->student_wallet_amount - $booking_amount);
                            
                            $updateData['student_wallet_amount'] = $newStudentWalletAmount; 
                            
                            try{
                                $this->registrationModel->where('id',session('id'))->update($updateData);
                            }catch(Exception $e){
                            }
                        }
                        
                    }
                            
                    return redirect('lesson-booking/'.$teacher_id)->with('success','Booking has been created successfully.');
                }else{
                    return redirect('lesson-booking/'.$teacher_id)->with('error','Please try again!');
                }
            }

                
            //echo "<pre>"; print_r($insertData); exit();   
        }
        
        
    }
    
    
    
    public function fetch_communication_tool_accountID($accID){
        Session::forget('b_communication_tool');
        Session::forget('b_communication_tool_account_id');
        
        $user = $this->registrationModel->where('deleted_at', '=', null)->where('status', '=', '1')->where(['id'=>session('id')])->first(); 
        
        session([
                    'b_communication_tool'=>$user->video_conferencing_platform,
                    'b_communication_tool_account_id'=>$user->user_account_id
                ]);
        return $user->user_account_id;
    }
    
    public function fetch_package_price($lesson_package_id){
        
        Session::forget('b_lesson_id');
        Session::forget('b_lesson_name');
        Session::forget('b_lesson_package_id');
        Session::forget('b_booking_amt');
        Session::forget('b_lesson_package_time');
        // Session::forget('b_lesson_package');
        Session::forget('b_booking_slot');
        
        $package = $this->lessonPackagesModel->where('deleted_at', '=', null)->where(['id'=>$lesson_package_id])->first();
        $lesson = $this->lessonsModel->where('deleted_at', '=', null)->where(['id'=>$package->lesson_id])->first(); 
        
        $slot = 1;
        if($package->time == "45 mins" || $package->time == "60 mins")
        {
            $slot = 2;
        }
        if($package->time == "75 mins" || $package->time == "90 mins")
        {
            $slot = 3;
        }

        session([
                    'b_lesson_id'=>$package->lesson_id,
                    'b_lesson_name'=>$lesson->name,
                    'b_lesson_package_id'=>$lesson_package_id,
                    'b_lesson_package_time'=>$package->time,
                    // 'b_lesson_package'=>$package->package,
                    'b_booking_amt'=>$package->total,
                    'b_booking_slot'=>$slot
                ]);
        return $package->total;
    }
    
    
    public function ajax_lesson_packages(request $request){ 
        
        $data['user'] = $this->registrationModel->where('deleted_at', '=', null)->where('status', '=', '1')->where(['id'=>session('id')])->first(); 
        //echo $data['user']->role; die();
        
        $lesson_id = $request->lesson_id; 
        //$packages = $this->lessonPackagesModel->where('deleted_at', '=', null)->where(['lesson_id'=>$lesson_id,'time'=>'30 mins'])->get(); 
        
        
        
        $html = '<table id="lesson_packages_table" width="100%" border="0" cellspacing="0" cellpadding="0" class="booking-steptable mt-5">';
        $html .= '<tr>
                <td><h3>30 Mins</h3></td>
                <td><h3>45 Mins</h3></td>
                <td><h3>60 Mins</h3></td>
                <td><h3>75 Mins</h3></td>
                <td><h3>90 Mins</h3></td>
              </tr>';
        $html .= '<tr>';
        
        $thirtyMinsPackage = $this->lessonPackagesModel->where('deleted_at', '=', null)->where(['lesson_id'=>$lesson_id,'time'=>'30 mins'])->first(); 
        if($thirtyMinsPackage){
            if($thirtyMinsPackage->time=='30 mins'){
                $html .= '<td><table width="100%">';
                if($thirtyMinsPackage->individual_lesson != null)
                {
                    $lesson_text = 'Single Lesson';
                    $html .= '<tr><td align="center"><div class="slot-box lesson-box getLessonPackageType" data-lesson="'.$lesson_text.'" data-amount="'. number_format($thirtyMinsPackage->individual_lesson, 2) .'" data-time="30 mins" data-slot="1" data-package_lessons="1">
                                   <p>'.$lesson_text.'</p>
                                   <h4>USD '.number_format($thirtyMinsPackage->individual_lesson, 2).'</h4>
                                    <input class="form-check-input" type="radio" name="lesson_package_id" id="" value="'.$thirtyMinsPackage->id.'" >
                                 </div>
                                </td></tr>';
                }

                if($thirtyMinsPackage->total != null)
                {
                    $lesson_text = $thirtyMinsPackage->package;
                    $html .= '<tr><td align="center"><div class="slot-box lesson-box getLessonPackageType" data-lesson="'.$lesson_text.'" data-amount="'. number_format($thirtyMinsPackage->total, 2) .'" data-time="30 mins" data-slot="1">
                                   <p>'.$lesson_text.'</p>
                                   <h4>USD '.number_format($thirtyMinsPackage->total, 2).'</h4>
                                    <input class="form-check-input" type="radio" name="lesson_package_id" id="" value="'.$thirtyMinsPackage->id.'" >
                                 </div>
                                </td></tr>';
                }
                $html .= '</table></td>';
            }
        }
        
        
        $fourtyfiveMinsPackage = $this->lessonPackagesModel->where('deleted_at', '=', null)->where(['lesson_id'=>$lesson_id,'time'=>'45 mins'])->first(); 
        if($fourtyfiveMinsPackage){
            if($fourtyfiveMinsPackage->time=='45 mins'){
                $html .= '<td><table width="100%">';
                if($fourtyfiveMinsPackage->individual_lesson != null)
                {
                    $lesson_text = 'Single Lesson';
                    $html .= '<tr><td align="center"><div class="slot-box lesson-box getLessonPackageType" data-lesson="'.$lesson_text.'" data-amount="'. number_format($fourtyfiveMinsPackage->individual_lesson, 2) .'" data-time="45 mins" data-slot="2">
                                   <p>'.$lesson_text.'</p>
                                   <h4>USD '.number_format($fourtyfiveMinsPackage->individual_lesson, 2).'</h4>
                                    <input class="form-check-input" type="radio" name="lesson_package_id" id="" value="'.$fourtyfiveMinsPackage->id.'" >
                                 </div>
                                </td></tr>';
                }

                if($fourtyfiveMinsPackage->total != null)
                {
                    $lesson_text = $fourtyfiveMinsPackage->package;
                    $html .= '<tr><td align="center"><div class="slot-box lesson-box getLessonPackageType" data-lesson="'.$lesson_text.'" data-amount="'. number_format($fourtyfiveMinsPackage->total, 2) .'" data-time="45 mins" data-slot="2">
                                   <p>'.$lesson_text.'</p>
                                   <h4>USD '.number_format($fourtyfiveMinsPackage->total, 2).'</h4>
                                    <input class="form-check-input" type="radio" name="lesson_package_id" id="" value="'.$fourtyfiveMinsPackage->id.'" >
                                 </div>
                                </td></tr>';
                }
                $html .= '</table></td>';
            }
        }
        
        
        $sixtyMinsPackage = $this->lessonPackagesModel->where('deleted_at', '=', null)->where(['lesson_id'=>$lesson_id,'time'=>'60 mins'])->first(); 
        if($sixtyMinsPackage){
            if($sixtyMinsPackage->time=='60 mins'){
                $html .= '<td><table width="100%">';
                if($sixtyMinsPackage->individual_lesson != null)
                {
                    $lesson_text = 'Single Lesson';
                    $html .= '<tr><td align="center"><div class="slot-box lesson-box getLessonPackageType" data-lesson="'.$lesson_text.'" data-amount="'. number_format($sixtyMinsPackage->individual_lesson, 2) .'" data-time="60 mins" data-slot="2">
                                   <p>'.$lesson_text.'</p>
                                   <h4>USD '.number_format($sixtyMinsPackage->individual_lesson, 2).'</h4>
                                    <input class="form-check-input" type="radio" name="lesson_package_id" id="" value="'.$sixtyMinsPackage->id.'" >
                                 </div>
                                </td></tr>';
                }

                if($sixtyMinsPackage->total != null)
                {
                    $lesson_text = $sixtyMinsPackage->package;
                    $html .= '<tr><td align="center"><div class="slot-box lesson-box getLessonPackageType" data-lesson="'.$lesson_text.'" data-amount="'. number_format($sixtyMinsPackage->total, 2) .'" data-time="60 mins" data-slot="2">
                                   <p>'.$lesson_text.'</p>
                                   <h4>USD '.number_format($sixtyMinsPackage->total, 2).'</h4>
                                    <input class="form-check-input" type="radio" name="lesson_package_id" id="" value="'.$sixtyMinsPackage->id.'" >
                                 </div>
                                </td></tr>';
                }
                $html .= '</table></td>';
            }
        }
        
        
        $seventyfiveMinsPackage = $this->lessonPackagesModel->where('deleted_at', '=', null)->where(['lesson_id'=>$lesson_id,'time'=>'75 mins'])->first(); 
        if($seventyfiveMinsPackage){
            if($seventyfiveMinsPackage->time=='75 mins'){
                $html .= '<td><table width="100%">';
                if($seventyfiveMinsPackage->individual_lesson != null)
                {
                    $lesson_text = 'Single Lesson';
                    $html .= '<tr><td align="center"><div class="slot-box lesson-box getLessonPackageType" data-lesson="'.$lesson_text.'" data-amount="'. number_format($seventyfiveMinsPackage->individual_lesson, 2) .'" data-time="75 mins" data-slot="3">
                                   <p>'.$lesson_text.'</p>
                                   <h4>USD '.number_format($seventyfiveMinsPackage->individual_lesson, 2).'</h4>
                                    <input class="form-check-input" type="radio" name="lesson_package_id" id="" value="'.$seventyfiveMinsPackage->id.'" >
                                 </div>
                                </td></tr>';
                }

                if($seventyfiveMinsPackage->total != null)
                {
                    $lesson_text = $seventyfiveMinsPackage->package;
                    $html .= '<tr><td align="center"><div class="slot-box lesson-box getLessonPackageType" data-lesson="'.$lesson_text.'" data-amount="'. number_format($seventyfiveMinsPackage->total, 2) .'" data-time="75 mins" data-slot="3">
                                   <p>'.$lesson_text.'</p>
                                   <h4>USD '.number_format($seventyfiveMinsPackage->total, 2).'</h4>
                                    <input class="form-check-input" type="radio" name="lesson_package_id" id="" value="'.$seventyfiveMinsPackage->id.'" >
                                 </div>
                                </td></tr>';
                }
                $html .= '</table></td>';
            }
        }
        
        
        $ninetyMinsPackage = $this->lessonPackagesModel->where('deleted_at', '=', null)->where(['lesson_id'=>$lesson_id,'time'=>'90 mins'])->first(); 
        if($ninetyMinsPackage){
            if($ninetyMinsPackage->time=='90 mins'){
                $html .= '<td><table width="100%">';
                if($ninetyMinsPackage->individual_lesson != null)
                {
                    $lesson_text = 'Single Lesson';
                    $html .= '<tr><td align="center"><div class="slot-box lesson-box getLessonPackageType" data-lesson="'.$lesson_text.'" data-amount="'. number_format($ninetyMinsPackage->individual_lesson, 2) .'" data-time="90 mins" data-slot="3">
                                   <p>'.$lesson_text.'</p>
                                   <h4>USD '.number_format($ninetyMinsPackage->individual_lesson, 2).'</h4>
                                    <input class="form-check-input" type="radio" name="lesson_package_id" id="" value="'.$ninetyMinsPackage->id.'"  >
                                 </div>
                                </td></tr>';
                }

                if($ninetyMinsPackage->total != null)
                {
                    $lesson_text = $ninetyMinsPackage->package;
                    $html .= '<tr><td align="center"><div class="slot-box lesson-box getLessonPackageType" data-lesson="'.$lesson_text.'" data-amount="'. number_format($ninetyMinsPackage->total, 2) .'" data-time="90 mins" data-slot="3">
                                   <p>'.$lesson_text.'</p>
                                   <h4>USD '.number_format($ninetyMinsPackage->total, 2).'</h4>
                                    <input class="form-check-input" type="radio" name="lesson_package_id" id="" value="'.$ninetyMinsPackage->id.'"  >
                                 </div>
                                </td></tr>';
                }
                $html .= '</table></td>';
            }
        }
        
        $html .= '</tr></table>';

        
        echo $html;
    }
    
    
    
    
    public function settings_update(request $request){
        
        $data['user'] = $this->registrationModel->where('deleted_at', '=', null)->where('status', '=', '1')->where(['id'=>session('id')])->first(); 
        $data['timezone'] = DB::table('timezone')->get(); 
        $data['currencies'] = DB::table('currency')->get(); 
        
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
                    return redirect('student-settings')->withErrors($validator)->withInput(); 
                }
                
            }else{
                
                
                $updateData=[];

                $updateData['updated_at'] = date('Y-m-d H:i:s'); 
                
                
                if($request->has('email')){
                    $email = $this->registrationModel->where('email','=',$request->email)->where('deleted_at','=',null)->where('status', '=', '1')->get();  
                    if(count($email)>0 && $request->email != $data['user']->email){
                        if($request->role=='1'){
                            return redirect('student-settings')->with('error','Email already exists!');
                        }else{
                            return redirect('student-settings')->with('error','Email already exists!');
                        }
                        
                    }else{
                        $updateData['email'] = $request->email;  
                    }
                }
                
                if($request->has('phone')){
                    $phone = $this->registrationModel->where('phone_number','=',$request->phone)->where('deleted_at','=',null)->where('status', '=', '1')->get(); 
                    if(count($phone)>0 && $request->phone != $data['user']->phone_number){
                        if($request->role=='1'){
                            return redirect('student-settings')->with('error','Phone number already exists!');
                        }else{
                            return redirect('student-settings')->with('error','Phone number already exists!');
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
                        return redirect('student-settings')->with('success','Settings has been updated successfully.');
                    }
                    
                }catch(Exception $e){
                    
                    if($request->role=='1'){
                        return redirect('student-settings')->with('error','Please try again!');
                    }else{
                        return redirect('student-settings')->with('error','Please try again!');
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
    

    
    
    
    public function give_feedback(request $request){
        
        $data['user'] = $this->registrationModel->where('deleted_at', '=', null)->where('status', '=', '1')->where(['id'=>session('id')])->first(); 
        
        $getLoggedIndata = getLoggedinData();
        
        if(count($request->all()) > 0) { 
            //echo "<pre>"; print_r($_POST); exit(); 
            
            $validator = Validator::make($request->all(), [
                            'teacher_rating' => 'required',
                            'audio_quality_rating' => 'required',
                            'video_quality_rating' => 'required',
                            'review' => 'required',
                            'comments' => 'required',
                            'badges' => 'required|array|min:1',
                        ]);
                        
            if ($validator->fails()) { 
                return redirect('feedback/'.$request->booking_id)->withErrors($validator)->withInput(); 
            }else{
                
                $rowCount = $this->feedbackRatingModel->select(DB::raw('count(*) as count'))->where('booking_id', '=', $request->booking_id)
                                                    ->where('deleted_at', '=', null)->count();
                if($rowCount>0){
                    return redirect('feedback/'.$request->booking_id)->with('error','You have already given your feedback for this booking!')->withInput();
                }
                
                $bookingData = $this->bookingModel->where('id', '=', $request->booking_id)->first(); 
                
                $insertData = [
                                'booking_id'=>$request->booking_id,
                                'given_by'=>$getLoggedIndata->id,
                                'student_id'=>$bookingData->student_id,
                                'teacher_id'=>$bookingData->teacher_id, 
                                'lesson_id'=>$bookingData->lesson_id,
                                'lesson_package_id'=>$bookingData->lesson_package_id,
                                'rating'=>$request->teacher_rating,  
                                'audio_quality_rating'=>$request->audio_quality_rating, 
                                'video_quality_rating'=>$request->video_quality_rating, 
                                'review'=>ucfirst($request->review), 
                                'private_feedback'=>ucfirst($request->private_feedback),
                                'comments'=>ucfirst($request->comments), 
                                'badges'=>json_encode($request->badges), 
                                'created_at'=>date('Y-m-d H:i:s')
                            ];
                            
                if($data['user']->role=='1'){
                    
                    $insertId = $this->feedbackRatingModel->insertGetId($insertData);
                    
                    if($insertId!=''){
                        
                        $studentName = '';
                        if($bookingData->student_id == session('id')){
                            $user = $this->registrationModel->where('deleted_at', '=', null)->where('id', '=', session('id'))->first();  
                            $studentName = $user->name;
                        }
                        
                        $action = 'Student '.$studentName.', has given feedback & rating.';
                        
                        $insertLessonLogData = [
                                                    'lesson_id'=>$bookingData->lesson_id,
                                                    'lesson_package_id'=>$bookingData->lesson_package_id,
                                                    'teacher_id'=>$bookingData->teacher_id, 
                                                    'student_id'=>$bookingData->student_id,
                                                    'booking_id'=>$request->booking_id,
                                                    'action'=>$action,
                                                    'lesson_accept_reject'=>'0',
                                                    'created_at'=>date('Y-m-d H:i:s')
                                                ];

                        $lessonLogId = $this->lessonLogModel->insertGetId($insertLessonLogData);
                        
                        return redirect('feedback/'.$request->booking_id)->with('success','Thank you for submitting your feedback and rating.');
                    }else{
                        return redirect('feedback/'.$request->booking_id)->with('error','Please try again!'); 
                    }
                    
                }else{
                    return redirect('feedback/'.$request->booking_id)->with('error','Only student can give the feedback and rating!'); 
                }
                
                
                
            }
            
            
        }else{
            
            if($data['user']->role=='1'){
                return view('student.feedback',$data);
            }else{
                return redirect('teacher-dashboard');
            }
        }
    }
 
    
    
    

}



?>
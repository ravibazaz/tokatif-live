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
use App\Models\Transaction;
use App\Models\WalletLog;
use App\Models\CardDetail;
use App\Models\LessonLog;
use App\Models\AdminWallet;
use App\Models\AdminWalletLog;
use App\Models\StudentLesson;

use Session;
use Validator;
use Hash;
use Carbon\Carbon;

use Stripe;


use App\Mail\LessonBooking;
use App\Mail\PurchaseTokatifTokens;
use Illuminate\Support\Facades\Mail;

   
class StripePaymentController extends Controller
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
    }
    
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe()
    {
        $data['title']="Stripe Payment";
        $data['breadcrumb']='Stripe Payment';
        
        return view('payment.stripe',$data);
        //return view('stripe');
    }
  
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {
        // echo "<pre>"; print_r($_POST); exit();
        /*echo "card_no:: ".$_POST['payment_card_no']."<br>"; 
        echo "expiry_month:: ".$_POST['payment_expiry_month']."<br>"; 
        echo "expiry_year:: ".$_POST['payment_expiry_year']."<br>"; 
        echo "cvv:: ".$_POST['payment_cvv']."<br>";
        echo "saveinformation:: ".$_POST['payment_saveinformation']."<br>"; */
        
        $teacher_id = $_POST['payment_teacher_id'];
        
        if($_POST['payment_lesson_id']!=''){
            $lesson_id = $_POST['payment_lesson_id'];
        }else{
            $lesson_id = session('b_lesson_id');
            $_POST['payment_lesson_id'] = session('b_lesson_id');
        }
        
        if($_POST['payment_lesson_package_id']!=''){
            $lesson_package_id = $_POST['payment_lesson_package_id'];
        }else{
            $lesson_package_id = session('b_lesson_package_id');
            $_POST['payment_lesson_package_id'] = session('b_lesson_package_id');
        }
        
        if($_POST['payment_communication_tool']!=''){
            $communication_tool = $_POST['payment_communication_tool'];
        }else{
            $communication_tool = session('b_communication_tool');
            $_POST['payment_communication_tool'] = session('b_communication_tool');
        }
        
        if($_POST['payment_communication_account_id']!=''){
            $communication_account_id = $_POST['payment_communication_account_id'];
        }else{
            $communication_account_id = session('b_communication_tool_account_id');
            $_POST['payment_communication_account_id'] = session('b_communication_tool_account_id');
        }

        
        $booking_date = $_POST['payment_booking_date'];
        $booking_time = $_POST['payment_booking_time'];
        
        if($_POST['payment_booking_amount']!=''){
            $booking_amount = $_POST['payment_booking_amount'];
        }else{
            $booking_amount = session('b_booking_amt');
            $_POST['payment_booking_amount'] = session('b_booking_amt');
        }
        
        //echo $_POST['payment_booking_amount']." aa ".$booking_amount; exit();
        
        $validator = Validator::make($request->all(), [
                                'payment_teacher_id' => 'required',
                                'payment_booking_date' => 'required|date_format:Y-m-d',
                                'payment_booking_time'=>'required',
                                //'payment_booking_amount'=>'required',
                                'payment_card_no' => 'required',
                                'payment_expiry_month' => 'required',
                                'payment_expiry_year' => 'required',
                                'payment_cvv' => 'required',
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
                return redirect('lesson-booking/'.$teacher_id)->with('error','You have already booked a lesson on same date & time!');
                
            }else{
                
                if($_POST['payment_saveinformation']=='on'){
                    $userCardDetail = $this->cardDetailModel->where('deleted_at', '=', null)->where('user_id', '=', session('id'))
                                                            ->where('card_no', '=', $_POST['payment_card_no'])
                                                            ->get();  
                                                            
                    if(count($userCardDetail)==0){
                        $insertCardData = [
                                            'user_id'=>session('id'),
                                            'cardholder_name'=>$_POST['payment_cardholder_name'],
                                            'card_no'=>$_POST['payment_card_no'], 
                                            'expiry_month'=>$_POST['payment_expiry_month'], 
                                            'expiry_year'=>$_POST['payment_expiry_year'],
                                            'cvv'=>$_POST['payment_cvv'],
                                            'created_at'=>date('Y-m-d H:i:s')
                                        ];
                                                
                        $cardDetailId = $this->cardDetailModel->insertGetId($insertCardData);
                    }
                }
                
                $stripe = Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                
                try {
                    $response = \Stripe\Token::create(array(
                        "card" => array(
                            "number"    => $request->input('payment_card_no'),
                            "exp_month" => $request->input('payment_expiry_month'),
                            "exp_year"  => $request->input('payment_expiry_year'),
                            "cvc"       => $request->input('payment_cvv')
                        )));
                    if (!isset($response['id'])) {
                        return redirect('lesson-booking/'.$teacher_id)->with('error','Please try again!');
                    }
                    
                    $charge = Stripe\Charge::create ([
                                    "amount" => $booking_amount * 100,
                                    "currency" => "usd",
                                    "source" => $request->stripeToken,
                                    "description" => "Test payment from tokatif." 
                                ]);
                            
                    //echo "<pre>"; print_r($charge); exit(); 
                    
                    if($charge['status'] == 'succeeded') {
                        
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
                                                    'status'=>$charge['status'],
                                                    'transaction_id'=>$charge['source']['id'],
                                                    'brand'=>$charge['source']['brand'],
                                                    'country'=>$charge['source']['country'],
                                                    'created_at'=>date('Y-m-d H:i:s')
                                                ];
                                                
                            $transactionId = $this->transactionModel->insertGetId($insertTransactionData);
                            
                            
                            $insertLessonLogData = [
                                                    'lesson_id'=>$lesson_id,
                                                    'lesson_package_id'=>$lesson_package_id,
                                                    'teacher_id'=>$teacher_id,
                                                    'student_id'=>session('id'),
                                                    'booking_id'=>$BookingId,
                                                    'action'=>$action,
                                                    'lesson_accept_reject'=>'0',
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
                                
                                $newStudentWalletAmount = ($user->student_wallet_amount + $booking_amount);
                                
                                $updateData['student_wallet_amount'] = $newStudentWalletAmount; 
                                
                                try{
                                    $this->registrationModel->where('id',session('id'))->update($updateData);
                                }catch(Exception $e){
                                }
                            }
                        
                        }
                        
                        return redirect('lesson-booking/'.$teacher_id)->with('success','Payment successful.');
                    } else {
                        return redirect('lesson-booking/'.$teacher_id)->with('error','Something went to wrong!');
                    }

                    
                    //echo "<pre>"; print_r($insertData); exit();

                
                }catch (Exception $e) {
                    //return $e->getMessage();
                    return redirect('lesson-booking/'.$teacher_id)->with('error','Please try again! '.$e->getMessage());
                }
                
                
            }
        }
        
    }
    
    
    
    public function stripeCreditPost(Request $request)
    {
        //echo "<pre>"; print_r($_POST); exit();
        
        $credit_amount = $_POST['credit_amount'];
        
        $saveinformation = @$_POST['saveinformation'];
        if($saveinformation==''){
            $saveinformation = 'off';
        }
        
        $validator = Validator::make($request->all(), [
                                'credit_amount'=>'required',
                                'c_cardholder_name'=>'required',
                                'c_card_no' => 'required',
                                'c_expiry_month' => 'required',
                                'c_expiry_year' => 'required',
                                'c_cvv' => 'required',
                            ]);
            

        if ($validator->fails()) { 
            return redirect('add-credit')->withErrors($validator)->withInput(); 
        }else{

            if($saveinformation=='on'){
                $userCardDetail = $this->cardDetailModel->where('deleted_at', '=', null)->where('user_id', '=', session('id'))
                                                        ->where('card_no', '=', $_POST['c_card_no'])
                                                        ->get();  
                                                        
                if(count($userCardDetail)==0){
                    $insertCardData = [
                                        'user_id'=>session('id'),
                                        'cardholder_name'=>$_POST['c_cardholder_name'],
                                        'card_no'=>$_POST['c_card_no'], 
                                        'expiry_month'=>$_POST['c_expiry_month'], 
                                        'expiry_year'=>$_POST['c_expiry_year'],
                                        'cvv'=>$_POST['c_cvv'],
                                        'created_at'=>date('Y-m-d H:i:s')
                                    ];
                                            
                    $cardDetailId = $this->cardDetailModel->insertGetId($insertCardData);
                }
            }
            
            
            $stripe = Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            
            try {
                $response = \Stripe\Token::create(array(
                    "card" => array(
                        "number"    => $request->input('c_card_no'),
                        "exp_month" => $request->input('c_expiry_month'),
                        "exp_year"  => $request->input('c_expiry_year'),
                        "cvc"       => $request->input('c_cvv')
                    )));
                if (!isset($response['id'])) {
                    return redirect('add-credit')->with('error','Please try again!');
                }
                
                $charge = Stripe\Charge::create ([
                                "amount" => $credit_amount * 100,
                                "currency" => "usd",
                                "source" => $request->stripeToken,
                                "description" => "Test payment from tokatif." 
                            ]);
                        
                //echo "<pre>"; print_r($charge); exit(); 
                
                if($charge['status'] == 'succeeded') {
                    
                    $insertTransactionData = [
                                            'booking_id'=>null,
                                            'user_id'=>session('id'),
                                            'cardholder_name'=>$_POST['c_cardholder_name'],
                                            'card_no'=>$_POST['c_card_no'], 
                                            'expiry_month'=>$_POST['c_expiry_month'], 
                                            'expiry_year'=>$_POST['c_expiry_year'],
                                            'cvv'=>$_POST['c_cvv'],
                                            'amount'=>$credit_amount,
                                            'saveinformation'=>$saveinformation,
                                            'status'=>$charge['status'],
                                            'transaction_id'=>$charge['source']['id'],
                                            'brand'=>$charge['source']['brand'],
                                            'country'=>$charge['source']['country'],
                                            'created_at'=>date('Y-m-d H:i:s')
                                        ];
                                        
                    $transactionId = $this->transactionModel->insertGetId($insertTransactionData);
                    
                    if($transactionId!=''){
                        $insertWalletLogData = [
                                                'user_id'=>session('id'),
                                                'wallet_amount'=>$credit_amount,
                                                'purpose'=>'tokatif credit added',
                                                'credit_debit'=>'credit',
                                                'transaction_id'=>$charge['source']['id'],
                                                'created_at'=>date('Y-m-d H:i:s')
                                            ];
                                            
                                            
                        $walletLogId = $this->walletLogModel->insertGetId($insertWalletLogData);
                        
                        $user = $this->registrationModel->where('deleted_at', '=', null)->where('id', '=', session('id'))->first();  
                        if($user){
                            $updateData=[];

                            $updateData['updated_at'] = date('Y-m-d H:i:s'); 
                            
                            $newStudentWalletAmount = ($user->student_wallet_amount + $credit_amount);
                            
                            $updateData['student_wallet_amount'] = $newStudentWalletAmount; 
                            
                            try{
                                $this->registrationModel->where('id',session('id'))->update($updateData);
                            }catch(Exception $e){
                            }
                        }
                    }

                    $user = Registration::where('id', session('id'))->first();

                    $subject = 'Thank you for adding Tokatif Tokens to your wallet'; 
                    $message = '';
                    
                    $details = [
                        'to' => $user->email,
                        'from' => env('MAIL_FROM_ADDRESS'),
                        'subject' => $subject,
                        'receiver' => ucfirst($user->name),
                        'sender' => env('MAIL_FROM_NAME'), 
                        'msg'=>$message,
                        'receiver'=> $user->name
                    ];

                    // Mail::to($user->email)->send(new PurchaseTokatifTokens($details));
                    
                    return redirect('add-credit')->with('success','Credit amount has been added successfully.');
                } else {
                    return redirect('add-credit')->with('error','Something went to wrong!');
                }

                
                //echo "<pre>"; print_r($insertData); exit();

            
            }catch (Exception $e) {
                //return $e->getMessage();
                return redirect('add-credit')->with('error','Please try again! '.$e->getMessage());
            }

        }
        
    }
}

?>



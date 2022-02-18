<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Registration;

use Validator;
use Hash;
use DB;


use App\Mail\Register;
use Illuminate\Support\Facades\Mail;

class TeacherController extends Controller
{
    protected $registrationModel;
    public function __construct(){
        $this->registrationModel = new Registration;
    }
    public function index(Request $request){
        $data['title']="Teachers";
        $data['breadcrumb']="teachers";  

        if($request->has('q')){  

            if (is_numeric($request->q)) {
                $teachers = $this->registrationModel->where('deleted_at', '=', null)
                    								->where('role', '=', '2')
                                                    ->where('phone_number','=',$request->q)
                                                    ->orderBy('id','desc')->paginate(15);

            }elseif (filter_var($request->q, FILTER_VALIDATE_EMAIL)) {
                
                $teachers = $this->registrationModel->where('deleted_at', '=', null)
                    								->where('role', '=', '2')
                                                    ->where('email','like','%'.$request->q.'%')
                                                    ->orderBy('id','desc')->paginate(15);
            
            }else{
                $teachers = $this->registrationModel->where('deleted_at', '=', null)  
                    								->where('role', '=', '2')
                    								->where('teacher_type', '=', $request->q)
                    								->orWhere('name','like','%'.$request->q.'%')
                                                    ->orWhere('address','like','%'.$request->q.'%')
                                                    ->orderBy('id','desc')->paginate(15);
                
            }
            
        }else{
            $teachers = $this->registrationModel->where('deleted_at', '=', null)
                                                ->where('role', '=', '2')
                                                ->orderBy('id','desc')->paginate(15);
        }
        $data['teachers']=$teachers;  
        return view('admin.teachers.list',$data);
    }
    
    
    
    public function details(Request $request){
        $data['title']="Teacher Detail";
        $data['breadcrumb']="teacher";
        
        $id = $request->id;
        $teacherData = $this->registrationModel->where(['id'=>$id])->first();  
        
        if($teacherData){
            $data['teacher']=$teacherData; 
            $data['teacher_type']=$teacherData->teacher_type; 

        }else{
            return redirect('/admin/teachers')->with('error','Teacher not found!');
        }
        
        return view('admin.teachers.details',$data);

    }


    
    public function approve_teacher($id){
        $teacher = $this->registrationModel->where('id',$id)->first();
        if($teacher){
            $updateData=[];

            $updateData['updated_at'] = date('Y-m-d H:i:s');
            $updateData['status'] = '1';
            
            try{
                $this->registrationModel->where('id',$id)->update($updateData);
                
                // Send Email =========================================================
                    
                $subject = 'Congratulations! You are now a Tokatif Teacher!';
                $message = 'Welcome to the team! You are now a Tokatif Teacher. While you wait for your first lesson request, spend some time familiarising yourself with our platform. To stand out from the rest of the teachers, make sure your profile easy to understand and your availability and request settings (via Teacher Settings) are updated! ';
                
                $details = [
                    'to' => $teacher->email,
                    'from' => env('MAIL_FROM_ADDRESS'),
                    'subject' => $subject,
                    'receiver' => ucfirst($teacher->name), 
                    'sender' => env('MAIL_FROM_NAME'), 
                    'msg'=>$message
                ];

                Mail::to($teacher->email)->send(new Register($details));
                
                return redirect('admin/teachers')->with('success','Teacher has been approved successfully.');
                
            }catch(Exception $e){
                return redirect('admin/teachers/')->with('error','Please try again!');
            }
            
        }else{
            return redirect('admin/teachers')->with('error','Teacher not found!');
        }
        
    }
    
    
    
    public function delete($id){
        $teacher = $this->registrationModel->where('id',$id)->first();
        if($teacher){
            $teacher = $this->registrationModel->where(['id'=>$id])->delete();
            return redirect('admin/teachers')->with('success','Teacher has been deleted successfully.');
        }else{
            return redirect('admin/teachers')->with('error','Teacher not found!');
        }
        
    }



}
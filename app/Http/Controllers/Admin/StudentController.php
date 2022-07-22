<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Registration;

use Validator;
use Hash;
use DB;

class StudentController extends Controller
{
    protected $registrationModel;
    public function __construct(){
        $this->registrationModel = new Registration;
    }
    public function index(Request $request){
        $data['title']="Students";
        $data['breadcrumb']="students";  

        if($request->has('q')){  

            if (is_numeric($request->q)) {
                $students = $this->registrationModel->where('deleted_at', '=', null)
                    								->where('role', '=', '1')
                                                    ->where('phone_number','=',$request->q)
                                                    ->orderBy('id','desc')->paginate(15);

            }elseif (filter_var($request->q, FILTER_VALIDATE_EMAIL)) {
                
                $students = $this->registrationModel->where('deleted_at', '=', null)
                    								->where('role', '=', '1')
                                                    ->where('email','like','%'.$request->q.'%')
                                                    ->orderBy('id','desc')->paginate(15);
            
            }else{
                $students = $this->registrationModel->where('deleted_at', '=', null)  
                    								->where('role', '=', '1')
                    								->Where('name','like','%'.$request->q.'%')
                                                    ->orderBy('id','desc')->paginate(15);
                
            }
            
        }else{
            $students = $this->registrationModel->where('deleted_at', '=', null)
                                                ->where('role', '=', '1')
                                                ->orderBy('id','desc')->paginate(15);
        }
        $data['students']=$students;  
        return view('admin.students.list',$data);
    }
    
    
    public function studentsAppliedForTeacher(Request $request){
        $data['title']="Students Applied For Teacher";
        $data['breadcrumb']="students applied for teacher";  

        if($request->has('q')){  

            if (is_numeric($request->q)) {
                $students = $this->registrationModel->where('deleted_at', '=', null)
                                                    ->where('role', '=', '1')
                                                    ->whereIn('applied_for_teacher',['1','2','3'])
                                                    ->where('phone_number','=',$request->q)
                                                    ->orderBy('id','desc')->paginate(15);

            }elseif (filter_var($request->q, FILTER_VALIDATE_EMAIL)) {
                
                $students = $this->registrationModel->where('deleted_at', '=', null)
                                                    ->where('role', '=', '1')
                                                    ->whereIn('applied_for_teacher',['1','2','3'])
                                                    ->where('email','like','%'.$request->q.'%')
                                                    ->orderBy('id','desc')->paginate(15);
            
            }else{
                $students = $this->registrationModel->where('deleted_at', '=', null)  
                                                    ->where('role', '=', '1')
                                                    ->whereIn('applied_for_teacher',['1','2','3'])
                                                    ->Where('name','like','%'.$request->q.'%')
                                                    ->orderBy('id','desc')->paginate(15);
                
            }
            
        }else{
            $students = $this->registrationModel->where('deleted_at', '=', null)
                                                ->where('role', '=', '1')
                                                ->whereIn('applied_for_teacher',['1','2','3'])
                                                ->orderBy('id','desc')->paginate(15);
        }
        $data['students']=$students;  
        return view('admin.students_applied_for_teacher.list',$data);
    }

    public function approveStudentForTeacher($id)
    {
        Registration::where('id', $id)->update(['applied_for_teacher' => '2']);
        return redirect()->back();
    }

    public function disapproveStudentForTeacher($id)
    {
        Registration::where('id', $id)->update(['applied_for_teacher' => '3']);
        return redirect()->back();
    }
    
    public function details(Request $request){
        $data['title']="Student Detail";
        $data['breadcrumb']="student";
        
        $id = $request->id;
        $studentData = $this->registrationModel->where(['id'=>$id])->first();  
        
        if($studentData){
            $data['student']=$studentData;  

        }else{
            return redirect('/admin/students')->with('error','Student not found!');
        }
        
        return view('admin.students.details',$data);

    }


    
    public function delete($id){
        $teacher = $this->registrationModel->where('id',$id)->first();
        if($teacher){
            $teacher = $this->registrationModel->where(['id'=>$id])->delete();
            return redirect('admin/students')->with('success','Student has been deleted successfully.');
        }else{
            return redirect('admin/students')->with('error','Student not found!');
        }
        
    }



}
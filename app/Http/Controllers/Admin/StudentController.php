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
                    								->orWhere('name','like','%'.$request->q.'%')
                                                    ->orWhere('address','like','%'.$request->q.'%')
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
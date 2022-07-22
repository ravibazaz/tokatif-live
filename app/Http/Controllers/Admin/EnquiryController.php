<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Enquiry;

use Validator;
use Hash;
use DB;


class EnquiryController extends Controller
{
    public function list(Request $request){
        $data['title']="Enquiry";
        $data['breadcrumb']='Enquiry';

        $enquiries = Enquiry::orderBy('id','desc')->paginate(15);
        
        $data['enquiries'] = $enquiries; 

        return view('admin.enquiry.list',$data);
    }
    
    public function delete($id){  
        $enquiry = Enquiry::where('id',$id)->first();
        if($enquiry){
            Enquiry::where(['id'=>$id])->delete();
            return redirect('admin/enquiry')->with('success','Enquiry has been deleted successfully.');
        }else{
            return redirect('admin/enquiry')->with('error','Enquiry not found!');
        }
        
    }

}


?>
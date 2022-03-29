<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Terms;

use Session;
use Validator;
//use Hash;
//use Carbon\Carbon;


class TermsController extends Controller
{
    protected $termsModel;
    
    public function __construct(){
        $this->termsModel = new Terms;
    }
    
    public function index(){ 
        $data['title']="Terms";
        $data['breadcrumb']='Terms';

        $data['terms'] = $this->termsModel->where('deleted_at', '=', null)->get(); 
        
                                                
        //echo "<pre>"; print_r($data['terms']); exit();
        return view('terms.list',$data);
        
    }
    
    
    
 
    

}



?>
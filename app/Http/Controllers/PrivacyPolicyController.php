<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Privacy;

use Session;
use Validator;
//use Hash;
//use Carbon\Carbon;


class PrivacyPolicyController extends Controller
{
    protected $privacyModel;
    
    public function __construct(){
        $this->privacyModel = new Privacy;
    }
    
    public function index(){ 
        $data['title']="Privacy Policy";
        $data['breadcrumb']='Privacy Policy';

        $data['privacy'] = $this->privacyModel->where('deleted_at', '=', null)->get(); 
        
                                                
        //echo "<pre>"; print_r($data['privacy']); exit();
        return view('policy.list',$data);
        
    }
    
    
    
 
    

}



?>
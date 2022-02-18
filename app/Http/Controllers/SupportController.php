<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Support;

use Session;
use Validator;
//use Hash;
//use Carbon\Carbon;

use Illuminate\Support\Facades\Storage;


class SupportController extends Controller
{
    protected $supportModel;
    
    public function __construct(){
        $this->supportModel = new Support;
    }
    
    public function index(){ 
        $data['title']="Support";
        $data['breadcrumb']='Support';

        $data['support'] = $this->supportModel->where('deleted_at', '=', null)->get(); 
        
                                                
        //echo "<pre>"; print_r($data['support']); exit();
        return view('support.list',$data);
        
    }
    
    
    
 
    

}



?>
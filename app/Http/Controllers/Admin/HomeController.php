<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Registration;

use DB;


class HomeController extends Controller
{
    protected $registrationModel;
    
    public function __construct(){

        $this->registrationModel = new Registration;
        
    }
    public function index(){ 
        $data['title']="Dashboard";
        $data['breadcrumb']='Dashboard';

        // ---------------------------------------------------------------------------------------------------------


        $data['total'] = 1;
        $data['ontime'] = 1;
        $data['partlyDelayed'] = 1;
        $data['delayed'] = 1;

        $data['ontimeCount'] = 1;
        $data['partlyDelayedCount'] = 1;
        $data['delayedCount'] = 1;
        
        $data['completed'] = 1;
        $data['ongoing'] = 1;
        $data['uninitiated'] = 1;
        $data['totalProjects'] = 1;


        return view('admin.dashboard.index',$data);

        
    }
}

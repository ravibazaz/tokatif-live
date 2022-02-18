<?php 
use Illuminate\Support\Facades\Session;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Facades\DB;



if (!function_exists('getLoggedinData')) {
    function getLoggedinData() { 
        $userData = DB::table('registrations')->where('id', '=', session('id'))->where('deleted_at', '=', null)->first();

        return $userData;
    }
}


function getwebsite_data(){
   $resultData = DB::table('website_settings')->get()->toArray();
    
   return($resultData);
}


if (!function_exists('getVisitorCountry')) {
    function getVisitorCountry() { 
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];
        $country  = "";
    
        if(filter_var($client, FILTER_VALIDATE_IP))
        {
            $ip = $client;
        }
        elseif(filter_var($forward, FILTER_VALIDATE_IP))
        {
            $ip = $forward;
        }
        else
        {
            $ip = $remote;
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://www.geoplugin.net/json.gp?ip=".$ip);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $ip_data_in = curl_exec($ch); // string
        curl_close($ch);
    
        $ip_data = json_decode($ip_data_in,true);
        $ip_data = str_replace('&quot;', '"', $ip_data); // for PHP 5.2 see stackoverflow.com/questions/3110487/
    
        if($ip_data && $ip_data['geoplugin_countryName'] != null) {
            $country = $ip_data['geoplugin_countryName'];
        }
    
        //return 'IP: '.$ip.' # Country: '.$country;

        return $country;
    }
}

if (!function_exists('sendEmail')) {
    function sendEmail($to,$subject,$message) { 
        //echo ">>>>> ".$segment." ::======================= ".session('id'); die();

        /*$activityId = DB::table('activities')->insertGetId([
                                    'activity' => $activity,
                                    'added_by' => $added_by,
                                    'assigned_to' => $assigned_to,
                                    'project_id' => $project_id,
                                    'milestone_id' => $milestone_id,
                                    'main_task_id' => $main_task_id,
                                    'task_id' => $task_id,
                                    'sub_task_id' => $sub_task_id,
                                    'created_at'=>date('Y-m-d H:i:s')
                                ]);

        return $activityId;*/
    }
}




function emailsend($to,$message)
{
 
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";            
        $subject  = "Authorization Code For Registration";
        $headers .= 'From: support@tokatif.com';
        $api_url = "http://167.71.78.230/laravel/tokatif/mail.php";    
        $postfield="body=".$message."&to=".$to."&subject=".$subject."&headers=".$headers;
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST,TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$postfield);
        $response = curl_exec($ch);
        curl_close($ch);

        $response_mail = json_decode($response,true);

        return $response_mail;


}

if (!function_exists('getToken')) {
    function getToken($data){
       return encrypt(array_merge($data,[
            'exp'=>24*3600
        ]));
    }

}
if (!function_exists('decodeToken')) {
    function decodeToken($token){
        try{

            return ['status'=>true,'data'=>decrypt($token),'message'=>''];
        }catch(Exception $e){
            // return $e;
            return ['status'=>false,'data'=>[],'message'=>"Invalid Token"];
        }
    }

}
if (!function_exists('randomNumber')) {
    function randomNumber(){
       return rand(100000,999999);
    }

}

if (!function_exists('getUserAccessRights')) {
    function getUserAccessRights($segment,$userID) { 
        //echo "ss: ".$segment; die();
        //echo ">>>>> ".$segment." ::======================= ".session('id'); die();

        /*$userAccessRights = DB::table('users')->where('id',session('id'))->get(); //print_r($userAccessRights); die();
        $role_type = $userAccessRights[0]->role_type;
        $accessModules = $userAccessRights[0]->access_modules;

        return $userAccessRights;*/
    }
}



?>
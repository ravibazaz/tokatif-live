<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Pusher\Pusher;

use App\Models\Registration;
use App\Models\Chat;

use Session;
use Validator;
use Hash;
use Carbon\Carbon;

use Illuminate\Support\Facades\Storage;



class ChatController extends Controller
{
    protected $registrationModel;
    protected $chatModel;
    
    public function __construct(){
        $this->registrationModel = new Registration;
        $this->chatModel = new Chat;
        
        //$this->middleware('auth');
    }
    
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // select all users except logged in user
        // $users = Registration::where('id', '!=', Auth::id())->get();
        //echo "uuuuuu>>>>>>>>> ".Auth::id(); exit();
        
        
        // count how many message are unread from the selected user
        /*$data['users'] = DB::select("select registrations.id, registrations.name, registrations.profile_photo, registrations.email, chat.message, count(is_read) as unread 
        from registrations LEFT  JOIN  chat ON registrations.id = chat.from and is_read = 0 and chat.to = " . session('id') . "
        where registrations.id != " . session('id') . " 
        group by registrations.id, registrations.name, registrations.profile_photo, registrations.email, chat.message, chat.created_at
        order by chat.created_at desc");*/
        
        $data['users'] = DB::select("select registrations.id, registrations.name, registrations.profile_photo, registrations.email, count(is_read) as unread 
        from registrations LEFT  JOIN  chat ON registrations.id = chat.from and chat.to = " . session('id') . "
        where registrations.id != " . session('id') . " AND registrations.deleted_at IS NOT NULL
        group by registrations.id, registrations.name, registrations.profile_photo, registrations.email");
        
        
        $data['allUsers'] = $this->registrationModel->where('deleted_at', '=', null)->where('id','<>',session('id'))->get(); 
        
        
        //echo "<pre>"; print_r($data['users']); exit();
        
        $data['user'] = $this->registrationModel->where('deleted_at', '=', null)->where(['id'=>session('id')])->first(); 
        
        if($data['user']->role=='1'){
            return view('student.messages',$data);
        }else{
            return view('teacher.messages',$data);
        }

        
    }

    public function getMessage($user_id)
    {
        //$my_id = Auth::id();
        
        $my_id = session('id');
        
        
        $data['user'] = $this->registrationModel->where('deleted_at', '=', null)->where(['id'=>$user_id])->first(); 

        // Make read all unread message
        Chat::where(['from' => $user_id, 'to' => $my_id])->update(['is_read' => 1]);

        // Get all message from selected user
        $data['messages'] = Chat::where(function ($query) use ($user_id, $my_id) {
                                    $query->where('from', $user_id)->where('to', $my_id);
                                })->oRwhere(function ($query) use ($user_id, $my_id) {
                                    $query->where('from', $my_id)->where('to', $user_id);
                                })->get();

        return view('user.chat-messages', $data); 
        
    }

    public function sendMessage(Request $request)
    {
        //$from = Auth::id();
        $from = session('id');
        $to = $request->receiver_id;
        $message = $request->message;

        $data = new Chat();
        $data->from = $from;
        $data->to = $to;
        $data->message = $message;
        $data->is_read = 0; // message will be unread when sending message
        $data->save();

        // pusher
        $options = array(
            'cluster' => 'ap2',
            'useTLS' => true
        );

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        $data = ['from' => $from, 'to' => $to]; // sending from and to user id when pressed enter
        $result = $pusher->trigger('my-channel', 'my-event', $data);
        
        dd($result);
    }
    
    
    public function sendFile(Request $request, $receiver_id)
    { 
        $from = session('id');
        $to = $receiver_id;
            
        if(isset($_FILES['file']['name'])){ 

            // Getting file name 
            $filename = $_FILES['file']['name'];
            $newFilename = str_replace(' ', '_', $filename);
            $FileNameToStore = 'chat_'.$receiver_id.'_'.time().'_'.$newFilename; 
            
            
            // Location 
            $location = storage_path('app/chat/'.$FileNameToStore);
            $imageFileType = pathinfo($location,PATHINFO_EXTENSION);
            $imageFileType = strtolower($imageFileType);
        
            // Valid extensions 
            $valid_extensions = array("jpg","jpeg","png","doc","docx","xls","pdf","txt"); 
        
            $response = 0;
            
           // Check file extension 
            if(in_array(strtolower($imageFileType), $valid_extensions)) {
              // Upload file 
              if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
                $response = $location;
                 
                
                $data = new Chat();
                $data->from = $from;
                $data->to = $to;
                $data->file = $FileNameToStore;
                $data->is_read = 0; // message will be unread when sending message
                $data->save();
        
                
              }
            }
            
            
            // pusher
            $options = array(
                'cluster' => 'ap2',
                'useTLS' => true
            );
    
            $pusher = new Pusher(
                env('PUSHER_APP_KEY'),
                env('PUSHER_APP_SECRET'),
                env('PUSHER_APP_ID'),
                $options
            );
    
            $data = ['from' => $from, 'to' => $to]; // sending from and to user id when pressed enter
            $result = $pusher->trigger('my-channel', 'my-event', $data);
            
            dd($result);
           //echo $response;
           //exit;
        }
    }
    
    
    
    public function chat_user_search($search){
        $allUsers = $this->registrationModel->where('deleted_at', '=', null)->where('id','<>',session('id'))
                                            ->where('name','like','%'.$search.'%')->get();
        
        $html = '';
        if($search!=''){
            if(count($allUsers)>0){
                foreach($allUsers as $val){
                    $exists = file_exists( storage_path() . '/app/user_photo/' . $val->profile_photo );
                    
                    $html .= '<div class="friend-drawer friend-drawer--onhover user" id="'.$val->id.'">';
                    if($exists && $val->profile_photo!=''){
                        $html .= '<img src="'.url("storage/app/user_photo/".$val->profile_photo).'" class="profile-image">';
                    }else{
                        $html .= '<img src="'.Asset('public/assets/dist/img/transparent.png').'" class="profile-image">'; 
                    }
                    
                    $html .= '<div class="text">';
        			$html .= '<h6>'.$val->name.'</h6>';
        			$html .= '<p class="text-muted"> </p>';
        		    $html .= '</div>';
        		    
        		    //$html .= '<div style="width:30%"><i class="fa fa-times-circle-o chatReload" aria-hidden="true"></i></div>';
        		  
                    $html .= '</div>';
                    
                }
            }else{
                $html .= '<div class="friend-drawer friend-drawer--onhover">';
                $html .= '<div class="text">';
                $html .= '<h6 class="text-center">No user found!</h6>';
                $html .= '</div>';
                
                //$html .= '<div style="width:30%"><i class="fa fa-times-circle-o chatReload" aria-hidden="true"></i></div>';
                
                $html .= '</div>';
            }
        }
        
        echo $html;
    }
    

}



?>
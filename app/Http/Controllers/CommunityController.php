<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Registration;
use App\Models\Community;
use App\Models\CommunityComments;

use Session;
use Validator;
//use Hash;
//use Carbon\Carbon;

use Illuminate\Support\Facades\Storage;


class CommunityController extends Controller
{
    protected $registrationModel;
    protected $communityModel;
    protected $communityCommentsModel;
    
    public function __construct(){
        $this->registrationModel = new Registration;
        $this->communityModel = new Community;
        $this->communityCommentsModel = new CommunityComments;
    }
    
    public function index(){ 
        $data['title']="Community";
        $data['breadcrumb']='Community';

        $data['communities'] = $this->communityModel->where('post_type', '=', 'article')->where('status', '=', '1')->where('deleted_at', '=', null)->get(); 
        
        $data['TrendingArticles'] = $this->communityModel->where('post_type', '=', 'article')
                                                        ->where('status', '=', '1')
                                                        ->where('deleted_at', '=', null)
                                                        ->orderBy('created_at', 'desc')->limit(4)->get(); 
                                                
        //echo "<pre>"; print_r($data['communities']); exit();
        return view('community.list',$data);
        
    }
    
    
    public function add(Request $request){  //echo "aaaaaaaaaaaaaa"; exit(); 
        $data['title']="Community";
        $data['breadcrumb']='Community';

        
        if(count($request->all()) > 0) {   
            
            if($request->post_type=='forum'){
                $validator = Validator::make($request->all(), [
                            'post_type' => 'required',
                            'forum_topic' => 'required',
                            'title' => 'required',
                            'description' => 'required',
                            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                        ]);
            }else{
                $validator = Validator::make($request->all(), [
                            'post_type' => 'required',
                            'title' => 'required',
                            'description' => 'required',
                            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                        ]);
            }
            
                        
            if ($validator->fails()) { 
                if($request->role=='2'){
                    return redirect('community/add')->withErrors($validator)->withInput();
                }else{
                    return redirect('student-dashboard'); 
                }
                
            }else{
                
                
                try{
                    
                    // Handle Photo File Upload ================================================================
                    if($request->hasFile('photo')) {
                        $filenameWithExt = $request->file('photo')->getClientOriginalName();
                        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);    // Get just filename 
                        $filename = str_replace(' ', '_', $filename);
                       
                        $extension = $request->file('photo')->getClientOriginalExtension();  // Get just ext
                        
                        $photoFileNameToStore = 'article_'.$filename.'_'.time().'.'.$extension;         //Filename to store              
                        $destinationPath = storage_path('app/article');
                        
                        $request->file('photo')->move($destinationPath, $photoFileNameToStore);
                                
                    } else {
                        $photoFileNameToStore = '';
                    }    
                    
                    
                    if($request->post_type=='forum'){
                        $forum_topic = $request->forum_topic;
                        $status = '1';
                    }else{
                        $forum_topic = '';
                        $status = '2';
                    }
                    
                    
                    $insertData = [
                                'post_type'=>$request->post_type,
                                'forum_topic'=>$forum_topic,
                                'title'=>ucfirst($request->title),
                                'description'=>$request->description,
                                'photo'=>$photoFileNameToStore,
                                'added_by'=>session('id'),
                                'status'=>$status,
                                'created_at'=>date('Y-m-d H:i:s')
                            ];

                    $communityId = $this->communityModel->insertGetId($insertData);
                    
                    if($request->role=='2'){
                        return redirect('community/add')->with('success','Community data has been added successfully.');
                    }else{
                        return redirect('student-dashboard')->with('error','You dont have the access to add community data.');
                    }
                    
                }catch(Exception $e){
                    
                    if($request->role=='2'){
                        return redirect('community/add')->with('error','Please try again!');
                    }else{
                        return redirect('student-dashboard')->with('error','Please try again!'); 
                    }
                }
                
                
            }
            
        }else{
            return view('community.add',$data);
        }
    }
    
    
    public function get_community_detail(Request $request){
        $data['title']="Community Detail";
        $data['breadcrumb']="Community";
        
        $community_id = $request->id;
        $communityData = $this->communityModel->where(['id'=>$community_id])->first();
        
        $data['lastPosts'] = $this->communityModel->where('post_type', '=', 'article')
                                                ->where('id', '<>', $community_id)
                                                ->where('status', '=', '1')
                                                ->where('deleted_at', '=', null)
                                                ->orderBy('created_at', 'desc')->limit(2)->get(); 
                                                
        $data['comment_count'] = $this->communityCommentsModel->where(['community_id'=>$community_id])->count(); 
        $data['comments'] = $this->communityCommentsModel->where(['community_id'=>$community_id])->get(); 
        
        if($communityData){
            $data['community']=$communityData;  
        }else{
            return redirect('/community')->with('error','Community detail not found!');
        }
        return view('community.details',$data);

    }
    
    
    
    public function post_comments(Request $request){ 
        $data['title']="Community comments";
        $data['breadcrumb']='Community comments';
        
        $community_id = $request->community_id;
        $user_id = session('id'); 
        $user_role = session('role');
        
        if(count($request->all()) > 0) {   
            
            $validator = Validator::make($request->all(), [
                        'comment' => 'required',
                        'community_id' => 'required',
                    ]);
                        
            if ($validator->fails()) { 
                return redirect('community/'.$community_id)->withErrors($validator)->withInput();
            }else{
                
                try{
                    
                    $insertData = [
                                'community_id'=>$request->community_id,
                                'user_id'=>session('id'),
                                'comments'=>ucfirst($request->comment),
                                'created_at'=>date('Y-m-d H:i:s')
                            ];

                    $commentId = $this->communityCommentsModel->insertGetId($insertData);
                    
                    return redirect('community/'.$community_id)->with('success','Your comment data has been added successfully.');
                    
                }catch(Exception $e){
                    return redirect('community/'.$community_id)->with('error','Please try again!');
                }
                
                
            }
            
        }else{
            return redirect('community/'.$community_id);
        }
    }
 
    

}



?>
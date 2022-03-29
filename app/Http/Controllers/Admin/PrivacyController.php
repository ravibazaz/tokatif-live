<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Privacy;

use Validator;
use Hash;
use DB;


class PrivacyController extends Controller
{
    protected $privacyModel;
    public function __construct(){
        $this->privacyModel = new Privacy;
    }

    public function list(Request $request){
        $data['title']="Privacy";
        $data['breadcrumb']='Privacy';

        $privacyData = $this->privacyModel->where('deleted_at', '=', null)->orderBy('id','desc')->paginate(15);
        
        $data['privacy'] = $privacyData; 

        return view('admin.privacy.list',$data);
        
    }

    public function add(Request $request){
        $data['title']="Add Privacy";
        $data['breadcrumb']="Privacy";

        if(count($request->all()) > 0) {   

            $validator = Validator::make($request->all(), [
                            'title' => 'required|string',
                            'description' => 'required|string'
                        ]);


            if ($validator->fails()) { 
                return redirect('admin/privacy/add')->withErrors($validator)->withInput();
            }else{  
                
                $privacyData = $this->privacyModel->where(['title'=>$request->title])->get(); 
                if(count($privacyData)>0){
                    return redirect('admin/privacy/add')->with('error','Privacy title already exists!')->withInput();
                }
                    
                $insertData = [
                                'title'=>ucfirst($request->title),
                                'description'=>ucfirst($request->description),
                                'created_at'=>date('Y-m-d H:i:s')
                            ];

                $privacyData = $this->privacyModel->insertGetId($insertData);

                if($privacyData!=''){
                    return redirect('admin/privacy')->with('success','Privacy data has been created successfully.');
                }else{
                    return redirect('admin/privacy/add')->with('error','Please try again!');
                }
                
     
            }

        } 


        return view('admin.privacy.add',$data);
        
    }

    public function edit(Request $request, $id){
        $data['title']="Edit Privacy";
        $data['breadcrumb']="Privacy";

        $data['privacy'] = $this->privacyModel->where(['id'=>$id])->first();

        if(count($request->all()) > 0) { 

            $validator = Validator::make($request->all(), [
                        'title' => 'required|string',
                        'description' => 'required|string'
                    ]);

            if ($validator->fails()) { 
                return redirect('admin/privacy/'.$id)->withErrors($validator)->withInput();
            }else{ 

               
                $privacyData = $this->privacyModel->where(['title'=>$request->title])->get();
                if(count($privacyData)>0 && $request->title != $data['privacy']->title){
                    return redirect('admin/privacy/'.$id)->with('error','Privacy title already exists!');
                }else{
                    
                    $updateData=[];
    
                    $updateData['updated_at'] = date('Y-m-d H:i:s'); 
    
    
                    if($request->has('title')){
                        $updateData['title'] = ucfirst($request->title); 
                    }
                    if($request->has('description')){
                        $updateData['description'] = ucfirst($request->description); 
                    }
                    
                                  
                    try{
                        $this->privacyModel->where('id',$id)->update($updateData);
    
                        return redirect('admin/privacy/')->with('success','Privacy has been updated successfully.');
                        
                    }catch(Exception $e){
                        return redirect('admin/privacy/'.$id)->with('error','Please try again!');
                    }
                    
                    
                }

                
            }
        }


        return view('admin.privacy.edit',$data);
    }


    
    public function delete($id){  
        $privacyData = $this->privacyModel->where('id',$id)->first();
        if($privacyData){ 
            $privacy = $this->privacyModel->where(['id'=>$id])->delete();
            return redirect('admin/privacy')->with('success','Privacy has been deleted successfully.');
        }else{
            return redirect('admin/privacy')->with('error','Privacy not found!');
        }
        
    }

}


?>
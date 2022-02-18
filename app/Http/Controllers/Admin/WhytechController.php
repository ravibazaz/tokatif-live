<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Whytech;

use Validator;
use Hash;
use DB;


class WhytechController extends Controller
{
    protected $whytechModel;
    public function __construct(){
        $this->whytechModel = new Whytech;
    }

    public function list(Request $request){
        $data['title']="Why Tech";
        $data['breadcrumb']='Why Tech';

        $whytechData = $this->whytechModel->where('deleted_at', '=', null)->orderBy('id','desc')->paginate(15);
        
        $data['whytech']=$whytechData; 

        return view('admin.home.whytech.list',$data);
        
    }

    public function add(Request $request){
        $data['title']="Add Why Tech";
        $data['breadcrumb']="Why Tech";

        if(count($request->all()) > 0) {   

            $validator = Validator::make($request->all(), [
                            'title' => 'required|string',
                            'description' => 'required|string',
                            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
                        ]);


            if ($validator->fails()) { 
                return redirect('admin/whytech/add')->withErrors($validator)->withInput();
            }else{  
                
                $whytech = $this->whytechModel->where(['title'=>$request->title])->get(); 
                if(count($whytech)>0){
                    return redirect('admin/whytech/add')->with('error','Why tech title already exists!')->withInput();
                }
                
                if($request->hasFile('image')) {
                    $filenameWithExt = $request->file('image')->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);    // Get just filename  
                    $filename = str_replace(' ', '_', $filename);
                   
                    $extension = $request->file('image')->getClientOriginalExtension();  // Get just ext
                    
                    $photoFileNameToStore = 'WT_'.$filename.'_'.time().'.'.$extension;         //Filename to store              
                    $destinationPath = storage_path('app/whytech');
                    
                    $request->file('image')->move($destinationPath, $photoFileNameToStore);
                            
                } else {
                    $photoFileNameToStore = 'noimage.jpg';
                }
                
                    
                $insertData = [
                                'title'=>ucfirst($request->title),
                                'description'=>ucfirst($request->description),
                                'image'=>$photoFileNameToStore,
                                'created_at'=>date('Y-m-d H:i:s')
                            ];

                $whytechId = $this->whytechModel->insertGetId($insertData);

                if($whytechId!=''){
                    return redirect('admin/whytech')->with('success','Why tech data has been created successfully.');
                }else{
                    return redirect('admin/whytech/add')->with('error','Please try again!');
                }
                
     
            }

        } 


        return view('admin.home.whytech.add',$data);
        
    }

    public function edit(Request $request, $id){
        $data['title']="Edit Why Tech";
        $data['breadcrumb']="Why Tech";

        $data['whytech'] = $this->whytechModel->where(['id'=>$id])->first();

        if(count($request->all()) > 0) { 
            
            if($request->image!=''){
                $validator = Validator::make($request->all(), [
                            'title' => 'required|string',
                            'description' => 'required|string',
                            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
                        ]);
            }else{
                $validator = Validator::make($request->all(), [
                            'title' => 'required|string',
                            'description' => 'required|string',
                            //'earlier_img' => 'required',
                        ]);
            }
            

            if ($validator->fails()) { 
                return redirect('admin/whytech/'.$id)->withErrors($validator)->withInput();
            }else{ 

               
                $whytech = $this->whytechModel->where(['title'=>$request->title])->get();
                if(count($whytech)>0 && $request->title != $data['whytech']->title){
                    return redirect('admin/whytech/'.$id)->with('error','Why tech title already exists!');
                }else{
                    
                    $error_filesImage = $_FILES['image']['size'];
                    if($error_filesImage == 0){
                        $img = $request->earlier_img;
                    }else{
                        
                        if($request->earlier_img!=''){
                            $exists = file_exists( storage_path() . '/app/whytech/' . $request->earlier_img );
                            if($exists) {
                               unlink(storage_path('app/whytech/'.$request->earlier_img)); 
                            }
                        }
                        
                        $filenameWithExt = $request->file('image')->getClientOriginalName();
                        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);    // Get just filename 
                        $filename = str_replace(' ', '_', $filename);
                        
                        
                        $extension = $request->file('image')->getClientOriginalExtension();  // Get just ext
                        
                        $img = 'WT_'.$filename.'_'.time().'.'.$extension;         //Filename to store              
                        $destinationPath = storage_path('app/whytech');
                  
                        
                        $request->file('image')->move($destinationPath, $img);
                    }
                    
                    
                    
                

                    $updateData=[];
    
                    $updateData['updated_at'] = date('Y-m-d H:i:s'); 
    
    
                    if($request->has('title')){
                        $updateData['title'] = $request->title; 
                    }
                    if($request->has('description')){
                        $updateData['description'] = $request->description; 
                    }
                    if($request->hasFile('image')) {
                        $updateData['image'] = $img; 
                    }

                    
                                  
                    try{
                        $this->whytechModel->where('id',$id)->update($updateData);
    
                        return redirect('admin/whytech/')->with('success','Why tech has been updated successfully.');
                        
                    }catch(Exception $e){
                        return redirect('admin/whytech/'.$id)->with('error','Please try again!');
                    }
                    
                    
                }

                
            }
        }


        return view('admin.home.whytech.edit',$data);
    }


    
    public function delete($id){  
        $whytech = $this->whytechModel->where('id',$id)->first();
        if($whytech){ 
            $exists = file_exists( storage_path() . '/app/whytech/' . $whytech->image ); 
            if($exists && $whytech->image!='') {
                unlink(storage_path('app/whytech/'.$whytech->image));
            }
            
            $whytech = $this->whytechModel->where(['id'=>$id])->delete();
            return redirect('admin/whytech')->with('success','Why tech has been deleted successfully.');
        }else{
            return redirect('admin/whytech')->with('error','Why tech not found!');
        }
        
    }

}




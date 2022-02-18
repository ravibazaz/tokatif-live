<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Whylearn;

use Validator;
use Hash;
use DB;


class WhylearnController extends Controller
{
    protected $whylearnModel;
    public function __construct(){
        $this->whylearnModel = new Whylearn;
    }

    public function list(Request $request){
        $data['title']="Why Learn";
        $data['breadcrumb']='Why Learn';

        $whylearnData = $this->whylearnModel->where('deleted_at', '=', null)->orderBy('id','desc')->paginate(15);
        
        $data['whylearn']=$whylearnData; 

        return view('admin.home.whylearn.list',$data);
        
    }

    public function add(Request $request){
        $data['title']="Add Why Learn";
        $data['breadcrumb']="Why Learn";

        if(count($request->all()) > 0) {   

            $validator = Validator::make($request->all(), [
                            'title' => 'required|string',
                            'description' => 'required|string',
                            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
                            'hover_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
                        ]);


            if ($validator->fails()) { 
                return redirect('admin/whylearn/add')->withErrors($validator)->withInput();
            }else{  
                
                $whylearn = $this->whylearnModel->where(['title'=>$request->title])->get(); 
                if(count($whylearn)>0){
                    return redirect('admin/whylearn/add')->with('error','Why learn title already exists!')->withInput();
                }
                
                if($request->hasFile('image')) {
                    $filenameWithExt = $request->file('image')->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);    // Get just filename  
                    $filename = str_replace(' ', '_', $filename);
                   
                    $extension = $request->file('image')->getClientOriginalExtension();  // Get just ext
                    
                    $photoFileNameToStore = 'WL_'.$filename.'_'.time().'.'.$extension;         //Filename to store              
                    $destinationPath = storage_path('app/whylearn');
                    
                    $request->file('image')->move($destinationPath, $photoFileNameToStore);
                            
                } else {
                    $photoFileNameToStore = 'noimage.jpg';
                }
                
                
                if($request->hasFile('hover_image')) {
                    $filenameWithExt = $request->file('hover_image')->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);    // Get just filename 
                    $filename = str_replace(' ', '_', $filename);
                    
                    
                    $extension = $request->file('hover_image')->getClientOriginalExtension();  // Get just ext
                    
                    $imagename_hover_image = 'WL_hover_'.$filename.'_'.time().'.'.$extension;         //Filename to store              
                    $destinationPath = storage_path('app/whylearn');
              
                    
                    $request->file('hover_image')->move($destinationPath, $imagename_hover_image);
                }else{
                    $imagename_hover_image = 'noimage.jpg';
                }
                
                
                    
                $insertData = [
                                'title'=>ucfirst($request->title),
                                'description'=>ucfirst($request->description),
                                'image'=>$photoFileNameToStore,
                                'hover_image'=>$imagename_hover_image,
                                'created_at'=>date('Y-m-d H:i:s')
                            ];

                $whylearnId = $this->whylearnModel->insertGetId($insertData);

                if($whylearnId!=''){
                    return redirect('admin/whylearn')->with('success','Why learn data has been created successfully.');
                }else{
                    return redirect('admin/whylearn/add')->with('error','Please try again!');
                }
                
     
            }

        } 


        return view('admin.home.whylearn.add',$data);
        
    }

    public function edit(Request $request, $id){
        $data['title']="Edit Why Learn";
        $data['breadcrumb']="Why Learn";

        $data['whylearn'] = $this->whylearnModel->where(['id'=>$id])->first();

        if(count($request->all()) > 0) { 
            
            if($request->image!='' && $request->hover_image!=''){
                $validator = Validator::make($request->all(), [
                            'title' => 'required|string',
                            'description' => 'required|string',
                            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
                            'hover_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
                        ]);
            }else{
                $validator = Validator::make($request->all(), [
                            'title' => 'required|string',
                            'description' => 'required|string',
                            //'earlier_img' => 'required',
                            //'earlier_hover_image' => 'required',
                        ]);
            }
            

            if ($validator->fails()) { 
                return redirect('admin/whylearn/'.$id)->withErrors($validator)->withInput();
            }else{ 

               
                $whylearn = $this->whylearnModel->where(['title'=>$request->title])->get();
                if(count($whylearn)>0 && $request->title != $data['whylearn']->title){
                    return redirect('admin/whylearn/'.$id)->with('error','Why learn title already exists!');
                }else{
                    
                    $error_filesImage = $_FILES['image']['size'];
                    if($error_filesImage == 0){
                        $img = $request->earlier_img;
                    }else{
                        
                        if($request->earlier_img!=''){
                            $exists = file_exists( storage_path() . '/app/whylearn/' . $request->earlier_img );
                            if($exists) {
                               unlink(storage_path('app/whylearn/'.$request->earlier_img)); 
                            }
                        }
                        
                        $filenameWithExt = $request->file('image')->getClientOriginalName();
                        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);    // Get just filename 
                        $filename = str_replace(' ', '_', $filename);
                        
                        
                        $extension = $request->file('image')->getClientOriginalExtension();  // Get just ext
                        
                        $img = 'WL_'.$filename.'_'.time().'.'.$extension;         //Filename to store              
                        $destinationPath = storage_path('app/whylearn');
                  
                        
                        $request->file('image')->move($destinationPath, $img);
                    }
                    
                    
                    
                    
                    $error_files_hover_image = $_FILES['hover_image']['size'];
                    if($error_files_hover_image == 0){
                        $imagename_hover_image = $request->earlier_hover_image;
                    }else{
                        
                        if($request->earlier_hover_image!=''){
                            $exists = file_exists( storage_path() . '/app/whylearn/' . $request->earlier_hover_image );
                            if($exists) {
                               unlink(storage_path('app/whylearn/'.$request->earlier_hover_image));
                            }
                        }
                        
                        $filenameWithExt = $request->file('hover_image')->getClientOriginalName();
                        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);    // Get just filename 
                        $filename = str_replace(' ', '_', $filename);
                        
                        
                        $extension = $request->file('hover_image')->getClientOriginalExtension();  // Get just ext
                        
                        $imagename_hover_image = 'WL_hover_'.$filename.'_'.time().'.'.$extension;         //Filename to store              
                        $destinationPath = storage_path('app/whylearn');
                  
                        
                        $request->file('hover_image')->move($destinationPath, $imagename_hover_image);
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
                    if($request->hasFile('hover_image')) {
                        $updateData['hover_image'] = $imagename_hover_image; 
                    }
                    
                                  
                    try{
                        $this->whylearnModel->where('id',$id)->update($updateData);
    
                        return redirect('admin/whylearn/')->with('success','Whylearn has been updated successfully.');
                        
                    }catch(Exception $e){
                        return redirect('admin/whylearn/'.$id)->with('error','Please try again!');
                    }
                    
                    
                }

                
            }
        }


        return view('admin.home.whylearn.edit',$data);
    }


    
    public function delete($id){  
        $whylearn = $this->whylearnModel->where('id',$id)->first();
        if($whylearn){ 
            $exists = file_exists( storage_path() . '/app/whylearn/' . $whylearn->image ); 
            if($exists && $whylearn->image!='') {
                unlink(storage_path('app/whylearn/'.$whylearn->image));
            }
            
            $hexists = file_exists( storage_path() . '/app/whylearn/' . $whylearn->hover_image ); 
            if($hexists && $whylearn->hover_image!='') {
                unlink(storage_path('app/whylearn/'.$whylearn->hover_image));
            }
            
            $whylearn = $this->whylearnModel->where(['id'=>$id])->delete();
            return redirect('admin/whylearn')->with('success','Whylearn has been deleted successfully.');
        }else{
            return redirect('admin/whylearn')->with('error','Whylearn not found!');
        }
        
    }

}





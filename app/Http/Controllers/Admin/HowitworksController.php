<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Howitworks;

use Validator;
use Hash;
use DB;


class HowitworksController extends Controller
{
    protected $howitworksModel;
    public function __construct(){
        $this->howitworksModel = new Howitworks;
    }

    public function list(Request $request){
        $data['title']="How it works";
        $data['breadcrumb']='How it works';

        $howitworksData = $this->howitworksModel->where('deleted_at', '=', null)->orderBy('id','desc')->paginate(15);
        
        $data['howitworks'] = $howitworksData; 

        return view('admin.home.howitworks.list',$data);
        
    }

    public function add(Request $request){
        $data['title']="Add How it works";
        $data['breadcrumb']="How it works";

        if(count($request->all()) > 0) {   

            $validator = Validator::make($request->all(), [
                            'title' => 'required|string',
                            'description' => 'required|string',
                            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
                            'back_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
                        ]);


            if ($validator->fails()) { 
                return redirect('admin/howitworks/add')->withErrors($validator)->withInput();
            }else{  
                
                $howitworks = $this->howitworksModel->where(['title'=>$request->title])->get(); 
                if(count($howitworks)>0){
                    return redirect('admin/howitworks/add')->with('error','Why learn title already exists!')->withInput();
                }
                
                if($request->hasFile('image')) {
                    $filenameWithExt = $request->file('image')->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);    // Get just filename  
                    $filename = str_replace(' ', '_', $filename);
                   
                    $extension = $request->file('image')->getClientOriginalExtension();  // Get just ext
                    
                    $photoFileNameToStore = 'HIW_'.$filename.'_'.time().'.'.$extension;         //Filename to store              
                    $destinationPath = storage_path('app/howitworks');
                    
                    $request->file('image')->move($destinationPath, $photoFileNameToStore);
                            
                } else {
                    $photoFileNameToStore = 'noimage.jpg';
                }
                
                
                if($request->hasFile('back_image')) {
                    $filenameWithExt = $request->file('back_image')->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);    // Get just filename 
                    $filename = str_replace(' ', '_', $filename);
                    
                    
                    $extension = $request->file('back_image')->getClientOriginalExtension();  // Get just ext
                    
                    $imagename_back_image = 'HIW_hover_'.$filename.'_'.time().'.'.$extension;         //Filename to store              
                    $destinationPath = storage_path('app/howitworks');
              
                    
                    $request->file('back_image')->move($destinationPath, $imagename_back_image);
                }else{
                    $imagename_back_image = 'noimage.jpg';
                }
                
                
                    
                $insertData = [
                                'title'=>ucfirst($request->title),
                                'description'=>ucfirst($request->description),
                                'image'=>$photoFileNameToStore,
                                'back_image'=>$imagename_back_image,
                                'created_at'=>date('Y-m-d H:i:s')
                            ];

                $howitworksId = $this->howitworksModel->insertGetId($insertData);

                if($howitworksId!=''){
                    return redirect('admin/howitworks')->with('success','How it works data has been created successfully.');
                }else{
                    return redirect('admin/howitworks/add')->with('error','Please try again!');
                }
                
     
            }

        } 


        return view('admin.home.howitworks.add',$data);
        
    }

    public function edit(Request $request, $id){
        $data['title']="Edit How it works";
        $data['breadcrumb']="How it works";

        $data['howitworks'] = $this->howitworksModel->where(['id'=>$id])->first();

        if(count($request->all()) > 0) { 
            
            if($request->image!='' && $request->back_image!=''){
                $validator = Validator::make($request->all(), [
                            'title' => 'required|string',
                            'description' => 'required|string',
                            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
                            'back_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
                        ]);
            }else{
                $validator = Validator::make($request->all(), [
                            'title' => 'required|string',
                            'description' => 'required|string',
                            //'earlier_img' => 'required',
                            //'earlier_back_image' => 'required',
                        ]);
            }
            

            if ($validator->fails()) { 
                return redirect('admin/howitworks/'.$id)->withErrors($validator)->withInput();
            }else{ 

               
                $howitworks = $this->howitworksModel->where(['title'=>$request->title])->get();
                if(count($howitworks)>0 && $request->title != $data['howitworks']->title){
                    return redirect('admin/howitworks/'.$id)->with('error','How it works title already exists!');
                }else{
                    
                    $error_filesImage = $_FILES['image']['size'];
                    if($error_filesImage == 0){
                        $img = $request->earlier_img;
                    }else{
                        
                        if($request->earlier_img!=''){
                            $exists = file_exists( storage_path() . '/app/howitworks/' . $request->earlier_img );
                            if($exists) {
                               unlink(storage_path('app/howitworks/'.$request->earlier_img)); 
                            }
                        }
                        
                        $filenameWithExt = $request->file('image')->getClientOriginalName();
                        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);    // Get just filename 
                        $filename = str_replace(' ', '_', $filename);
                        
                        
                        $extension = $request->file('image')->getClientOriginalExtension();  // Get just ext
                        
                        $img = 'HIW_'.$filename.'_'.time().'.'.$extension;         //Filename to store              
                        $destinationPath = storage_path('app/howitworks');
                  
                        
                        $request->file('image')->move($destinationPath, $img);
                    }
                    
                    
                    
                    
                    $error_files_back_image = $_FILES['back_image']['size'];
                    if($error_files_back_image == 0){
                        $imagename_back_image = $request->earlier_back_image;
                    }else{
                        
                        if($request->earlier_back_image!=''){
                            $exists = file_exists( storage_path() . '/app/howitworks/' . $request->earlier_back_image );
                            if($exists) {
                               unlink(storage_path('app/howitworks/'.$request->earlier_back_image));
                            }
                        }
                        
                        $filenameWithExt = $request->file('back_image')->getClientOriginalName();
                        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);    // Get just filename 
                        $filename = str_replace(' ', '_', $filename);
                        
                        
                        $extension = $request->file('back_image')->getClientOriginalExtension();  // Get just ext
                        
                        $imagename_back_image = 'HIW_hover_'.$filename.'_'.time().'.'.$extension;         //Filename to store              
                        $destinationPath = storage_path('app/howitworks');
                  
                        
                        $request->file('back_image')->move($destinationPath, $imagename_back_image);
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
                    if($request->hasFile('back_image')) {
                        $updateData['back_image'] = $imagename_back_image; 
                    }
                    
                                  
                    try{
                        $this->howitworksModel->where('id',$id)->update($updateData);
    
                        return redirect('admin/howitworks/')->with('success','How it works has been updated successfully.');
                        
                    }catch(Exception $e){
                        return redirect('admin/howitworks/'.$id)->with('error','Please try again!');
                    }
                    
                    
                }

                
            }
        }


        return view('admin.home.howitworks.edit',$data);
    }


    
    public function delete($id){  
        $howitworks = $this->howitworksModel->where('id',$id)->first();
        if($howitworks){ 
            $exists = file_exists( storage_path() . '/app/howitworks/' . $howitworks->image ); 
            if($exists && $howitworks->image!='') {
                unlink(storage_path('app/howitworks/'.$howitworks->image));
            }
            
            $hexists = file_exists( storage_path() . '/app/howitworks/' . $howitworks->back_image ); 
            if($hexists && $howitworks->back_image!='') {
                unlink(storage_path('app/howitworks/'.$howitworks->back_image));
            }
            
            $howitworks = $this->howitworksModel->where(['id'=>$id])->delete();
            return redirect('admin/howitworks')->with('success','How it works data has been deleted successfully.');
        }else{
            return redirect('admin/howitworks')->with('error','How it works data not found!');
        }
        
    }

}





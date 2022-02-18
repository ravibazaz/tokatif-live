<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Support;

use Validator;
use Hash;
use DB;


class SupportController extends Controller
{
    protected $supportModel;
    public function __construct(){
        $this->supportModel = new Support;
    }

    public function list(Request $request){
        $data['title']="Support";
        $data['breadcrumb']='Support';

        $supportData = $this->supportModel->where('deleted_at', '=', null)->orderBy('id','desc')->paginate(15);
        
        $data['support'] = $supportData; 

        return view('admin.support.list',$data);
        
    }

    public function add(Request $request){
        $data['title']="Add Support";
        $data['breadcrumb']="Support";

        if(count($request->all()) > 0) {   

            $validator = Validator::make($request->all(), [
                            'title' => 'required|string',
                            'description' => 'required|string',
                            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
                        ]);


            if ($validator->fails()) { 
                return redirect('admin/support/add')->withErrors($validator)->withInput();
            }else{  
                
                $supportData = $this->supportModel->where(['title'=>$request->title])->get(); 
                if(count($supportData)>0){
                    return redirect('admin/support/add')->with('error','Support title already exists!')->withInput();
                }
                
                if($request->hasFile('image')) {
                    $filenameWithExt = $request->file('image')->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);    // Get just filename  
                    $filename = str_replace(' ', '_', $filename);
                   
                    $extension = $request->file('image')->getClientOriginalExtension();  // Get just ext
                    
                    $photoFileNameToStore = 'S_'.$filename.'_'.time().'.'.$extension;         //Filename to store              
                    $destinationPath = storage_path('app/support');
                    
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

                $supportData = $this->supportModel->insertGetId($insertData);

                if($supportData!=''){
                    return redirect('admin/support')->with('success','Support data has been created successfully.');
                }else{
                    return redirect('admin/support/add')->with('error','Please try again!');
                }
                
     
            }

        } 


        return view('admin.support.add',$data);
        
    }

    public function edit(Request $request, $id){
        $data['title']="Edit Support";
        $data['breadcrumb']="Support";

        $data['support'] = $this->supportModel->where(['id'=>$id])->first();

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
                return redirect('admin/support/'.$id)->withErrors($validator)->withInput();
            }else{ 

               
                $supportData = $this->supportModel->where(['title'=>$request->title])->get();
                if(count($supportData)>0 && $request->title != $data['support']->title){
                    return redirect('admin/support/'.$id)->with('error','Support title already exists!');
                }else{
                    
                    $error_filesImage = $_FILES['image']['size'];
                    if($error_filesImage == 0){
                        $img = $request->earlier_img;
                    }else{
                        
                        if($request->earlier_img!=''){
                            $exists = file_exists( storage_path() . '/app/support/' . $request->earlier_img );
                            if($exists) {
                               unlink(storage_path('app/support/'.$request->earlier_img)); 
                            }
                        }
                        
                        $filenameWithExt = $request->file('image')->getClientOriginalName();
                        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);    // Get just filename 
                        $filename = str_replace(' ', '_', $filename);
                        
                        
                        $extension = $request->file('image')->getClientOriginalExtension();  // Get just ext
                        
                        $img = 'S_'.$filename.'_'.time().'.'.$extension;         //Filename to store              
                        $destinationPath = storage_path('app/support');
                  
                        
                        $request->file('image')->move($destinationPath, $img);
                    }
                    
                    
                    
                

                    $updateData=[];
    
                    $updateData['updated_at'] = date('Y-m-d H:i:s'); 
    
    
                    if($request->has('title')){
                        $updateData['title'] = ucfirst($request->title); 
                    }
                    if($request->has('description')){
                        $updateData['description'] = ucfirst($request->description); 
                    }
                    if($request->hasFile('image')) {
                        $updateData['image'] = $img; 
                    }

                    
                                  
                    try{
                        $this->supportModel->where('id',$id)->update($updateData);
    
                        return redirect('admin/support/')->with('success','Support has been updated successfully.');
                        
                    }catch(Exception $e){
                        return redirect('admin/support/'.$id)->with('error','Please try again!');
                    }
                    
                    
                }

                
            }
        }


        return view('admin.support.edit',$data);
    }


    
    public function delete($id){  
        $supportData = $this->supportModel->where('id',$id)->first();
        if($supportData){ 
            $exists = file_exists( storage_path() . '/app/support/' . $supportData->image ); 
            if($exists && $supportData->image!='') {
                unlink(storage_path('app/support/'.$supportData->image));
            }
            
            $support = $this->supportModel->where(['id'=>$id])->delete();
            return redirect('admin/support')->with('success','Support has been deleted successfully.');
        }else{
            return redirect('admin/support')->with('error','Support not found!');
        }
        
    }

}


?>
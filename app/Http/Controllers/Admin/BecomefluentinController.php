<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Becomefluent;

use Validator;
use Hash;
use DB;


class BecomefluentinController extends Controller
{
    protected $becomefluentModel;
    public function __construct(){
        $this->becomefluentModel = new Becomefluent;
    }

    public function list(Request $request){
        $data['title']="Become Fluent";
        $data['breadcrumb']='become fluent';

        $becomefluentData = $this->becomefluentModel->where('deleted_at', '=', null)->orderBy('id','desc')->paginate(15);
        
        $data['becomefluent'] = $becomefluentData; 

        return view('admin.home.becomefluent.list',$data);
        
    }

    public function add(Request $request){
        $data['title']="Add become fluent";
        $data['breadcrumb']="become fluent";

        if(count($request->all()) > 0) {   

            $validator = Validator::make($request->all(), [
                            'title' => 'required|string',
                            'description' => 'required|string',
                            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
                        ]);


            if ($validator->fails()) { 
                return redirect('admin/becomefluentin/add')->withErrors($validator)->withInput();
            }else{  
                
                $becomefluent = $this->becomefluentModel->where(['title'=>$request->title])->get(); 
                if(count($becomefluent)>0){
                    return redirect('admin/becomefluentin/add')->with('error','Become fluent title already exists!')->withInput();
                }
                
                if($request->hasFile('image')) {
                    $filenameWithExt = $request->file('image')->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);    // Get just filename  
                    $filename = str_replace(' ', '_', $filename);
                   
                    $extension = $request->file('image')->getClientOriginalExtension();  // Get just ext
                    
                    $photoFileNameToStore = 'BF_'.$filename.'_'.time().'.'.$extension;         //Filename to store              
                    $destinationPath = storage_path('app/becomefluent');
                    
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

                $howitworksId = $this->becomefluentModel->insertGetId($insertData);

                if($howitworksId!=''){
                    return redirect('admin/becomefluentin')->with('success','Become fluent data has been created successfully.');
                }else{
                    return redirect('admin/becomefluentin/add')->with('error','Please try again!');
                }
                
     
            }

        } 


        return view('admin.home.becomefluent.add',$data);
        
    }

    public function edit(Request $request, $id){
        $data['title']="Edit become fluent";
        $data['breadcrumb']="become fluent";

        $data['becomefluent'] = $this->becomefluentModel->where(['id'=>$id])->first();

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
                return redirect('admin/becomefluentin/'.$id)->withErrors($validator)->withInput();
            }else{ 

               
                $becomefluent = $this->becomefluentModel->where(['title'=>$request->title])->get();
                if(count($becomefluent)>0 && $request->title != $data['becomefluent']->title){
                    return redirect('admin/becomefluentin/'.$id)->with('error','Become fluent title already exists!');
                }else{
                    
                    $error_filesImage = $_FILES['image']['size'];
                    if($error_filesImage == 0){
                        $img = $request->earlier_img;
                    }else{
                        
                        if($request->earlier_img!=''){
                            $exists = file_exists( storage_path() . '/app/becomefluent/' . $request->earlier_img );
                            if($exists) {
                               unlink(storage_path('app/becomefluent/'.$request->earlier_img)); 
                            }
                        }
                        
                        $filenameWithExt = $request->file('image')->getClientOriginalName();
                        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);    // Get just filename 
                        $filename = str_replace(' ', '_', $filename);
                        
                        
                        $extension = $request->file('image')->getClientOriginalExtension();  // Get just ext
                        
                        $img = 'BF_'.$filename.'_'.time().'.'.$extension;         //Filename to store              
                        $destinationPath = storage_path('app/becomefluent');
                  
                        
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
                        $this->becomefluentModel->where('id',$id)->update($updateData);
    
                        return redirect('admin/becomefluentin/')->with('success','Become fluent has been updated successfully.');
                        
                    }catch(Exception $e){
                        return redirect('admin/becomefluentin/'.$id)->with('error','Please try again!');
                    }
                    
                    
                }

                
            }
        }


        return view('admin.home.becomefluent.edit',$data);
    }


    
    public function delete($id){  
        $becomefluent = $this->becomefluentModel->where('id',$id)->first();
        if($becomefluent){ 
            $exists = file_exists( storage_path() . '/app/becomefluent/' . $becomefluent->image ); 
            if($exists && $becomefluent->image!='') {
                unlink(storage_path('app/becomefluent/'.$becomefluent->image));
            }
            
            $becomefluent = $this->becomefluentModel->where(['id'=>$id])->delete();
            return redirect('admin/becomefluentin')->with('success','Become fluent data has been deleted successfully.');
        }else{
            return redirect('admin/becomefluentin')->with('error','Become fluent data not found!');
        }
        
    }

}





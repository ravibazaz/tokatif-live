<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Language;

use Validator;
use Hash;
use DB;


class LanguageController extends Controller
{
    protected $languageModel;
    public function __construct(){
        $this->languageModel = new Language;
    }

    public function list(Request $request){
        $data['title']="languages";
        $data['breadcrumb']='languages';

        $languageData = $this->languageModel->where('deleted_at', '=', null)->orderBy('id','desc')->paginate(15);
        
        $data['languages']=$languageData; 

        return view('admin.home.language.list',$data);
        
    }

    public function add(Request $request){
        $data['title']="Add language";
        $data['breadcrumb']="languages";

        if(count($request->all()) > 0) {   

            $validator = Validator::make($request->all(), [
                            'name' => 'required|string',
                            'image' => 'required'
                        ]);


            if ($validator->fails()) { 
                return redirect('admin/language/add')->withErrors($validator)->withInput();
            }else{  
                
                $language = $this->languageModel->where(['name'=>$request->name])->get(); 
                if(count($language)>0){
                    return redirect('admin/language/add')->with('error','Language already exists!')->withInput();
                }
                
                if($request->hasFile('image')) {
                    $filenameWithExt = $request->file('image')->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);    // Get just filename  
                    $filename = str_replace(' ', '_', $filename);
                   
                    $extension = $request->file('image')->getClientOriginalExtension();  // Get just ext
                    
                    $photoFileNameToStore = 'HL_'.$filename.'_'.time().'.'.$extension;         //Filename to store              
                    $destinationPath = storage_path('app/language');
                    
                    $request->file('image')->move($destinationPath, $photoFileNameToStore);
                            
                } else {
                    $photoFileNameToStore = 'noimage.jpg';
                }
                
                    
                $insertData = [
                                'name'=>ucfirst($request->name),
                                'image'=>$photoFileNameToStore,
                                'created_at'=>date('Y-m-d H:i:s')
                            ];

                $languageId = $this->languageModel->insertGetId($insertData);

                if($languageId!=''){
                    return redirect('admin/languages')->with('success','Language has been created successfully.');
                }else{
                    return redirect('admin/language/add')->with('error','Please try again!');
                }
                
     
            }

        } 


        return view('admin.home.language.add',$data);
        
    }

    public function edit(Request $request, $id){
        $data['title']="Edit languages";
        $data['breadcrumb']="languages";

        $data['language'] = $this->languageModel->where(['id'=>$id])->first();

        if(count($request->all()) > 0) { 
            $validator = Validator::make($request->all(), [
                            'name' => 'required|string'
                        ]);

            if ($validator->fails()) { 
                return redirect('admin/language/'.$id)->withErrors($validator)->withInput();
            }else{ 

               
                $language = $this->languageModel->where(['name'=>$request->name])->get();
                if(count($language)>0 && $request->name != $data['language']->name){
                    return redirect('admin/language/'.$id)->with('error','Language already exists!');
                }else{
                    
                    $error_filesImage = $_FILES['image']['size'];
                    if($error_filesImage == 0){
                        $img = $request->earlier_img;
                    }else{
                        
                        if($request->earlier_img!=''){
                            $exists = file_exists( storage_path() . '/app/language/' . $request->earlier_img );
                            if($exists) {
                               unlink(storage_path('app/language/'.$request->earlier_img));
                            }
                        }
                        
                        $filenameWithExt = $request->file('image')->getClientOriginalName();
                        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);    // Get just filename 
                        $filename = str_replace(' ', '_', $filename);
                        
                        
                        $extension = $request->file('image')->getClientOriginalExtension();  // Get just ext
                        
                        $img = 'HL_'.$filename.'_'.time().'.'.$extension;         //Filename to store              
                        $destinationPath = storage_path('app/language');
                  
                        
                        $request->file('image')->move($destinationPath, $img);
                    }
                

                    $updateData=[];
    
                    $updateData['updated_at'] = date('Y-m-d H:i:s'); 
    
    
                    if($request->has('name')){
                        $updateData['name'] = $request->name; 
                    }
                    if($request->hasFile('image')) {
                        $updateData['image'] = $img; 
                    }
                    
                                  
                    try{
                        $this->languageModel->where('id',$id)->update($updateData);
    
                        return redirect('admin/languages/')->with('success','Language has been updated successfully.');
                        
                    }catch(Exception $e){
                        return redirect('admin/languages/'.$id)->with('error','Please try again!');
                    }
                    
                    
                }

                
            }
        }


        return view('admin.home.language.edit',$data);
    }


    
    public function delete($id){  
        $language = $this->languageModel->where('id',$id)->first();
        if($language){ 
            $exists = file_exists( storage_path() . '/app/language/' . $language->image ); 
            if($exists && $language->image!='') {
                unlink(storage_path('app/language/'.$language->image));
            }
            $language = $this->languageModel->where(['id'=>$id])->delete();
            return redirect('admin/languages')->with('success','Language has been deleted successfully.');
        }else{
            return redirect('admin/languages')->with('error','Language not found!');
        }
        
    }

}






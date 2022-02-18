<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\WebsiteSetting;

use Validator;
use Hash;
use DB;

class WebsiteSettingController extends Controller
{
    protected $websiteSettingModel;
    public function __construct(){
        $this->websiteSettingModel = new WebsiteSetting;
    }
    
    public function index(Request $request){
        $data['title']="Website Setting";
        $data['breadcrumb']="Website Setting";  

        $data['website_setting'] = $this->websiteSettingModel->where('deleted_at', '=', null)->paginate(15);  
        
        return view('admin.website_setting.list',$data);
    }
    
    
    public function edit(Request $request, $id){
        $data['title']="Edit Website Setting";
        $data['breadcrumb']="Website Setting";

        $data['website_setting'] = $this->websiteSettingModel->where(['id'=>$id])->first(); 

        if(count($request->all()) > 0) { 
            
            $validator = Validator::make($request->all(), [
                                'website' => 'required',
                                'copyright_content' => 'required',
                                'footer_content'=>'required'
                            ]);
            

            if ($validator->fails()) { 
                return redirect('admin/website-setting/'.$id)->withErrors($validator)->withInput();
            }else{ 
                
                
                $error_fileslogo = $_FILES['logo']['size'];
                if($error_fileslogo == 0){
                    $logo = $request->earlier_logo;
                }else{
                    
                    if($request->earlier_logo!=''){
                        $exists = file_exists( storage_path() . '/app/imagesdoc/' . $request->earlier_logo );
                        if($exists) {
                           unlink(storage_path('app/imagesdoc/'.$request->earlier_logo));
                        }
                    }
                        
                    $logo =  $request->file('logo')->store('imagesdoc'); 
                }
                
                
                
                $error_filesfooter_logo = $_FILES['footer_logo']['size'];
                if($error_filesfooter_logo == 0){
                    $footer_logo = $request->earlier_footer_logo;
                }else{
                    if($request->earlier_footer_logo == ""){
                         $footer_logo =  $request->file('footer_logo')->store('imagesdoc'); 
                    }else{
                         
                        if($request->earlier_footer_logo!=''){
                            $exists = file_exists( storage_path() . '/app/imagesdoc/' . $request->earlier_footer_logo );
                            if($exists) {
                               unlink(storage_path('app/imagesdoc/'.$request->earlier_footer_logo));
                            }
                        }
                        
                        $footer_logo =  $request->file('footer_logo')->store('imagesdoc'); 
                    }
                     
                }
                
                
                
                
                $error_filesfavicon = $_FILES['favicon']['size'];
                if($error_filesfavicon == 0){
                    $favicon = $request->earlier_favicon;
                }else{
                    
                    
                    if($request->earlier_favicon!=''){
                        $exists = file_exists( storage_path() . '/app/' . $request->earlier_favicon );
                        if($exists) {
                           unlink(storage_path('app/'.$request->earlier_favicon));
                        }
                    }
                    
                    $filenameWithExt = $request->file('favicon')->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);    // Get just filename 
                    $filename = str_replace(' ', '_', $filename);
              
                    $destinationPath = storage_path('app');
                    
                    $favicon =  $request->file('favicon')->move($destinationPath, $filename);
                }
                
                
                
                    
                $updateData=[];

                $updateData['updated_at'] = date('Y-m-d H:i:s'); 

                if($request->has('website')){
                    $updateData['website'] = ucfirst($request->website); 
                }
                if($request->hasFile('logo')) {
                    $updateData['logo'] = $logo; 
                }
                if($request->hasFile('footer_logo')) {
                    $updateData['footer_logo'] = $footer_logo; 
                }
                if($request->hasFile('favicon')) {
                    $updateData['favicon'] = $favicon; 
                }
                if($request->has('facebook_link')){
                    $updateData['facebook_link'] = $request->facebook_link; 
                }
                if($request->has('linkedin_link')){
                    $updateData['linkedin_link'] = $request->linkedin_link; 
                }
                if($request->has('twitter_link')){
                    $updateData['twitter_link'] = $request->twitter_link;  
                }
                if($request->has('pininterest_link')){
                    $updateData['pininterest_link'] = $request->pininterest_link;  
                }
                if($request->has('copyright_content')){
                    $updateData['copyright_content'] = $request->copyright_content;  
                }
                if($request->has('footer_content')){
                    $updateData['footer_content'] = $request->footer_content;  
                }

                

                try{
                    $this->websiteSettingModel->where('id',$id)->update($updateData);

                    return redirect('admin/website-setting')->with('success','Website setting has been updated successfully.');
                    
                }catch(Exception $e){
                    return redirect('admin/website-setting/'.$id)->with('error','Please try again!');
                }
                
            }
        }

        return view('admin.website_setting.edit',$data);
    }
    
}

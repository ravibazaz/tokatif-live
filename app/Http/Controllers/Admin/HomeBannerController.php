<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;

use Validator;
use Hash;
use DB;


class HomeBannerController extends Controller
{
    protected $bannerModel;
    public function __construct(){
        $this->bannerModel = new Banner;
    }

    public function list(Request $request){
        $data['title']="Banners";
        $data['breadcrumb']='Banners';

        $bannerData = $this->bannerModel->where('deleted_at', '=', null)->orderBy('id','desc')->paginate(15);
        
        $data['banners']=$bannerData; 

        return view('admin.home.banner.list',$data);
        
    }

    public function add(Request $request){
        $data['title']="Add Banner";
        $data['breadcrumb']="Banners";

        if(count($request->all()) > 0) {   

            $validator = Validator::make($request->all(), [
                            'title' => 'required|string',
                            'image' => 'required'
                        ]);


            if ($validator->fails()) { 
                return redirect('admin/home-banner/add')->withErrors($validator)->withInput();
            }else{  
                
                if($request->hasFile('image')) {
                    $filenameWithExt = $request->file('image')->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);    // Get just filename  
                    $filename = str_replace(' ', '_', $filename);
                   
                    $extension = $request->file('image')->getClientOriginalExtension();  // Get just ext
                    
                    $photoFileNameToStore = 'HB_'.$filename.'_'.time().'.'.$extension;         //Filename to store              
                    $destinationPath = storage_path('app/home_banner');
                    
                    $request->file('image')->move($destinationPath, $photoFileNameToStore);
                            
                } else {
                    $photoFileNameToStore = 'noimage.jpg';
                }
                
                    
                $insertData = [
                                'title'=>ucfirst($request->title),
                                'image'=>$photoFileNameToStore,
                                'created_at'=>date('Y-m-d H:i:s')
                            ];

                $bannerId = $this->bannerModel->insertGetId($insertData);

                if($bannerId!=''){
                    return redirect('admin/home-banners')->with('success','Banner has been created successfully.');
                }else{
                    return redirect('admin/home-banner/add')->with('error','Please try again!');
                }
                
     
            }

        } 


        return view('admin.home.banner.add',$data);
        
    }

    public function edit(Request $request, $id){
        $data['title']="Edit Banners";
        $data['breadcrumb']="Banners";

        $data['banner'] = $this->bannerModel->where(['id'=>$id])->first();

        if(count($request->all()) > 0) { 
            $validator = Validator::make($request->all(), [
                            'title' => 'required|string'
                        ]);

            if ($validator->fails()) { 
                return redirect('admin/home-banner/'.$id)->withErrors($validator)->withInput();
            }else{ 

                
                $error_filesImage = $_FILES['image']['size'];
                if($error_filesImage == 0){
                    $img = $request->earlier_img;
                }else{
                    
                    
                    if($request->earlier_img!=''){
                        $exists = file_exists( storage_path() . '/app/home_banner/' . $request->earlier_img );
                        if($exists) {
                           unlink(storage_path('app/home_banner/'.$request->earlier_img));
                        }
                    }
                        
                    
                    $filenameWithExt = $request->file('image')->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);    // Get just filename 
                    $filename = str_replace(' ', '_', $filename);
                    
                    
                    $extension = $request->file('image')->getClientOriginalExtension();  // Get just ext
                    
                    $img = 'HB_'.$filename.'_'.time().'.'.$extension;         //Filename to store              
                    $destinationPath = storage_path('app/home_banner');
              
                    
                    $request->file('image')->move($destinationPath, $img);
                }
                
                
                
                    
                $updateData=[];

                $updateData['updated_at'] = date('Y-m-d H:i:s'); 


                if($request->has('title')){
                    $updateData['title'] = $request->title; 
                }
                if($request->hasFile('image')) {
                    $updateData['image'] = $img; 
                }
                
                              
                try{
                    $this->bannerModel->where('id',$id)->update($updateData);

                    return redirect('admin/home-banners/')->with('success','Banner has been updated successfully.');
                    
                }catch(Exception $e){
                    return redirect('admin/home-banner/'.$id)->with('error','Please try again!');
                }
                
            }
        }


        return view('admin.home.banner.edit',$data);
    }


    
    public function delete($id){  
        $banner = $this->bannerModel->where('id',$id)->first();
        if($banner){ 
            $exists = file_exists( storage_path() . '/app/home_banner/' . $banner->image ); 
            if($exists && $banner->image!='') {
                unlink(storage_path('app/home_banner/'.$banner->image));
            }
            $banner = $this->bannerModel->where(['id'=>$id])->delete();
            return redirect('admin/home-banners')->with('success','Banner has been deleted successfully.');
        }else{
            return redirect('admin/home-banners')->with('error','Banner not found!');
        }
        
    }

}






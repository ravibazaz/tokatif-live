<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Terms;

use Validator;
use Hash;
use DB;


class TermsController extends Controller
{
    protected $termModel;
    public function __construct(){
        $this->termModel = new Terms;
    }

    public function list(Request $request){
        $data['title']="Terms";
        $data['breadcrumb']='Terms';

        $termsData = $this->termModel->where('deleted_at', '=', null)->orderBy('id','desc')->paginate(15);
        
        $data['terms'] = $termsData; 

        return view('admin.terms.list',$data);
        
    }

    public function add(Request $request){
        $data['title']="Add Term";
        $data['breadcrumb']="Terms";

        if(count($request->all()) > 0) {   

            $validator = Validator::make($request->all(), [
                            'title' => 'required|string',
                            'description' => 'required|string'
                        ]);


            if ($validator->fails()) { 
                return redirect('admin/terms/add')->withErrors($validator)->withInput();
            }else{  
                
                $termsData = $this->termModel->where(['title'=>$request->title])->get(); 
                if(count($termsData)>0){
                    return redirect('admin/terms/add')->with('error','Terms title already exists!')->withInput();
                }
                    
                $insertData = [
                                'title'=>ucfirst($request->title),
                                'description'=>ucfirst($request->description),
                                'created_at'=>date('Y-m-d H:i:s')
                            ];

                $termsData = $this->termModel->insertGetId($insertData);

                if($termsData!=''){
                    return redirect('admin/terms')->with('success','Term data has been created successfully.');
                }else{
                    return redirect('admin/terms/add')->with('error','Please try again!');
                }
                
     
            }

        } 


        return view('admin.terms.add',$data);
        
    }

    public function edit(Request $request, $id){
        $data['title']="Edit Term";
        $data['breadcrumb']="Terms";

        $data['terms'] = $this->termModel->where(['id'=>$id])->first();

        if(count($request->all()) > 0) { 

            $validator = Validator::make($request->all(), [
                        'title' => 'required|string',
                        'description' => 'required|string'
                    ]);
            
            if ($validator->fails()) { 
                return redirect('admin/terms/'.$id)->withErrors($validator)->withInput();
            }else{ 

               
                $termsData = $this->termModel->where(['title'=>$request->title])->get();
                if(count($termsData)>0 && $request->title != $data['terms']->title){
                    return redirect('admin/terms/'.$id)->with('error','Term title already exists!');
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
                        $this->termModel->where('id',$id)->update($updateData);
    
                        return redirect('admin/terms/')->with('success','Terms has been updated successfully.');
                        
                    }catch(Exception $e){
                        return redirect('admin/terms/'.$id)->with('error','Please try again!');
                    }
                    
                    
                }

                
            }
        }


        return view('admin.terms.edit',$data);
    }


    
    public function delete($id){  
        $termsData = $this->termModel->where('id',$id)->first();
        if($termsData){ 
            $terms = $this->termModel->where(['id'=>$id])->delete();
            return redirect('admin/terms')->with('success','Term has been deleted successfully.');
        }else{
            return redirect('admin/terms')->with('error','Term not found!');
        }
        
    }

}


?>
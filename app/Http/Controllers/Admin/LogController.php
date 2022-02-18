<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Log;
use App\Models\Customer;

use Illuminate\Support\Facades\DB;

class LogController extends Controller
{
    protected $logModel;
    protected $customerModel;
    public function __construct(){
        $this->logModel = new Log;
        $this->customerModel = new Customer;
    }
    public function list(Request $request){
        $data['title']='Login logout logs';
        $data['breadcrumb']='login-logout-log';
        if($request->has('q')){

            $logs = $this->logModel->whereDate('created_at','=',date('Y-m-d'))
                                    ->orWhere('logType','like','%'.$q.'%')
                                    ->orWhere('userType','like','%'.$q.'%')
                                    ->orderBy('created_at','desc')->get();

        }else{
            $logs = $this->logModel->whereDate('created_at','=',date('Y-m-d'))
                                    ->orderBy('created_at','desc')->get();
        }

        
        $dataArray = array();
        foreach ($logs as $key => $value) {
            $user_id = $value['user_id'];
            $logType = $value['logType'];
            $created_at = $value['created_at'];
            $logTime = date('H:i:s', strtotime($created_at));

            $rowColor = "";
            if($value['userType']=='c'){
                $user = $this->customerModel->where('id','=',$user_id)->first();
                $name = $user->name;
                $type = 'customer';
            }

            $dataArray[] = array(
                                'user_id'=>$user_id,
                                'type'=>$type,
                                'name'=>$name,
                                'logType'=>$logType,
                                'created_at'=>$created_at,
                                'row_color'=>$rowColor
                            );
        }
        //echo "<pre>"; print_r($dataArray); die();    
        $data['logs'] = $dataArray; 

        return view('admin.logs.list',$data);

    }




    /*public function details(Request $request){
        $data['title']="Order Details";
        $data['breadcrumb']="orders";
        //$data['total_order']=0;
        $data['total_price']="Total Price";
        $data['service_charge']="Service Charge";
        //$data['total_spent']=0;
        $order_id = $request->id;
        $order = $this->orderModel->where(['id'=>$order_id])->first();
        //$orderItems = $this->orderItemsModel->where(['order_id'=>$order_id])->get();
        
        $orderItems = $this->orderItemsModel->select('order_items.*','products.prod_name','products.prod_price')
                    ->leftjoin('products', 'products.id', '=', 'order_items.prod_id')
                    ->where(['order_items.order_id'=>$order_id])->get();

        if($order && $orderItems){
            $data['order']=$order;
            $data['order_items']=$orderItems;
        }else{
            return redirect('/admin/orders')->with('error','Order not found');
        }
        return view('admin.orders.details',$data);

    }*/
    

}

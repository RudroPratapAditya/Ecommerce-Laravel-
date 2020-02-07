<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Http\Requests;
use Illuminate\support\Facades\Redirect;
use Session;
use Cart;
Session_start();

class CheckoutController extends Controller
{

   

    public function login_check(){
    	return view('pages.login');
    }

    public function customer_registration(Request $request){

    	$data=array();
    	$data['customer_first_name']=$request->customer_first_name;
    	$data['customer_last_name']=$request->customer_last_name;
    	$data['customer_email']=$request->customer_email;
    	$data['password']=md5($request->password);
    	$data['phone_number']=$request->phone_number;

    	$customer_id=DB::table('tbl_customer')
    	->insertGetId($data);
       Session::put('message','Congrates!!! You have successfully signed up..complete next steps!');
    	Session::put('customer_id',$customer_id);
    	Session::put('customer_first_name',$request->customer_first_name);
    	Session::put('customer_last_name',$request->customer_last_name);
    return Redirect::to('/checkout');
    	


    }


    public function checkout(){

    	return view('pages.checkout');
    }

   

    public function save_shipping_details(Request $request){

    $data=array();
    $data['shipping_email']=$request->shipping_email;
    $data['shipping_first_name']=$request->shipping_first_name;
    $data['shipping_last_name']=$request->shipping_last_name;
    $data['shipping_address']=$request->shipping_address;
    $data['shipping_phone_number']=$request->shipping_phone_number;
    $data['shipping_city']=$request->shipping_city;

    // echo "<pre>";
    // print_r($data);
    // echo "</pre>";

    $shipping_id=DB::table('tbl_shipping')
        ->insertGetId($data);
        Session::put('shipping_id',$shipping_id);
         return Redirect::to('/payment');
    }


public function payment(){
    return view('pages.payment');
}



public function customer_login(Request $request){

 $customer_email=$request->customer_email;
 $password=md5($request->password);
 $result=DB::table('tbl_customer')
 ->where('customer_email',$customer_email)
 ->where('password',$password)
 ->first();
if ($result) {
    Session::put('message','Successfully Enter !!');
    Session::put('customer_id',$result->customer_id);
    return Redirect::to('/checkout');
}else{
  Session::put('message','Email or Password is not correct !!');
    return Redirect::to('/login-check');

}

}

public function customer_logout(){

    Session::flush();
    return Redirect::to('/');
}

public function order_place(Request $request){
     $payment_gateway=$request->payment_method;
 $pdata=array();
 $pdata['payment_method']=$payment_gateway;
 $pdata['payment_status']='pending';
 $paymet_id=DB::table('tbl_payment')
 ->insertGetId($pdata);
                     

   $odata=array();
   $odata['customer_id']=Session::get('customer_id');
   $odata['shipping_id']=Session::get('shipping_id');
   $odata['payment_id']=$paymet_id;
   $odata['order_total'] =Cart::total();
   $odata['order_status']='pending';

   $order_id=DB::table('tbl_order')
   ->insertGetId($odata); 

   $contents=Cart::content();

      $oddata=array();
  foreach ($contents as $v_content) {
     $oddata['order_id']=$order_id;
     $oddata['product_id']=$v_content->id;
     $oddata['product_name']=$v_content->name;
     $oddata['product_price']=$v_content->price;
     $oddata['product_sales_quantity']=$v_content->qty;


  DB::table('tbl_order_details')
   ->insert($oddata);


if ($payment_gateway=='handcash') {
    Cart::destroy();
  return view('pages.handcash');

}
elseif ($payment_gateway=='card') {
    echo "successfully done by dabit card";
}
elseif ($payment_gateway=='paypal') {
   echo "successfully done by paypal";
}
else{
    echo "not selected";
}

}
}

public function manage_order(){

      

    $all_order_info=DB::table('tbl_order')
  
         ->join('tbl_customer','tbl_order.customer_id','=','tbl_customer.customer_id')
         
         ->select('tbl_order.*','tbl_customer.customer_first_name','tbl_customer.customer_last_name')
        ->get();
      

      $manage_order=view('admin.manage_order')
     ->with('all_order_info',$all_order_info);
     return view('admin_layout')
     ->with('admin.manage_order',$manage_order);

  // return view('admin.all_product');

   }

   public function AllConfirmedOrder(){

      

    $all_confirmed_order=DB::table('tbl_order')
  
         ->join('tbl_customer','tbl_order.customer_id','=','tbl_customer.customer_id')
         
         ->select('tbl_order.*','tbl_customer.customer_first_name','tbl_customer.customer_last_name')
         ->where('order_status',1)
        ->get();
      

      $all_confirmed_order=view('admin.all_confirmed_order')
     ->with('all_confirmed_order',$all_confirmed_order);
     return view('admin_layout')
     ->with('admin.all_confirmed_order',$all_confirmed_order);

  

   }

      public function AllPendingOrder(){

      

    $all_pending_order=DB::table('tbl_order')
  
         ->join('tbl_customer','tbl_order.customer_id','=','tbl_customer.customer_id')
         
         ->select('tbl_order.*','tbl_customer.customer_first_name','tbl_customer.customer_last_name')
         ->where('order_status',0)
        ->get();
      

      $all_pending_order=view('admin.all_pending_order')
     ->with('all_pending_order',$all_pending_order);
     return view('admin_layout')
     ->with('admin.all_pending_order',$all_pending_order);

  

   }


   public function view_order($order_id){
  
       $order_by_id=DB::table('tbl_order')
              ->join('tbl_customer','tbl_order.customer_id','=','tbl_customer.customer_id')
              ->join('tbl_order_details','tbl_order.order_id','=','tbl_order_details.order_id')
              ->join('tbl_shipping','tbl_order.shipping_id','=','tbl_shipping.shipping_id')
              ->select('tbl_order.*','tbl_order_details.*','tbl_shipping.*','tbl_customer.*')
              ->where('tbl_order.order_id',$order_id)
              ->get();


       $view_order=view('admin.view_order')
               ->with('order_by_id',$order_by_id);
       return view('admin_layout')
               ->with('admin.view_order',$view_order); 
   }

public function delete_order($order_id){
  $order=DB::table('tbl_order')
    ->where('order_id',$order_id)
    ->delete();

      if ($order) {
         $notification=array(
                'messege'=>'Order deleted successfully !!!',
                'alert-type'=>'success'
                 );
               return Redirect::to('manage-order')->with($notification);
      }else{
        return Redirect()->back();
      }
}



}





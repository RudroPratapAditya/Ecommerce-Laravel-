<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Http\Requests;
use Illuminate\support\Facades\Redirect;
use Session;
Session_start();

class OrderController extends Controller
{
   

   public function inactive_order($order_id)
   {

   	$order=DB::table('tbl_order')
   	->where('order_id',$order_id)->update(['order_status'=>0]);
   	  if ($order) {
         $notification=array(
                'messege'=>'Order is now in Pending !!!',
                'alert-type'=>'error'
                 );
               return Redirect::to('manage-order')->with($notification);
      }else{
        return Redirect()->back();
      }
   }

   public function active_order($order_id)
   {

   $order =	DB::table('tbl_order')
   	->where('order_id',$order_id)->update(['order_status'=>1]);
   	 if ($order) {
         $notification=array(
                'messege'=>'Order Confirmed successfully !!!',
                'alert-type'=>'success'
                 );
               return Redirect::to('manage-order')->with($notification);
      }else{
        return Redirect()->back();
      }
   }
}

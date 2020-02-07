<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
Session_start();

class SupplierController extends Controller
{
   public function AddSupplier(){
    	return view('admin.add_suppliers');
    }


    public function InsertSupplier(Request $request){
    	$data=array();
        $data['suppliers_name']=$request->suppliers_name;
        $data['suppliers_phone']=$request->suppliers_phone;
        $data['suppliers_adderss']=$request->suppliers_adderss;
        $data['suppliers_city']=$request->suppliers_city;
        $data['suppliers_email']=$request->suppliers_email;


                
        $image =$request->file('suppliers_image');

        if ($image) {
            $image_name= str_random(5);
            $ext=strtolower($image->getClientOriginalExtension());
            $image_full_name=$image_name.'.'.$ext;
            $upload_path='public/suppliers/';
            $image_url=$upload_path.$image_full_name;
            $success=$image->move($upload_path,$image_full_name);
            if ($success) {
                $data['suppliers_image']=$image_url;
              $contact=DB::table('suppliers')
                        ->insert($data);


                       
              if ($contact) {
                 Session::put('message','Supplier added successfully !!');
                 return Redirect()->back();
                     
             }else{
               Session::put('message','Something went wrong!!');
                 return Redirect()->back();
             }      
           }
        }
    }

     public function AllSupplier(){
    	$all_supplier=DB::table('suppliers')->get();
    	return view('admin.all_supplier',compact('all_supplier'));
    }

      public function DeleteSupplier($Suppliers_id){
    	$delete=DB::table('suppliers')->where('suppliers_id',$Suppliers_id)->delete();
    	 if ($delete) {
                 Session::put('message','Suppliers Deleted successfully !!');
                 return Redirect()->back();
                     
             }else{
               Session::put('message','Something went wrong!!');
                 return Redirect()->back();
             }      
    }

     public function ViewSupplier($Suppliers_id){
    	$view=DB::table('suppliers')->where('Suppliers_id',$Suppliers_id)->first();

    	return view('admin.view_suppliers',compact('view'));
    }
}

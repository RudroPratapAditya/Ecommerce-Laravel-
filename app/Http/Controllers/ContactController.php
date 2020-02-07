<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
Session_start();
class ContactController extends Controller
{
    public function AddContact(){
    	return view('admin.add_contact');
    }


    public function InsertContact(Request $request){
    	$data=array();
        $data['contact_name']=$request->contact_name;
        $data['contact_phone']=$request->contact_phone;
        $data['contact_address']=$request->contact_address;
        $data['contact_city']=$request->contact_city;
        $data['contact_email']=$request->contact_email;


                
        $image =$request->file('contact_image');

        if ($image) {
            $image_name= str_random(5);
            $ext=strtolower($image->getClientOriginalExtension());
            $image_full_name=$image_name.'.'.$ext;
            $upload_path='public/contact/';
            $image_url=$upload_path.$image_full_name;
            $success=$image->move($upload_path,$image_full_name);
            if ($success) {
                $data['contact_image']=$image_url;
              $contact=DB::table('contacts')
                        ->insert($data);


             if ($contact) {
                 $notification=array(
                 'messege'=>'Contact added successfully !!! ',
                 'alert-type'=>'success'
                  );
                 return Redirect()->route('all-contact')->with($notification);                      
             }else{
              $notification=array(
                 'messege'=>'error ',
                 'alert-type'=>'error'
                  );
                 return Redirect()->back();
             } 
             }      
           }
        }
    

    public function AllContact(){
    	$all_contact=DB::table('contacts')->get();
    	return view('admin.all_contact',compact('all_contact'));
    }

    public function DeleteContact($id){
    	$dlt=DB::table('contacts')->where('id',$id)->delete();
        if ($dlt) {
                 $notification=array(
                 'messege'=>'Contact deleted successfully !!! ',
                 'alert-type'=>'success'
                  );
                 return Redirect()->route('all-contact')->with($notification);                      
             }else{
              $notification=array(
                 'messege'=>'error ',
                 'alert-type'=>'error'
                  );
                 return Redirect()->back();
             } 
    	 
    }

    public function ViewContact($id){
    	$view=DB::table('contacts')->where('id',$id)->first();

    	return view('admin.view_contact',compact('view'));
    }

     public function v_contact(){
        $view=DB::table('contacts')->get();
        return view('pages.v_contact',compact('view'));
    }
}
     




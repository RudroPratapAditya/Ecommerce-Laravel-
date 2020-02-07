<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Http\Requests;
use Illuminate\support\Facades\Redirect;
use Session;
Session_start();

class ManufactureController extends Controller
{
   public function index()
   {
      $this->AdminAuthCheck();
      return view('admin.add_manufacture');

   }


   public function save_manufacture(Request $request)
   {

   	 	$data=array();
   	$data['manufacture_id']=$request->manufacture_id;
   	$data['manufacture_name']=$request->manufacture_name;
   	$data['manufacture_description']=$request->manufacture_description;
   	$data['publication_status']=$request->publication_status;
  
   // echo "<pre>";
    //print_r($data);
    //echo "</pre>";

    $manufacture=DB::table('manufacture_tbl')->insert($data);
    if ($manufacture) {
                 $notification=array(
                 'messege'=>'Manufacture Added Successfully !!! ',
                 'alert-type'=>'success'
                  );
                 return Redirect()->route('admin.all-manufacture')->with($notification);                      
             }else{
              $notification=array(
                 'messege'=>'error ',
                 'alert-type'=>'error'
                  );
                 return Redirect()->back();
             } 

   }



   public function all_manufacture()

   {
     $this->AdminAuthCheck();
   	 $all_manufacture_info=DB::table('manufacture_tbl')->get();
      $manage_manufacture=view('admin.all_manufacture')
     ->with('all_manufacture_info',$all_manufacture_info);
     return view('admin_layout')
     ->with('admin.all_manufacture',$manage_manufacture);

  //return view('admin.all_category');

   }

    public function delete_manufacture($manufacture_id)
   {

   	//echo $category_id;

   	$manufacture=DB::table('manufacture_tbl')
   	->where('manufacture_id',$manufacture_id)
   	->delete();

   	if ($manufacture) {
                 $notification=array(
                 'messege'=>'Manufacture Deleted Successfully !!! ',
                 'alert-type'=>'success'
                  );
                 return Redirect()->route('admin.all-manufacture')->with($notification);                      
             }else{
              $notification=array(
                 'messege'=>'error ',
                 'alert-type'=>'error'
                  );
                 return Redirect()->back();
             } 

   }

   public function inactive_manufacture($manufacture_id)
   {

   $manufacture= DB::table('manufacture_tbl')
    ->where('manufacture_id',$manufacture_id)->update(['publication_status'=>0]);
    if ($manufacture) {
                 $notification=array(
                 'messege'=>'Manufacture Deactivated Successfully !!! ',
                 'alert-type'=>'success'
                  );
                 return Redirect()->route('admin.all-manufacture')->with($notification);                      
             }else{
              $notification=array(
                 'messege'=>'error ',
                 'alert-type'=>'error'
                  );
                 return Redirect()->back();
             } 
   }


   public function active_manufacture($manufacture_id)
   {

   $manufacture = DB::table('manufacture_tbl')
    ->where('manufacture_id',$manufacture_id)->update(['publication_status'=>1]);
    if ($manufacture) {
                 $notification=array(
                 'messege'=>'Manufacture Activated Successfully !!! ',
                 'alert-type'=>'success'
                  );
                 return Redirect()->route('admin.all-manufacture')->with($notification);                      
             }else{
              $notification=array(
                 'messege'=>'error ',
                 'alert-type'=>'error'
                  );
                 return Redirect()->back();
             } 
   }


   public function edit_manufacture($manufacture_id)
   {
    $this->AdminAuthCheck();
   $manufacture_info=  DB::table('manufacture_tbl')
    ->where('manufacture_id',$manufacture_id)
    ->first();

     $manufacture_info=view('admin.edit_manufacture')
     ->with('manufacture_info',$manufacture_info);
     return view('admin_layout')
     ->with('admin.edit_manufacture',$manufacture_info);



    //return view('admin.edit_category');
   }


   public function update_manufacture(Request $request,$manufacture_id)
   {

    $data=array();
    $data['manufacture_name']=$request->manufacture_name;
    $data['manufacture_description']=$request->manufacture_description;

    // value pass hosse kina check korar jonno ei command use hoi
    // print_r($data);

   $manufacture = DB::table('manufacture_tbl') 
    ->where('manufacture_id',$manufacture_id)
    ->update($data);

    if ($manufacture) {
                 $notification=array(
                 'messege'=>'Manufacture Updated Successfully !!! ',
                 'alert-type'=>'success'
                  );
                 return Redirect()->route('admin.all-manufacture')->with($notification);                      
             }else{
              $notification=array(
                 'messege'=>'error ',
                 'alert-type'=>'error'
                  );
                 return Redirect()->back();
             } 

   }

    public function AdminAuthCheck()
   {

      $admin_id=Session::get('admin_id');
      
      if ($admin_id) {
        
        return;
      
      }
     
      else{

        return Redirect::to('/admin')->send();

      }
   }

 }







  


    //return view('admin.edit_category');
   
//mahabub er code
   // public function edit_manufacture($manufacture_id)
   // {
   //  $manufactures = DB::table('manufacture_tbl')->where('manufacture_id',$manufacture_id)->first();
   //  return view('admin.edit_manufacture',compact('manufactures'));
   // }
   


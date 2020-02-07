<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Http\Requests;
use Illuminate\support\Facades\Redirect;
use Session;
Session_start();

class CategoryController extends Controller
{
   public function index(){
    $this->AdminAuthCheck();


   	return view('admin.add_category');
   }

   

   public function all_category()
   {
  
 $this->AdminAuthCheck();

  $all_category_info=DB::table('category_tbl')->get();
      $manage_category=view('admin.all_category')
     ->with('all_category_info',$all_category_info);
     return view('admin_layout')
     ->with('admin.all_category',$manage_category);

  //return view('admin.all_category');

   }

  

   public function save_category(Request $request)
   {

   	$data=array();
   	$data['category_id']=$request->category_id;
   	$data['category_name']=$request->category_name;
   	$data['category_description']=$request->category_description;
   	$data['publication_status']=$request->publication_status;
  
   // echo "<pre>";
    //print_r($data);
    //echo "</pre>";

   $cat = DB::table('category_tbl')->insert($data);
    if ($cat) {
                 $notification=array(
                 'messege'=>'Category Inserted Successfully !!! ',
                 'alert-type'=>'success'
                  );
                 return Redirect()->route('admin.all-category')->with($notification);                      
             }else{
              $notification=array(
                 'messege'=>'error ',
                 'alert-type'=>'success'
                  );
                 return Redirect()->back();
             } 
   


   }

   public function inactive_category($category_id)
   {

   	$cat=DB::table('category_tbl')
   	->where('category_id',$category_id)->update(['publication_status'=>0]);
    if ($cat) {
                 $notification=array(
                 'messege'=>'Category Deactivated Successfully !!! ',
                 'alert-type'=>'success'
                  );
                  return Redirect()->route('admin.all-category')->with($notification);                      
             }else{
              $notification=array(
                 'messege'=>'error ',
                 'alert-type'=>'success'
                  );
                 return Redirect()->back();
             } 
   }

   public function active_category($category_id)
   {

   	$cat=DB::table('category_tbl')
   	->where('category_id',$category_id)->update(['publication_status'=>1]);
   	 if ($cat) {
                 $notification=array(
                 'messege'=>'Category Activated Successfully !!! ',
                 'alert-type'=>'success'
                  );
                 return Redirect()->route('admin.all-category')->with($notification);                      
             }else{
              $notification=array(
                 'messege'=>'error ',
                 'alert-type'=>'success'
                  );
                 return Redirect()->back();
             } 
   }

   public function edit_category($category_id)
   {

  $this->AdminAuthCheck();
   $category_info=	DB::table('category_tbl')
   	->where('category_id',$category_id)
   	->first();

   	 $category_info=view('admin.edit_category')
     ->with('category_info',$category_info);
     return view('admin_layout')
     ->with('admin.edit_category',$category_info);



   	//return view('admin.edit_category');
   }

   public function update_category(Request $request,$category_id)
   {

   	$data=array();
   	$data['category_name']=$request->category_name;
   	$data['category_description']=$request->category_description;

   	// value pass hosse kina check korar jonno ei command use hoi
   	// print_r($data);

   	$cat=DB::table('category_tbl') 
   	->where('category_id',$category_id)
   	->update($data);

   	if ($cat) {
                 $notification=array(
                 'messege'=>'Category Updated Successfully !!! ',
                 'alert-type'=>'success'
                  );
                 return Redirect()->route('admin.all-category')->with($notification);                      
             }else{
              $notification=array(
                 'messege'=>'error ',
                 'alert-type'=>'success'
                  );
                 return Redirect()->back();
             } 

   }

   public function delete_category($category_id)
   {

   	//echo $category_id;

   $del_cat =	DB::table('category_tbl')
   	->where('category_id',$category_id)
   	->delete();

   if ($del_cat) {
         $notification=array(
                'messege'=>'Category Deleted Successfully !!!',
                'alert-type'=>'error'
                 );
                return Redirect()->route('admin.all-category')->with($notification);
      }else{
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

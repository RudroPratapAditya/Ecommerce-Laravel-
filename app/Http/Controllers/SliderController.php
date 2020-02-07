<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Http\Requests;
use Illuminate\support\Facades\Redirect;
use Session;
Session_start();

class SliderController extends Controller
{
   public function index()
   {
   	return view('admin.add_slider');
   }

   public function save_slider(Request $request)
   {


   	$data=array();
   	$data['publication_status']=$request->publication_status;
   	$image=$request->file('slider_image');


      // dd($request->hasFile('product_image'));
      
   	if($image) {
   		$image_name=str_random(20);
   		$ext=strtolower($image->getClientOriginalExtension());
   		$image_full_name=$image_name.'.'.$ext;
   		$upload_path='slider/';
   		$image_url=$upload_path.$image_full_name;
   		$success=$image->move($upload_path,$image_full_name);
   		if($success){
   			$data['slider_image']=$image_url;

   			$slider=DB::table('tbl_slider')->insert($data);
   			if ($slider) {
         $notification=array(
                'messege'=>'Slider added Successfully !!!',
                'alert-type'=>'success'
                 );
               return Redirect()->route('admin.all-slider')->with($notification);
      }else{
        return Redirect()->back();
      }

   			// echo "<pre>";
   			// print_r($data);
   			// echo "</pre>";
   			// exit();
   		}
   	}

   	$data['slider_image']='';
   		$slide =	DB::table('tbl_slider')->insert($data);
   		if ($slide) {
         $notification=array(
                'messege'=>'Slider added successfully without image !!!',
                'alert-type'=>'success'
                 );
               return Redirect()->route('admin.all-slider')->with($notification);
      }else{
        return Redirect()->back();
      }
   }


    public function all_slider()
   {
  
 // $this->AdminAuthCheck();

  $all_slider_info=DB::table('tbl_slider')->get();
      $manage_slider=view('admin.all_slider')
     ->with('all_slider_info',$all_slider_info);
     return view('admin_layout')
     ->with('admin.all_slider',$manage_slider);

  // return view('admin.all_slider');

   }

    public function inactive_slider($slider_id)
   {

   $slide =	DB::table('tbl_slider')
   	->where('slider_id',$slider_id)->update(['publication_status'=>0]);
    if ($slide) {
         $notification=array(
                'messege'=>'Slider deactivated successfully !!!',
                'alert-type'=>'success'
                 );
               return Redirect()->route('admin.all-slider')->with($notification);
      }else{
        return Redirect()->back();
      }
   }


   public function active_slider($slider_id)
   {

    $slide=DB::table('tbl_slider')
    ->where('slider_id',$slider_id)->update(['publication_status'=>1]);
    if ($slide) {
         $notification=array(
                'messege'=>'Slider activated successfully !!!',
                'alert-type'=>'success'
                 );
               return Redirect()->route('admin.all-slider')->with($notification);
      }else{
        return Redirect()->back();
      }
   }

   public function delete_slider($slider_id)
   {

   	//echo $category_id;

   $slide =	DB::table('tbl_slider')
   	->where('slider_id',$slider_id)
   	->delete();

   	if ($slide) {
         $notification=array(
                'messege'=>'Slider deleted successfully !!!',
                'alert-type'=>'success'
                 );
               return Redirect()->route('admin.all-slider')->with($notification);
      }else{
        return Redirect()->back();
      }

   }

    public function edit_slider($slider_id)
   {
    // $this->AdminAuthCheck();
   $slider_info=  DB::table('tbl_slider')
    ->where('slider_id',$slider_id)
    ->first();

     $slider_info=view('admin.edit_slider')
     ->with('slider_info',$slider_info);
     return view('admin_layout')
     ->with('admin.edit_slider',$slider_info);

   
}

	
	
}

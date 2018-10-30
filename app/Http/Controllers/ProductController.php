<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Http\Requests;
use Illuminate\support\Facades\Redirect;
use Session;
Session_start();
class ProductController extends Controller
{
   public function add_product(){

   return view('admin.add_product');
   }


   public function save_product(Request $request)
   {
   	$data=array();
    
   	$data['product_name']=$request->product_name;
   	$data['category_id']=$request->category_id;
   	$data['manufacture_id']=$request->manufacture_id;
    $data['product_short_description']=$request->product_short_description;
   	$data['product_long_description']=$request->product_long_description;
    $data['product_size']=$request->product_size;
   	$data['product_price']=$request->product_price;
   	$data['product_color']=$request->product_color;
   	$data['publication_status']=$request->publication_status;
   	$image=$request->file('product_image');


     
      
   	if($image) {
   		$image_name=str_random(20);
   		$ext=strtolower($image->getClientOriginalExtension());
   		$image_full_name=$image_name.'.'.$ext;
   		$upload_path='image/';
   		$image_url=$upload_path.$image_full_name;
   		$success=$image->move($upload_path,$image_full_name);
   		if($success){
   			$data['product_image']=$image_url;

   			DB::table('tbl_products')->insert($data);
   			Session::put('message','Product added succesfully!!!');
   			return Redirect::to('/add-product');

  
   		}
   	}

   	$data['product_image']='';
   			DB::table('tbl_products')->insert($data);
   			Session::put('message','Product added succesfully without image!!!');
   			return Redirect::to('/add-product');
   }


   public function all_product()
   {

  // $this->AdminAuthCheck();

  $all_product_info=DB::table('tbl_products')
  
         ->join('category_tbl','tbl_products.category_id','=','category_tbl.category_id')
         ->join('manufacture_tbl','tbl_products.manufacture_id','=','manufacture_tbl.manufacture_id')
         ->select('tbl_products.*','category_tbl.category_name','manufacture_tbl.manufacture_name')
        ->get();
     
      

      $manage_product=view('admin.all_product')
     ->with('all_product_info',$all_product_info);
     return view('admin_layout')
     ->with('admin.all_product',$manage_product);

 
   }






 public function inactive_product($product_id)
   {

    

      DB::table('tbl_products')
      ->where('product_id',$product_id)->update(['publication_status'=>0]);
      Session::put('message','Product Inactivated Successfully !!');
      return Redirect::to('/all-product');
   }



   public function active_product($product_id)
   {

      DB::table('tbl_products')
      ->where('product_id',$product_id)->update(['publication_status'=>1]);
      Session::put('message','Product Activated Successfully !!');
      return Redirect::to('/all-product');
   }



 




   public function delete_product($product_id)
   {

      DB::table('tbl_products')->where('product_id',$product_id)
      ->delete();
      Session::put('message','Product Deleted Successfully!!!');
      return Redirect::to('/all-product');
   }

     public function edit_product($product_id){
        $product_description_view = DB::table('tbl_products')
            ->select('*')
            ->where('product_id',$product_id)
            ->first();
        $manage_description_product=view('admin.edit_product')
            ->with('specific_edit_product',$product_description_view);
        return view('admin_layout')
            ->with('edit_product',$manage_description_product);
    }


    public function update_product(Request $request, $product_id){
        // $this->validate($request,[
        //     'product_name' => 'required',
        //     'category_id' => 'required',
        //     'manufacture_id' => 'required',
        //     'product_short_description' => 'required',
        //     'product_long_description' => 'required',
        //     'product_price' => 'required',
        //     'product_size' => 'required',
        //     'product_color' => 'required'
        // ]);

        $data = array();
        $data['product_name'] = $request->product_name;
        $data['category_id'] = $request->category_id;
        $data['manufacture_id'] = $request->brand_id;
       
       
        $data['product_price'] = $request->product_price;
        
       

        //image upload
        $image = $request->file('product_image');
        if ($image) {
            $image_name= $product_id;
            $ext=strtolower($image->getClientOriginalExtension());
            $image_full_name=$image_name.'.'.$ext;
            $upload_path='image/';
            $image_url=$upload_path.$image_full_name;
            $success=$image->move($upload_path,$image_full_name);
            if ($success) {
                $data['product_image']=$image_url;
                DB::table('tbl_products')
                    ->where('product_id',$product_id)
                    ->update($data);
                Session::put('message', 'Product updated successfully!!');
                return Redirect::to('/all-product');
            }
        }
        

    }


 
}













   

 


 
   


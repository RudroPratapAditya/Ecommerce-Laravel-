<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Http\Requests;
use Illuminate\support\Facades\Redirect;
use Session;
Session_start();

class HomeController extends Controller
{
   
public function home(){
  return Redirect::to('/');
}


    public function index()
    {
    	// $this->AdminAuthCheck();

  $all_published_product=DB::table('tbl_products')
  
         ->join('category_tbl','tbl_products.category_id','=','category_tbl.category_id')
         ->join('manufacture_tbl','tbl_products.manufacture_id','=','manufacture_tbl.manufacture_id')
         ->select('tbl_products.*','category_tbl.category_name','manufacture_tbl.manufacture_name')
         ->where('tbl_products.publication_status',1)
         ->limit(9)
        ->get();
      // echo "<pre>";
      // print_r($all_product_info);
      // echo "</pre>";
      // exit();
      

      $manage_published_product=view('pages.home_content')
     ->with('all_published_product',$all_published_product);
     return view('layout')
     ->with('pages.home_content',$manage_published_product);

  // return view('admin.all_product');

   }

   public function show_products_by_category($category_id)
   {


// echo "$category_id";
    $product_by_category=DB::table('tbl_products')
  
         ->join('category_tbl','tbl_products.category_id','=','category_tbl.category_id')
          ->join('manufacture_tbl','tbl_products.manufacture_id','=','manufacture_tbl.manufacture_id')
         ->select('tbl_products.*','category_tbl.category_name','manufacture_tbl.manufacture_name')
         ->where('category_tbl.category_id',$category_id)
         ->where('tbl_products.publication_status',1)
         ->limit(18)
        ->get();
      

      $manage_product_by_category=view('pages.show_product_by_category')
     ->with('product_by_category',$product_by_category);
     return view('layout')
     ->with('pages.show_product_by_category',$manage_product_by_category);

   }

    public function show_product_by_manufacture($manufacture_id)
    {
      // $this->AdminAuthCheck();

  $product_by_manufacture=DB::table('tbl_products')
  
         ->join('category_tbl','tbl_products.category_id','=','category_tbl.category_id')
         ->join('manufacture_tbl','tbl_products.manufacture_id','=','manufacture_tbl.manufacture_id')
         ->select('tbl_products.*','category_tbl.category_name','manufacture_tbl.manufacture_name')
         ->where('manufacture_tbl.manufacture_id',$manufacture_id)
         ->where('tbl_products.publication_status',1)
         ->limit(18)
        ->get();
      // echo "<pre>";
      // print_r($all_product_info);
      // echo "</pre>";
      // exit();
      

      $manage_product_by_manufacture=view('pages.show_product_by_manufacture')
     ->with('product_by_manufacture',$product_by_manufacture);
     return view('layout')
     ->with('pages.show_product_by_manufacture',$manage_product_by_manufacture);

  // return view('admin.all_product');

   }

  public function product_details($product_id)
  {
        $product_by_details=DB::table('tbl_products')
         ->join('category_tbl','tbl_products.category_id','=','category_tbl.category_id')
         ->join('manufacture_tbl','tbl_products.manufacture_id','=','manufacture_tbl.manufacture_id')
         ->select('tbl_products.*','category_tbl.category_name','manufacture_tbl.manufacture_name')
         ->where('tbl_products.product_id',$product_id)
         ->where('tbl_products.publication_status',1)
         ->first();

         $manage_product_by_details=view('pages.show_product_details')
     ->with('product_by_details',$product_by_details);
     return view('layout')
     ->with('pages.show_product_details',$manage_product_by_details);
  }
 
}




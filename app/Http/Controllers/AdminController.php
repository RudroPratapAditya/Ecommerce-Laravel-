<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Http\Requests;
use Illuminate\support\Facades\Redirect;
use Session;
Session_start();
class AdminController extends Controller
{
   public function index()
   {
      
      return view('admin.admin_login');

   }

   

   public function view_dashboard(Request $request)
   {
        
        $admin_email=$request->admin_email;
        $admin_password=md5($request->admin_password);
        $result=DB::table('admin_tbl')
        	->where('admin_email',$admin_email)
        	->where('admin_password',$admin_password)
        	->first();
        	//echo "<pre>";
        	//print_r($result);
        	//exit();
        	if($result){

        		Session::put('admin_name',$result->admin_name);
        		Session::put('admin_id',$result->admin_id);
        		return Redirect::to('/dashboard');
        	}else{
        		Session::put('message','Email or Password are Invalid');
        		return Redirect::to('/admin');

        	}
   }


}
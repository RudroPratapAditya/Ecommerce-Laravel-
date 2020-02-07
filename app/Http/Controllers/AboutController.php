<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;


class AboutController extends Controller
{
    public function AboutContact(){
$contact=DB::table('contacts')->get();





    	return view('all_contact',compact('contact'));
    }

     public function SingleContact($id){
    	$single_contact=DB::table('contacts')->where('id',$id)->first();

    	return view('single_contact',compact('single_contact'));
    }
}

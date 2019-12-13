<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

class HomeController extends Controller
{
     public function getIndex(){
        
        $sale_product = DB::table('tbl_product')->where('product_status',0)->where('product_promotion_price','<>',0)->orderby('product_id','desc')->limit(8)->get(); 
        $all_product = DB::table('tbl_product')->where('product_status',0)->orderby('product_id','desc')->get(); 
        return view('pages.home')->with('all_product',$all_product)->with('sale_product',$sale_product);
    }


    public function getProductType(){
        $cate_product = DB::table('tbl_category_product')->where('category_status',0)->orderby('category_id','asc')->get(); 
        $brand_product = DB::table('tbl_brand')->orderby('brand_id','asc')->get(); 
        $sale_product = DB::table('tbl_product')->where('product_status',0)->where('product_promotion_price','<>',0)->orderby('product_id','desc')->limit(8)->get(); 
        $all_product = DB::table('tbl_product')->where('product_status',0)->orderby('product_id','desc')->get(); 
    	return view('pages.product_type')->with('all_product',$all_product)->with('sale_product',$sale_product)->with('category',$cate_product)->with('brand',$brand_product);
    }

    public function getContact(){
        return view('pages.contact');
    }


   
    public function getAboutUs(){
    	return view('pages.about_us');
    }
    public function getLogin(){
    	return view('pages.login');
    }

    public function getRegister(){
    	return view('pages.register');
    }
    public function getCheckOut(){
        return view('pages.checkout');
    }
}

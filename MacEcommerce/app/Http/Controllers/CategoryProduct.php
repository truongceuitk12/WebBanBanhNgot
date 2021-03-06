<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Aler;
session_start();

class CategoryProduct extends Controller
{
	public function AuthLogin(){
		$admin_id = Session::get('admin_id');
		if($admin_id){
			return Redirect::to('dashboard');
		}else{
			return Redirect::to('login')->send();
		}
	}
	public function add_category_product(){
		$this->AuthLogin();
		return view('admin.add_category_product');
	}
	
	public function all_category_product(){
		$this->AuthLogin();
		$all_category_product = DB::table('tbl_category_product')->get();
		$manager_category_product  = view('admin.all_category_product')->with('all_category_product',$all_category_product);
		return view('admin_layout')->with('admin.all_category_product', $manager_category_product);


	}
	public function save_category_product(Request $request){
	   $this->AuthLogin();
		$cate_name = $request->cate_name;
       $cate_desc = $request->cate_desc;
       $cate_stt = $request->cate_stt;
       $add_cat = DB::table('tbl_category_product')->insert([
        'category_name' => $cate_name,
        'category_desc' => $cate_desc,
        'category_status' => $cate_stt,
      
      ]);
      if($add_cat){
        echo "done";
      }else{
        echo "error";
      }
	}

	public function unactive_category_product($category_product_id){
		$this->AuthLogin();
		DB::table('tbl_category_product')->where('category_id',$category_product_id)->update(['category_status'=>1]);
		//Session::put('message','Không kích hoạt danh mục sản phẩm thành công');
		return Redirect::to('all-category-product');

	}

	public function active_category_product($category_product_id){
	   $this->AuthLogin();
		DB::table('tbl_category_product')->where('category_id',$category_product_id)->update(['category_status'=>0]);
		Session::put('message','Kích hoạt danh mục sản phẩm thành công');
		return Redirect::to('all-category-product');
	}

	public function edit_category_product($category_product_id){
		$this->AuthLogin();
		$edit_category_product = DB::table('tbl_category_product')->where('category_id',$category_product_id)->get();

		$manager_category_product  = view('admin.edit_category_product')->with('edit_category_product',$edit_category_product);

		return view('admin_layout')->with('admin.edit_category_product', $manager_category_product);
	}

	public function update_category_product(Request $request,$category_product_id){
	   $this->AuthLogin();
		$data = array();
		$data['category_name'] = $request->category_product_name;
		$data['category_desc'] = $request->category_product_desc;
		DB::table('tbl_category_product')->where('category_id',$category_product_id)->update($data);
		Session::put('message','Cập nhật danh mục sản phẩm thành công');    
		return Redirect::to('all-category-product');
	}

	 public function delete_category_product(Request $req){
		$this->AuthLogin();
		DB::table('tbl_category_product')->where('category_id',$req->idCate)->delete();
	}
	// end admin
	public function showCategoryProduct ($category_id){
		$cate_product = DB::table('tbl_category_product')->where('category_status',0)->orderby('category_id','asc')->get(); 
        $brand_product = DB::table('tbl_brand')->orderby('brand_id','asc')->get(); 
        $category_by_id = DB::table('tbl_product')->where('category_id',$category_id)->get();
       /* dd($category_id);
        exit(0);*/
        $all_product = DB::table('tbl_product')->where('product_status',0)->orderby('product_id','desc')->limit(8)->get(); 
        $category_name = DB::table('tbl_category_product')->where('tbl_category_product.category_id',$category_id)->limit(1)->get();
            
       
		return view('pages.show_category')->with('category',$cate_product)->with('brand',$brand_product)->with('category_id',$category_by_id)->with('all_product',$all_product)->with('cate_name',$category_name);
	}
	public function update_cate(Request $request){
		$this->AuthLogin();
	   $cate_name = $request->cate_name;
       $cate_desc = $request->cate_desc;
       $cate_id = $request->cate_id;
       $add_cat = DB::table('tbl_category_product')->where('category_id',$cate_id)->update([
        'category_name' => $cate_name,
        'category_desc' => $cate_desc,
        'category_status' => 0,
      
      ]);
      if($add_cat){
        echo "done";
      }else{
        echo "error";
      }

	}
	
	
}

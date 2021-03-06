<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Cart;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

class CheckoutController extends Controller
{
     public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    public function view_order($orderId){
        $this->AuthLogin();
        $order_by_id = DB::table('tbl_order')
        ->join('users','tbl_order.id','=','users.id')
        ->join('tbl_shipping','tbl_order.shipping_id','=','tbl_shipping.shipping_id')
        ->join('tbl_order_details','tbl_order.order_id','=','tbl_order_details.order_id')
        ->select('tbl_order.*','users.*','tbl_shipping.*','tbl_order_details.*')->first();

        $manager_order_by_id  = view('admin.view_order')->with('order_by_id',$order_by_id);
        return view('admin_layout')->with('admin.view_order', $manager_order_by_id);
        
    }
    public function login_checkout(){
    	return view('pages.login');
    }
    public function add_customer(Request $request){

    	$data = array();
    	$data['name'] = $request->customer_name;
    	$data['phone'] = $request->customer_phone;
    	$data['email'] = $request->customer_email;
    	$data['password'] = md5($request->customer_pass);

    	$customer_id = DB::table('users')->insertGetId($data);

    	Session::put('customer_id',$customer_id);
    	Session::put('customer_name',$request->customer_name);
    	return Redirect::to('/login-checkout');


    }
    public function checkout(){
    	return view('pages.checkout');
    }
    public function save_checkout_customer(Request $request){
    	$data = array();
    	$data['shipping_name'] = $request->shipping_name;
    	$data['shipping_phone'] = $request->shipping_phone;
    	$data['shipping_email'] = $request->shipping_email;
    	$data['shipping_notes'] = $request->shipping_notes;
    	$data['shipping_address'] = $request->shipping_address;

    	$shipping_id = DB::table('tbl_shipping')->insertGetId($data);

    	Session::put('shipping_id',$shipping_id);
    	
    	return Redirect::to('/payment');
    }
    public function payment(){
        return view('pages.payment');

    }
    
    public function order_place(Request $request){
        //insert payment_method
     
        $data = array();
        $data['payment_method'] = $request->payment_option;
        $data['payment_status'] = 'Đang chờ xử lý';
        $payment_id = DB::table('tbl_payment')->insertGetId($data);

        //insert order
        $order_data = array();
        $order_data['id'] = Session::get('customer_id');
        $order_data['shipping_id'] = Session::get('shipping_id');
        $order_data['payment_id'] = $payment_id;
        $order_data['order_total'] = Cart::total();
        $order_data['order_status'] = 'Đang chờ xử lý';
        $order_data['create_at'] = '23/12/2019';

        $order_id = DB::table('tbl_order')->insertGetId($order_data);

        //insert order_details
        $content = Cart::content();
        foreach($content as $v_content){
            $order_d_data['order_id'] = $order_id;
            $order_d_data['product_id'] = $v_content->id;
            $order_d_data['product_name'] = $v_content->name;
            $order_d_data['product_price'] = $v_content->price;
            $order_d_data['product_sales_quantity'] = $v_content->qty;
            DB::table('tbl_order_details')->insert($order_d_data);
        }
        if($data['payment_method']==1){

            echo 'Thanh toán thẻ ATM';

        }elseif($data['payment_method']==2){
            Cart::destroy();

           
            return view('pages.handcash');

        }else{
            echo 'Thẻ ghi nợ';

        }

        
        
    }
    public function logout_checkout(){
    	Session::flush();
    	return Redirect::to('/login-checkout');
    }
    public function login_customer(Request $request){
    	$email = $request->email_account;
    	$password = md5($request->password_account);
    	$result = DB::table('users')->where('email',$email)->where('password',$password)->first();
    	
    	
    	 if($result){
            Session::put('customer_id',$result->id);
            Session::put('customer_name',$result->name);
            return Redirect::to('/login-checkout');
        }else{
            Session::put('message','Mật khẩu hoặc tài khoản bị sai');
            return Redirect::to('/login-checkout');
        }
    	
   
    	

    }
    public function manage_order(){
        
        $this->AuthLogin();
        $all_order = DB::table('tbl_order')
        ->join('users','users.id','=','tbl_order.id')
        ->select('tbl_order.*','users.name')
        ->orderby('tbl_order.order_id','desc')->get();
        $manager_order  = view('admin.manage_order')->with('all_order',$all_order);
        return view('admin_layout')->with('admin.manage_order', $manager_order);
    }
     public function manage_user_order(){
        
        $this->AuthLogin();
        $all_order = DB::table('tbl_order')
        ->join('users','users.id','=','tbl_order.id')
        ->select('tbl_order.*','users.name')
        ->orderby('tbl_order.order_id','desc')->get();
        $manager_order  = view('pages.history')->with('all_order',$all_order);
        return view('layout')->with('pages.history', $manager_order);
    }
    public function pass_order(){
        
        $this->AuthLogin();
        $all_order = DB::table('tbl_order')
        ->join('users','users.id','=','tbl_order.id')
        ->select('tbl_order.*','users.name')
        ->orderby('tbl_order.order_id','desc')->get();
        $manager_order  = view('pages.da_order')->with('all_order',$all_order);
        return view('admin_layout')->with('pages.da_order', $manager_order);
    }
    public function delete_order($order_id){
        $this->AuthLogin();
        DB::table('tbl_order')->where('order_id',$order_id)->delete();
        Session::put('message','Xóa thương hiệu sản phẩm thành công');
       return redirect()->back()->with(['thanhcong' => 'Đã cập nhật đơn hàng']);
    }
    public function update_order($id){
        $status = 'Đã giao hàng';
        DB::table('tbl_order')->where('order_id',$id)->update(['order_status' => $status]);;
       
        return Redirect::to('/manage-order');
        
    }
}

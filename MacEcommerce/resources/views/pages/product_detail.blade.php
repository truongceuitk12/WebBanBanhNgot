@extends('layout')
@section('content')
<div class="inner-header">
		<div class="container">
			<div class="pull-left">
				<h6 class="inner-title">Chi tiết sản phẩm</h6>
			</div>
			<div class="pull-right">
				<div class="beta-breadcrumb font-large">
					<a href="index.html">Home</a> / <span>Chi tiết</span>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
	<?php
            $customer_id = Session::get('customer_id');
              
            ?>
	<div class="container">
		<div id="content">
			<div class="row">
				<div class="col-sm-9">
					@foreach($product_details as $dt => $value)
					<div class="row">
						<form action="{{URL::to('/save-cart')}}" method="post">
				{{csrf_field()}}
						<div class="col-sm-4">
							<img src="{{$value->product_image}}" alt="">
						</div>
						<div class="col-sm-8">
							<div class="single-item-body">
								<p class="single-item-title" style="color: blue">{{$value->product_name}}</p>
								<div class="space20">&nbsp;</div>
								<p class="single-item-price " >
									@if($value->product_promotion_price==0)
									<b style="font-size: 15px;">Giá gốc</b>
									<span style="color: #FF6600">{{number_format($value->product_unit_price)}} Đ</span>
									@else
									<b style="font-size: 15px;">Giá gốc :</b>
									<span class="flash-del" >{{number_format($value->product_unit_price)}} Đ</span>
									<br>
									<br>
									<b style="font-size: 15px;">Giá khuyến mãi :</b>
									<span  style="color: #FF6600">{{number_format($value->product_promotion_price)}} Đ</span>
									@endif
								</p>
							</div>

							<div class="clearfix"></div>
							<div class="space20">&nbsp;</div>

							<div class="single-item-desc">
								<p>{{$value->product_desc}}</p>
								<div class="space30">&nbsp;</div>
								<p ><b>Trạng thái : </b>Còn hàng</p>
								<div class="space10">&nbsp;</div>
								<input type="hidden" name="product_id_hidden" value="{{$value->product_id}}"/>
								<div class="space10">&nbsp;</div>
								<p ><b>Thương hiệu : </b>{{$value->brand_name}}</p>
								<div class="space10">&nbsp;</div>
								<p ><b>Loại sản phẩm : </b>{{$value->category_name}}</p>
							</div>
							<div class="space20">&nbsp;</div>

							<p style="color: blue">Tùy chọn :</p>
								<div class="space20">&nbsp;</div>
							<div class="form-group">
									<label>Số lượng</label>
                                      <select name="product_qty" class="form-control input-sm m-bot15">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                             <option value="3">3</option>
                                            <option value="4">4</option>
                                             <option value="5">5</option>
                                            <option value="6">6</option>
                                            
                                    </select>
							</div>
							
							<div class="single-item-options">
								
								<button class="beta-btn primary" type="submit"><p>Thêm vào giỏ hàng</p></i></button>
								<div class="clearfix"></div>
							</div>
						</div>
					</form>
					</div>
					@endforeach
					<div class="space40">&nbsp;</div>
					<div class="woocommerce-tabs">
						<ul class="tabs">
							<li><a href="#tab-description">Mô tả</a></li>
							<li><a href="#tab-reviews">Đánh giá</a></li>
						</ul>
						@foreach($product_details as $dt2 => $value)
						<div class="panel" id="tab-description">
							<p>{{$value->product_content}}</p>
						</div>
						<div class="panel" id="tab-reviews">
							@foreach($all_comment as $cm => $comment)
								<div class="card card-inner">
            	    <div class="card-body">
            	        <div class="row">
                    	    
                    	    <div class="col-md-10">
                    	       <p style=" font-size: 15px;"><b style="color: blue;">{{$comment-> name}} :</b>
                    	       	{{$comment->comment_desc}}</p>
                    	       <div class="space10">&nbsp;</div>
                    	   
                    	        
                    	        <p>
                    	            <a class="float-right btn btn-outline-primary ml-2">  <i class="fa fa-reply"></i> Reply</a>
                    	            <a class="float-right btn text-white btn-danger"> <i class="fa fa-heart"></i> Like</a>
                    	       </p>
                    	    </div>
            	        </div>
            	    </div>
	            </div>
							<!-- <p ><b>{{$comment-> name}} :&nbsp;&nbsp; </b>{{$comment->comment_desc}}</p> -->
							<div class="space30">&nbsp;</div>
							@endforeach
							<form action="{{URL::to('/save-comment')}}" method="POST">
								{{csrf_field()}}
								<input type="hidden" name="id" value="{{$customer_id}}">
								<input type="hidden" name="product_id" value="{{$value->product_id}}">
								<textarea rows="" name="desc"></textarea>
								<button class="beta-btn primary" type="submit"><p>Comment</p></i></button>
							</form>
						</div>
						@endforeach
					</div>
					<div class="space50">&nbsp;</div>
					<div class="beta-products-list">
						<h4>Related Products</h4>

						<div class="row">
							@foreach($related as $rela => $product)
							<div class="col-sm-4">
								<div class="single-item">
									@if($product->product_promotion_price != 0)
											<div class="ribbon-wrapper"><div class="ribbon sale">Sale</div></div>
									@endif
									<div class="single-item-header">
										<a href="{{URL::to('/product-detail/'.$product->product_id)}}"><img src="{{$product->product_image}}" alt=""></a>
									</div>
									<div class="single-item-body">
										<p class="single-item-title">{{$product->product_name}}</p>
										<div class="space10">&nbsp;</div>
										<p class="single-item-price" style="font-size: 20px;">
												@if($product->product_promotion_price==0)
												<span class="flash-sale">{{number_format($product->product_unit_price)}} Đ</span>

												@else
												<span class="flash-del">{{number_format($product->product_unit_price)}} Đ</span>
												
												<br>
												<span class="flash-sale">{{number_format($product->product_promotion_price)}} Đ</span>
												@endif

											</p>
											<div class="space10">&nbsp;</div>
									</div>
									<div class="single-item-caption">
										<a class="add-to-cart pull-left" href="product.html"><i class="fa fa-shopping-cart"></i></a>
										<a class="beta-btn primary" href="{{URL::to('/product-detail/'.$product->product_id)}}">Chi tiết <i class="fa fa-chevron-right"></i></a>
										<div class="clearfix"></div>
									</div>
								</div>
							</div>
							@endforeach
						</div>
					</div> <!-- .beta-products-list -->
				</div>
				<div class="col-sm-3 aside">
					<div class="widget">
						<h3 class="widget-title">Best Sellers</h3>
						<div class="widget-body">
							<div class="beta-sales beta-lists">
								
								@foreach($sale_product as $sale => $product)
								
								<div class="media beta-sales-item">

									<a class="pull-left" href="{{URL::to('/product-detail/'.$product->product_id)}}	"><img src="{{$product->product_image}}" alt=""></a>
									<div class="media-body">
										{{$product->product_name}}
										<span class="beta-sales-price">{{number_format($product->product_promotion_price)}} Đ</span>
									</div>
								</div>
								
								@endforeach
							
							</div>
						</div>
					</div> <!-- best sellers widget -->
					<div class="widget">
						<h3 class="widget-title">New Products</h3>
						<div class="widget-body">
							<div class="beta-sales beta-lists">
								@foreach($all_product as $sale => $product)
								<div class="media beta-sales-item">

									<a class="pull-left" href="{{URL::to('/product-detail/'.$product->product_id)}}	"><img src="{{$product->product_image}}" alt=""></a>
									<div class="media-body">
										{{$product->product_name}}
										<span class="beta-sales-price">{{number_format($product->product_unit_price)}} Đ</span>
									</div>
								</div>
								
								@endforeach
								
							</div>
						</div>
					</div> <!-- best sellers widget -->
				</div>
			</div>
		</div> <!-- #content -->
	</div> <!-- .container -->
@endsection

@section('script')
	<script>
		$(document).ready(function(){
		 
		  $("#btn").click(function(){
		    var cat_name = $("#brand_product_name").val();
		    var cat_desc = $("#brand_product_desc").val();
		    var cat_stt = $("#brand_product_status").val();
		    if(cat_name == '' || cat_desc == '' || cat_stt==''){
		    	swal("Lỗi!", "Vui lòng điền đầy đủ thông tin!", "error", {
  					button: "Yes!",
				});
		    }
		    else{
		    	$.ajax({
		      url: "{{route('postbrandAjax')}}",
		      method: "GET",
		      data:{cat_name:cat_name, cat_desc:cat_desc, cat_stt:cat_stt},
		      
		      success:function(data){
		      	swal("Hoàn tất!", "Thêm thành công thương hiệu!", "success", {
  					button: "Yes!",
				});
		      }
		    });
		    }

		    
		  });

		 var auto_refresh = setInterval(
		    function(){
		      $('#category').load('add.brand').fadeIn("slow");
		    },100);
		});
	</script>
	
@endsection 

@extends('master')
@section('content')
<div class="inner-header">
		<div class="container">
			<div class="pull-left">
				<h6 class="inner-title">Đăng nhập</h6>
			</div>
			<div class="pull-right">
				<div class="beta-breadcrumb">
					<a href="index.html">Home</a> / <span>Đăng nhập</span>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
	
	<div class="container">
		<div id="content">
			
			<form action="#" method="post" class="beta-form-checkout">
				<div class="row">
					<div class="col-sm-3"></div>
					<div class="col-sm-6">
						<h4 style="color: blue;" >Đăng nhập</h4>
						<div class="space60">&nbsp;</div>

						
						<div class="form-block">
							<label for="email" style="color: red;">Email*</label>
							<input type="email" id="email" required>
						</div>
						<div class="form-block">
							<label for="phone" style="color: red;">Mật khẩu*</label>
							<input type="text" id="phone" required>
						</div>
						<div class="form-block">
							<button type="submit" class="btn btn-primary">Đăng nhập</button>
						</div>
					</div>
					<div class="col-sm-3"></div>
				</div>
			</form>
		</div> <!-- #content -->
	</div> <!-- .container -->
@endsection
<!DOCTYPE html>
<html>
	<head>
		<title>Login</title>
		<link href="{{ ('/disp-biro-eko/public/landing/bootstrap400/css/bootstrap.min.css') }}" rel="stylesheet">
		<link href="{{ ('/disp-biro-eko/public/landing/css/custom.css') }}" rel="stylesheet">
	</head>
	<body style="background-color: #fbe6a5" class="login-body">
		<div class="content col-md-12" style="background-color: white">
			<!-- <nav class="navbar navbar-expand-sm bg-light"> -->
			<!-- <nav class="navbar navbar-expand-sm">
				<div class="container">
				  	<img src="{{ ('/disp-biro-eko/public/landing/img/bpad-logo-01.png') }}" alt="BPAD" width="100" class="navbar-brand">
					<ul class="navbar-nav">
						<li class="nav-item">
						  	<a class="nav-link cust-nav" href="#">Manual Book</a>
						</li>
						<li class="nav-item">
						  	<a class="nav-link cust-nav" href="#">Bisnis Proses</a>
						</li>
						<li class="nav-item">
						  	<a class="nav-link cust-nav" href="#">Video Tutorial</a>
						</li>
						<li class="nav-item">
						  	<a class="nav-link cust-nav" href="#">SOP</a>
						</li>
						<li class="nav-item">
						  	<a class="nav-link cust-nav" href="#">FAQ</a>
						</li>
					</ul>
				</div>
			</nav> -->

			<div class="container">
				<div class="row ">
					<div class="col-md-6">
						<img src="{{ ('/disp-biro-eko/public/landing/img/excel-logo-dki2.png') }}" alt="BPAD" width="60" class="navbar-brand" style="margin-top: 50px;">
						<div class="row">
							<p style="font-family: 'Myriad Pro Bold'; color: #5793ce; font-size: 24px; ">Selamat datang di </p>
						</div>
						<div class="row">
							<p style="font-family: 'Myriad Pro Regular'; color: #002853; font-size: 48px; "><span style="font-family: 'Myriad Pro Bold'; color: #002853; font-size: 48px;">DISPOSISI</span><br> BIRO PEREKONOMIAN</p>
						</div>
						<!-- <div class="row">
							<p style="font-family: 'Myriad Pro Regular'; text-align: justify; font-size: 20px">Sistem yang menunjukkan laporan BMD</p>
						</div> -->
						<div class="row">
							<form method="POST" action="{{ route('login') }}">
								@csrf

								@if(Auth::check())
								<button type="submit" class="btn btn-warning" style="color: white">MASUK</button>
								@else
								<div class="form-group">
									<label for="name" style="font-family: 'Myriad Pro Regular'; font-size: 18px; color: #5793ce;">Username</label>
									<input required="" autocomplete="off" type="text" name="name" class="form-control no-outline @error('name') is-invalid @enderror">	
								</div>
								<div class="form-group">
									<label for="password" style="font-family: 'Myriad Pro Regular'; font-size: 18px; color: #5793ce;">Password</label>
									<input required="" autocomplete="off" type="password" name="password" class="form-control no-outline @error('password') is-invalid @enderror">	
								</div>
								<button type="submit" class="btn btn-warning" style="color: white">LOGIN</button>
								@endif
								
							</form>
						</div>
						<div class="row">
							<footer class="page-footer">
								<div class="footer-copyright text-center py-3" style="color: #002853; font-family: 'Myriad Pro Regular'; font-size: 18px ">&#169; 2020 Provinsi DKI Jakarta</div>
							</footer>
						</div>
					</div>
					<div class="col-md-6" align="center" style="padding-top: 65px;">
						<img src="{{ ('/disp-biro-eko/public/img/photo/ico-laporan.png32') }}" width="90%">
					</div>
				</div>
			</div>
		</div>

		<script src="{{ ('/disp-biro-eko/public/landing/bootstrap400/js/bootstrap.min.js') }}"></script>
	</body>
</html>
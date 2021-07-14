<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="icon" type="image/png" sizes="16x16" href="../plugins/images/favicon.png">
	<title>Kode Barang</title>
	<!-- Bootstrap Core CSS -->
	<link href="/{{ env('APP_NAME') }}{{ ('/public/ample/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
	<!-- Footable CSS -->
	<link href="/{{ env('APP_NAME') }}{{ ('/public/ample/plugins/bower_components/footable/css/footable.core.css') }}" rel="stylesheet">
	<link href="/{{ env('APP_NAME') }}{{ ('/public/ample/plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}" rel="stylesheet" />
	<!-- Menu CSS -->
	<link href="/{{ env('APP_NAME') }}{{ ('/public/ample/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css') }}" rel="stylesheet">
	<!-- animation CSS -->
	<link href="/{{ env('APP_NAME') }}{{ ('/public/ample/css/animate.css') }}" rel="stylesheet">
	<!-- Custom CSS -->
	<link href="/{{ env('APP_NAME') }}{{ ('/public/ample/css/style.css') }}" rel="stylesheet">
	<!-- color CSS -->
	<link href="/{{ env('APP_NAME') }}{{ ('/public/ample/css/colors/blue-dark.css') }}" id="theme" rel="stylesheet">

	<style type="text/css">
		.footable-row-detail-inner {
			width: 100%;
		}

		.break-word{
			word-wrap: break-word;
		}
	</style>
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body class="fix-header">
	<!-- ============================================================== -->
	<!-- Preloader -->
	<!-- ============================================================== -->
	<div class="preloader">
		<svg class="circular" viewBox="25 25 50 50">
			<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
		</svg>
	</div>
	<!-- ============================================================== -->
	<!-- Wrapper -->
	<!-- ============================================================== -->
	<div id="wrapper">
		<!-- ============================================================== -->
		<!-- Topbar header - style you can find in pages.scss -->
		<!-- ============================================================== -->
		<nav class="navbar navbar-default navbar-static-top m-b-0" style="padding-left: 0px;">
			<div class="navbar-header">
				<div class="top-left-part">
					<!-- Logo -->
					<a class="logo" href="/{{ env('APP_NAME') }}/">
						<span class="hidden-sm hidden-md hidden-lg"><img width="50%" src="/{{ env('APP_NAME') }}/public/img/photo/bpad-logo-05.png"></span>
						<span class="hidden-xs"><img width="20%" src="/{{ env('APP_NAME') }}/public/img/photo/bpad-logo-000.png32"><strong>BPAD</strong>
						</span>
					</a>
				</div>
				<!-- /Logo -->
				<!-- Search input and Toggle icon -->
				<ul class="nav navbar-top-links navbar-left pull-right">
					<li class="mega-dropdown pull-right">
						<a class="dropdown-toggle waves-effect waves-light visible-xs visible-sm" data-toggle="dropdown" href="#"> <i class="ti-close ti-menu"></i>
						</a>
						<ul class="dropdown-menu mailbox animated bounceInDown">
							<li>
								<div class="message-center">
									@if(Auth::check())
									<a class="smallrul" href="/{{ env('APP_NAME') }}/home">MASUK</a>
									@else
									<a class="smallrul" href="/{{ env('APP_NAME') }}/login">LOGIN</a>
									@endif
								</div>
							</li>
						</ul>
					</li>
				</ul>
				<ul class="nav navbar-top-links navbar-right pull-right" >
					<li class="hidden-xs hidden-sm" style="padding-left: 5px; padding-right: 5px; font-weight: bold;">
						@if(Auth::check())
						<a href="/{{ env('APP_NAME') }}/home">MASUK</a>
						@else
						<a href="/{{ env('APP_NAME') }}/login">LOGIN</a>
						@endif
					</li>
				</ul>
			</div>
			<!-- /.navbar-header -->
			<!-- /.navbar-top-links -->
			<!-- /.navbar-static-side -->
		</nav>
		<!-- End Top Navigation -->
		
		<!-- ============================================================== -->
		<!-- Page Content -->
		<!-- ============================================================== -->
		<div id="page-wrapper" style="margin-left: 0px;">
			<div class="container">
				<div class="row" style="margin-top: 25px;">
					<div class="col-md-12 ">
						<div class="white-box">
							@if(is_null($searchnow))
							<div class="row">
								<div class="col-md-6 col-md-offset-3">
									<h2 class="text-center" style="font-weight: bold;">Pencarian Kode Barang</h2>
									<h3 class="text-center">Masukkan Nama Barang yang ingin anda cari</h3>
									<form method="GET" action="/{{ env('APP_NAME') }}/" class="	">
										<div class="form-group">
											<div class="col-md-6">
												<select class="form-control" name="kat" id="kat">
													<option value="nabar">Nama Barang</option>
													<option value="nakom">Nama Komponen</option>
													<option value="nabarkom">Nama Barang dan Komponen</option>
												</select>
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-6">
												<input type="text" name="cari" class="form-control" placeholder="Cari" value="{{ $searchnow }}" autocomplete="off">
											</div>
										</div>
										<div class="col-md-12"> 
											<button type="sumit" class="btn btn-block btn-rounded btn-info content-center" style="margin-top: 20px;">Cari</button>
										</div>
									</form>
								</div>
							</div>
							@else
							<h3 class="box-title m-b-0">Tabel kode barang</h3>
							<p class="text-muted m-b-0">Tekan baris yang diinginkan untuk melihat daftar komponen terkait</p>
							<div class="row">
								<form method="GET" action="/{{ env('APP_NAME') }}/">
									<div class="form-group">
										<div class="col-md-3">
											<select class="form-control" name="kat" id="kat" onchange="this.form.submit()">
												<option <?php if ($katnow == "nabar"): ?> selected <?php endif ?> value="nabar">Nama Barang</option>
												<option <?php if ($katnow == "nakom"): ?> selected <?php endif ?> value="nakom">Nama Komponen</option>
												<option <?php if ($katnow == "nabarkom"): ?> selected <?php endif ?> value="nabarkom">Nama Barang dan Komponen</option>
											</select>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-5">
											<input type="text" name="cari" class="form-control" placeholder="Cari" value="{{ $searchnow }}" autocomplete="off">
										</div>
									</div>
										
										
									<button type="submit" class="btn btn-info">Cari</button>
								</form>
							</div>
							
							<div class="table-responsive">
								<table id="demo-foo-row-toggler" class="table table-bordered m-b-0 m-t-20 toggle-circle">
									<thead>
										<tr>
											<th data-toggle="true"> </th>
											<th>Kode Barang</th>
											<th> Nama </th>
											<th> Jenis </th>
											<th> Objek </th>
											<th> Rincian </th>
											<th data-hide="all"> </th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td></td>
											<td><b>117010307001</b></td>
											<td>Sapu Dan Sikat</td>
											<td><b>ASET LANCAR</b><br> <span class="text-muted">PERSEDIAAN</span></td>
											<td>BARANG PAKAI HABIS</td>
											<td>ALAT/BAHAN UNTUK KEGIATAN KANTOR<br><span class="text-muted">PERABOT KANTOR</span></td>
											<td>														
												<div class="white-box">
													<div class="table-responsive">
														<h5 class="box-title m-b-0">Tabel Komponen</h5>
														<p class="text-muted m-b-20"><b>117010307001</b> - Sapu Dan Sikat</p>
														<table class="table table-hover table-bordered">
															<thead>
																<tr>
																	<th>No</th>
																	<th class="col-md-3">KOMPONEN</th>
																	<th class="col-md-2">SATUAN</th>
																	<th class="col-md-4">KETERANGAN</th>
																	<th class="col-md-2">HARGA</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td>1</td>
																	<td><b>1.1.7.01.03.07.001.00002</b><br>Gagang Sapu</span></td>
																	<td>Batang</td>
																	<td>Bahan Kayu</td>
																	<td>Rp 2.590</td>
																</tr>
																<tr>
																	<td>2</td>
																	<td><b>1.1.7.01.03.07.001.00027</b><br>Sapu Laba - Laba</span></td>
																	<td>Buah</td>
																	<td>Tangkai Almunium 2 Mtr (Rak Ball)</td>
																	<td>Rp 61.370</td>
																</tr>
																<tr>
																	<td>3</td>
																	<td><b>1.1.7.01.03.07.001.00074</b><br>Sapu Dorong</span></td>
																	<td>Buah</td>
																	<td>Spesifikasi : lebar kain 80 cm terbuat dari katun halus, tinggi tiang 140 cm berbahan gagang stainless/ alumunium</td>
																	<td>Rp 202.500</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
											</td>
										</tr>
										<tr>
											<td></td>
											<td><b>135050101006</b></td>
											<td>Tanaman Hias</td>
											<td><b>ASET TETAP</b><br> <span class="text-muted">ASET TETAP LAINNYA</span></td>
											<td>TANAMAN</td>
											<td>TANAMAN<br><span class="text-muted">TANAMAN</span></td>
											<td>														
												<div class="white-box">
													<div class="table-responsive">
														<table class="table table-hover table-bordered">
															<thead>
																<tr>
																	<th>No</th>
																	<th class="col-md-3">KOMPONEN</th>
																	<th class="col-md-2">SATUAN</th>
																	<th class="col-md-4">KETERANGAN</th>
																	<th class="col-md-2">HARGA</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td>1</td>
																	<td><b>1.3.5.05.01.01.006.00194</b><br>Bunga SapuTangan (Maniltoa gemmipara)</span></td>
																	<td>Batang Pohon</td>
																	<td>Tinggi 400 - 450 cm, dia batang 10-12 cm</td>
																	<td>Rp 1.500.000</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
											</td>
										</tr>
										<tr>
											<td></td>
											<td><b>912260101002</b></td>
											<td>HONORARIUM TENAGA AHLI NASIONAL</td>
											<td><b>BEBAN OPERASI - LO</b><br> <span class="text-muted">BEBAN BARANG DAN JASA</span></td>
											<td>HONORARIUM NON PNS</td>
											<td>HONORARIUM TENAGA AHLI/INSTRUKTUR/NARASUMBER<br><span class="text-muted">HONORARIUM TENAGA AHLI</span></td>
											<td>														
												<div class="white-box">
													<div class="table-responsive">
														<table class="table table-hover table-bordered">
															<thead>
																<tr>
																	<th>No</th>
																	<th class="col-md-3">KOMPONEN</th>
																	<th class="col-md-2">SATUAN</th>
																	<th class="col-md-4">KETERANGAN</th>
																	<th class="col-md-2">HARGA</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td>1</td>
																	<td><b>9.1.2.26.01.01.002.00293</b><br>Sapu Ijuk</span></td>
																	<td>Buah</td>
																	<td>Bahan serabut dan kayu</td>
																	<td>Rp 25.990</td>
																</tr>
																<tr>
																	<td>2</td>
																	<td><b>9.1.2.26.01.01.002.00294</b><br>Sapu Lidi</span></td>
																	<td>Buah</td>
																	<td>Bahan batang kelapa</td>
																	<td>Rp 23.630</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
								
							@endif
						</div>
					</div>
				</div>
			</div>
			<!-- /.container-fluid -->
			<footer class="footer text-center"> {{ date('Y') }} &copy; Subbidang Data Informasi Aset BPAD </footer>
		</div>
		<!-- ============================================================== -->
		<!-- End Page Content -->
		<!-- ============================================================== -->
	</div>
	<!-- /#wrapper -->
	<!-- jQuery -->
	<script src="/{{ env('APP_NAME') }}{{ ('/public/ample/plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
	<!-- Bootstrap Core JavaScript -->
	<script src="/{{ env('APP_NAME') }}{{ ('/public/ample/bootstrap/dist/js/bootstrap.min.js') }}"></script>
	<!-- Menu Plugin JavaScript -->
	<script src="/{{ env('APP_NAME') }}{{ ('/public/ample/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js') }}"></script>
	<!--slimscroll JavaScript -->
	<script src="/{{ env('APP_NAME') }}{{ ('/public/ample/js/jquery.slimscroll.js') }}"></script>
	<!--Wave Effects -->
	<script src="/{{ env('APP_NAME') }}{{ ('/public/ample/js/waves.js') }}"></script>
	<!-- Custom Theme JavaScript -->
	<script src="/{{ env('APP_NAME') }}{{ ('/public/ample/js/custom.min.js') }}"></script>
	<!-- Footable -->
	<script src="/{{ env('APP_NAME') }}{{ ('/public/ample/plugins/bower_components/footable/js/footable.all.min.js') }}"></script>
	<script src="/{{ env('APP_NAME') }}{{ ('/public/ample/plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}" type="text/javascript"></script>
	<!--FooTable init-->
	<script src="/{{ env('APP_NAME') }}{{ ('/public/ample/js/footable-init.js') }}"></script>
	<!--Style Switcher -->
	<script src="/{{ env('APP_NAME') }}{{ ('/public/ample/plugins/bower_components/styleswitcher/jQuery.style.switcher.js') }}"></script>
</body>

</html>
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
	<link href="/{{ env('APP_NAME') }}{{ ('/public/ample/plugins/bower_components/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
	<!-- <link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" /> -->
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
				<div class="row text-center ">
					<div class="col-md-12 m-t-20">
						<h1 style="font-weight: bold;">Selamat Datang di Sistem e-Kobar</h1>	
					</div>
				</div>
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
												<input type="text" name="cari" class="form-control" placeholder="Cari" value="{{ $searchnow }}" autocomplete="off" required="">
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
											<select class="form-control" name="kat" id="kat">
												<option <?php if ($katnow == "nabar"): ?> selected <?php endif ?> value="nabar">Nama Barang</option>
												<option <?php if ($katnow == "nakom"): ?> selected <?php endif ?> value="nakom">Nama Komponen</option>
												<option <?php if ($katnow == "nabarkom"): ?> selected <?php endif ?> value="nabarkom">Nama Barang dan Komponen</option>
											</select>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-5">
											<input type="text" name="cari" class="form-control" placeholder="Cari" value="{{ $searchnow }}" autocomplete="off" required="">
										</div>
									</div>
									<button type="submit" class="btn btn-info">Cari</button>
								</form>
							</div>
							
							<div class="table-responsive" style="overflow: visible;">
								@if (!(isset($datas[0]))) 
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
											<td colspan="6" class="text-center" style="color: red;"><b>Data tidak ditemukan</b></td>
										</tr>
									</tbody>
								</table>
								@else
								<table id="demo-foo-row-toggler" class="table table-bordered m-b-0 m-t-20 toggle-circle">
									<thead>
										<tr>
											<th data-toggle="true"> </th>
											<th>Kode Barang</th>
											<th> Nama </th>
											<th> Detail </th>
											<th> Jenis </th>
											<th> Objek </th>
											<th> Rincian </th>
											<th data-hide="all"> </th>
										</tr>
									</thead>
									<tbody>
										@for($i=0; $i < count($datas); $i++)
										<?php $flag = 0; ?>
										<tr>
											<td></td>
											<td><b>{{ $datas[$i]['KOBAR'] }}</b></td>
											<td>{{ $datas[$i]['NABAR'] }}</td>
											<td>
												<span class="mytooltip tooltip-effect-1"> 
													<span class="tooltip-item">Detail</span> 
													<span class="tooltip-content clearfix"> 
														<table class="table table-bordered">
															<tbody>
																<tr>
																	<td><strong>Deskripsi</strong></td>
																	<td>
																		{{ $datas[$i]['KOBAR_DESK'] ?? '-' }}
																	</td>
																</tr>
																<tr>
																	<td><strong>Gambar</strong></td>
																	<td>
																		<img src="{{ $datas[$i]['KOBAR_IMG'] ? config('app.openfileimgkobar') .'/'. $datas[$i]['KOBAR'] .'/'. $datas[$i]['KOBAR_IMG'] : config('app.openfileimgcontentdefault') }}">
																	</td>
																</tr>
																
															</tbody>
														</table> 
													</span> 
												</span>
											</td>
											<td><b>{{ $datas[$i]['KELOMPOK'] }}</b><br> <span class="text-muted">{{ $datas[$i]['JENIS'] }}</span></td>
											<td>{{ $datas[$i]['OBJEK'] }}</td>
											<td>{{ $datas[$i]['RINCIAN_OBJEK'] }}<br><span class="text-muted">{{ $datas[$i]['SUB_RINCIAN_OBJEK'] }}</span></td>
											<td>														
												<div class="white-box">
													<div class="table-responsive">
														<h5 class="box-title m-b-0">Tabel Komponen</h5>
														<p class="text-muted m-b-20"><b> </b> </p>
														@if (!(isset($datas[$i]['KOMPONEN_KODE'])))
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
																	<td colspan="6" class="text-center" style="color: red;"><b>Data tidak ditemukan</b></td>
																</tr>
															</tbody>
														</table>
														@else
														<table id="" class="table myTable table-hover table-bordered">
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
																<?php $num = 1 ?>
																@while(true)
																<tr>
																	<td>{{ $num }}</td>
																	<td><b>{{ $datas[$i]['KOMPONEN_KODE'] }}</b><br>{{ $datas[$i]['KOMPONEN_NAMA'] }}</span></td>
																	<td>{{ $datas[$i]['SATUAN'] ?? '-' }}</td>
																	<td>{{ $datas[$i]['SPESIFIKASI'] ?? '-' }}</td>
																	<td>Rp {{ $datas[$i]['HARGA'] ? number_format($datas[$i]['HARGA'],2,',','.') : '-' }}</td>
																</tr>

																@if(isset($datas[$i+1]['KOBAR_PERMENDAGRI']) && $datas[$i]['KOBAR_PERMENDAGRI'] == $datas[$i+1]['KOBAR_PERMENDAGRI'])
																<?php $i++; $num++; ?>
																@else
																<?php $flag = 1; ?>
																@endif

																<?php if ($flag == 1) break; ?>
																@endwhile
															</tbody>
														</table>
														@endif
													</div>
												</div>
											</td>
										</tr>
										@endfor
									</tbody>
								</table>
								@endif
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
	<script src="/{{ env('APP_NAME') }}{{ ('/public/ample/plugins/bower_components/datatables/jquery.dataTables.min.js') }}"></script>
	<!-- Footable -->
	<script src="/{{ env('APP_NAME') }}{{ ('/public/ample/plugins/bower_components/footable/js/footable.all.min.js') }}"></script>
	<script src="/{{ env('APP_NAME') }}{{ ('/public/ample/plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}" type="text/javascript"></script>
	<!--FooTable init-->
	<script src="/{{ env('APP_NAME') }}{{ ('/public/ample/js/footable-init.js') }}"></script>
	<!--Style Switcher -->
	<script src="/{{ env('APP_NAME') }}{{ ('/public/ample/plugins/bower_components/styleswitcher/jQuery.style.switcher.js') }}"></script>

	<script>
		$(document).ready(function () {
			$('.myTable').DataTable();
		});
	</script>
</body>

</html>
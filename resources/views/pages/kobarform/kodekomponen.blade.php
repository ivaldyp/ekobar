@extends('layouts.masterhome')

@section('css')
	<!-- Bootstrap Core CSS -->
	<link href="/{{ env('APP_NAME') }}{{ ('/public/ample/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="/{{ env('APP_NAME') }}{{ ('/public/ample/plugins/bower_components/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
	<!-- <link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" /> -->
	<!-- Menu CSS -->
	<link href="/{{ env('APP_NAME') }}{{ ('/public/ample/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css') }}" rel="stylesheet">
	<!-- animation CSS -->
	<link href="/{{ env('APP_NAME') }}{{ ('/public/ample/css/animate.css') }}" rel="stylesheet">
	<!-- Custom CSS -->
	<link href="/{{ env('APP_NAME') }}{{ ('/public/ample/css/style.css') }}" rel="stylesheet">
	<!-- color CSS -->
	<link href="/{{ env('APP_NAME') }}{{ ('/public/ample/css/colors/blue-dark.css') }}" id="theme" rel="stylesheet">
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
@endsection

<!-- /////////////////////////////////////////////////////////////// -->

@section('content')
	<style type="text/css">
		#li_portal a.active {
			background:white;
		}
	</style>
	<div id="page-wrapper">
		<div class="container-fluid">
			<div class="row bg-title">
				<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
					<h4 class="page-title"><?php 
												$link = explode("/", url()->full());    
												echo str_replace('%20', ' ', ucwords(explode("?", $link[4])[0]));
											?> </h4> </div>
				<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12"> 
					<ol class="breadcrumb">
						<li>{{env('APP_BREADCRUMB')}}</li>
						<?php 
							if (count($link) == 5) {
								?> 
									<li class="active"> {{ str_replace('%20', ' ', ucwords(explode("?", $link[4])[0])) }} </li>
								<?php
							} elseif (count($link) > 5) {
								?> 
									<li class="active"> {{ str_replace('%20', ' ', ucwords(explode("?", $link[4])[0])) }} </li>
									<li class="active"> {{ str_replace('%20', ' ', ucwords(explode("?", $link[5])[0])) }} </li>
								<?php
							} 
						?>  
					</ol>
				</div>
				<!-- /.col-lg-12 -->
			</div>
			<div class="row">
				<div class="col-sm-12">
					@if(Session::has('message'))
						<div class="alert <?php if(Session::get('msg_num') == 1) { ?>alert-success<?php } else { ?>alert-danger<?php } ?> alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="color: white;">&times;</button>{{ Session::get('message') }}</div>
					@endif
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="white-box">
						<form class="" method="GET" action="/{{ env('APP_NAME') }}/form/kodekomponen">
						<div class="form-group">
							<label for="nabar" class="control-label">Nama Barang</label>
							<input type="text" class="form-control" name="nabar" id="nabar" autocomplete="off" placeholder="Masukkan Nama Barang" value="{{ $nabar }}">
						</div>
						<button type="submit" class="btn btn-info waves-effect waves-light m-r-10">Cari</button>
					</div>
				</div>
				<div class="col-md-6">
					<div class="white-box">
						<div class="form-group">
							<label for="nakom" class="control-label">Nama Komponen</label>
							<input type="text" class="form-control" name="nakom" id="nakom" autocomplete="off" placeholder="Masukkan Nama Komponen" value="{{ $nakom }}">
						</div>
						<button type="submit" class="btn btn-info waves-effect waves-light m-r-10">Cari</button>
						</form>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="white-box">
						<div class="table-responsive">
							@if (!(isset($kobars[0]))) 
							<table id="" class="table table-bordered m-b-0 m-t-20 toggle-circle">
								<thead>
									<tr>
										<th>No</th>
										<th>Barang</th>
										<th>Jenis</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td colspan="3" class="text-center" style="color: red;"><b>Data tidak ditemukan</b></td>
									</tr>
								</tbody>
							</table>
							@else
							<table id="" class="myTable table table-bordered m-b-0 m-t-20">
								<thead>
									<tr>
										<th>No</th>
										<th>Barang</th>
										<th>Jenis</th>
									</tr>
								</thead>
								<tbody>
									@foreach($kobars as $key => $datas)
									<tr>
										<td>
											{{ $key + 1 }}
										</td>
										<td>
											<b>{{ $datas['KOBAR'] }}</b><br>
											{{ $datas['NABAR'] }}
										</td>
										<td>
											<b>{{ $datas['KELOMPOK'] }}</b><br>
											{{ $datas['JENIS'] }}<br>
											{{ $datas['OBJEK'] }}<br>
											{{ $datas['RINCIAN_OBJEK'] }}<br>
											{{ $datas['SUB_RINCIAN_OBJEK'] }}
										</td>
									@endforeach
									</tr>
								</tbody>
							</table>
							@endif
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="white-box">
						<div class="table-responsive">
							@if (!(isset($komponens[0]))) 
							<table id="" class=" table table-bordered m-b-0 m-t-20 toggle-circle">
								<thead>
									<tr>
										<th>Kobar</th>
										<th>Komponen</th>
										<th>Edit</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td colspan="3" class="text-center" style="color: red;"><b>Data tidak ditemukan</b></td>
									</tr>
								</tbody>
							</table>
							@else
							<table id="" class="myTable table table-bordered m-b-0 m-t-20 toggle-circle">
								<thead>
									<tr>
										<th>Kobar</th>
										<th>Komponen</th>
										<th>Edit</th>
									</tr>
								</thead>
								<tbody>
									@foreach($komponens as $key => $datas)
									<tr>
										<td>
											<b>{{ $datas['KOBAR_PERMENDAGRI'] }}</b><br>
											{{ $datas['NABAR_PERMENDAGRI'] }}
										</td>
										<td>
											<b>{{ $datas['KOMPONEN_KODE'] }}</b><br>
											{{ $datas['KOMPONEN_NAMA'] }}<br>
											{{ $datas['SPESIFIKASI'] }}<br>
											<span class="text-muted">Rp. {{ $datas['HARGA'] ? number_format($datas['HARGA'],2,',','.') : '-' }}</span>
											<br>
										</td>
										<td>
											<button type="button" class="btn btn-warning btn-kode" data-toggle="modal" data-target="#modal-kode" data-kodekomp="{{ $datas['KOMPONEN_KODE'] }}"><i class="fa fa-key"></i></button>
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>

		<div id="modal-kode" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<form method="POST" action="/{{ env('APP_NAME') }}/form/kodekomponen" class="form-horizontal">
					@csrf
						<div class="modal-header">
							<h4 class="modal-title"><b>Sambungkan Kode Komponen dengan Kode Barang</b></h4>
						</div>
						<div class="modal-body">
							<h4>Masukkan Kode Barang  </h4>

							<input type="text" class="form-control" placeholder="" id="newkobar" required="" data-mask="9.9.9.99.99.99.999" name="newkobar">
							<input type="hidden" name="komponen_kode" id="form_update_komponen_kode" value="">

							<div class="clearfix"></div>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-info pull-right">Simpan</button>
							<button type="button" class="btn btn-default pull-right" style="margin-right: 10px" data-dismiss="modal">Close</button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<!-- /.container-fluid -->
		<footer class="footer text-center"> {{ date('Y') }} &copy; Ample Admin brought to you by themedesigner.in </footer>
	</div>
	
@endsection

<!-- /////////////////////////////////////////////////////////////// -->

@section('js')
	<script src="/{{ env('APP_NAME') }}{{ ('/public/ample/plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
	<!-- Bootstrap Core JavaScript -->
	<!-- <script src="https://code.jquery.com/jquery-3.4.1.js"></script> -->
	<script src="/{{ env('APP_NAME') }}{{ ('/public/ample/bootstrap/dist/js/bootstrap.min.js') }}"></script>
	<!-- Menu Plugin JavaScript -->
	<script src="/{{ env('APP_NAME') }}{{ ('/public/ample/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js') }}"></script>
	<!--slimscroll JavaScript -->
	<script src="/{{ env('APP_NAME') }}{{ ('/public/ample/js/jquery.slimscroll.js') }}"></script>
	<!--Wave Effects -->
	<script src="/{{ env('APP_NAME') }}{{ ('/public/ample/js/waves.js') }}"></script>
	<script src="/{{ env('APP_NAME') }}{{ ('/public/ample/js/mask.js') }}"></script>
	<!-- Custom Theme JavaScript -->
	<script src="/{{ env('APP_NAME') }}{{ ('/public/ample/js/custom.min.js') }}"></script>
	<script src="/{{ env('APP_NAME') }}{{ ('/public/ample/plugins/bower_components/datatables/jquery.dataTables.min.js') }}"></script>
	<!--Style Switcher -->
	<script src="/{{ env('APP_NAME') }}{{ ('/public/ample/plugins/bower_components/styleswitcher/jQuery.style.switcher.js') }}"></script>


	<script type="text/javascript">
		$(function () {
			$('.btn-kode').on('click', function () {
				var $el = $(this);
				$("#form_update_komponen_kode").val($el.data('kodekomp'));
			});

			$("#modal-kode").on("hidden.bs.modal", function () {
				$("#newkobar").empty();
			});

			$('.myTable').DataTable({
				// "paging":   false,
		        "ordering": false,
		        // "info":     false,
			});
		});
	</script>
@endsection

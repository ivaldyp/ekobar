@extends('layouts.masterhome')

@section('css')
	<!-- Bootstrap Core CSS -->
	<link href="/{{ env('APP_NAME') }}{{ ('/ample/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="/{{ env('APP_NAME') }}{{ ('/ample/plugins/bower_components/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
	<!-- Menu CSS -->
	<link href="/{{ env('APP_NAME') }}{{ ('/ample/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css') }}" rel="stylesheet">
	<!-- animation CSS -->
	<link href="/{{ env('APP_NAME') }}{{ ('/ample/css/animate.css') }}" rel="stylesheet">
	<!-- Custom CSS -->
	<link href="/{{ env('APP_NAME') }}{{ ('/ample/css/style.css') }}" rel="stylesheet">
	<!-- color CSS -->
	<link href="/{{ env('APP_NAME') }}{{ ('/ample/css/colors/blue-dark.css') }}" id="theme" rel="stylesheet">
	<!-- page CSS -->
	<link href="/{{ env('APP_NAME') }}{{ ('/ample/plugins/bower_components/custom-select/custom-select.css') }}" rel="stylesheet" type="text/css" />
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
						<li>{{env('app_breadcrumb')}}</li>
						<?php 
							$link = explode("/", url()->full());
							if (count($link) == 5) {
								?> 
									<li class="active"> {{ ucwords(explode("?", $link[4])[0]) }} </li>
								<?php
							} elseif (count($link) == 6) {
								?> 
									<li class="active"> {{ ucwords($link[4]) }} </li>
									<li class="active"> {{ ucwords($link[5]) }} </li>
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
			<!-- <div class="row">
				<div class="col-md-12">
					<div class="white-box">
						
					</div>
				</div>
			</div> -->
			<div class="row">
				<div class="col-md-12">
					<div class="white-box">
						<h3 class="box-title m-b-20">Kelola Kode Barang</h3>
						<div class="row m-b-0">
							<div class="col-md-2">
								<a href="/{{ env('APP_NAME') }}/form/tambahkobar" target="_blank"><button class="btn btn-success">+ Tambah</button></a>	
							</div>
						</div>
						<div class="row m-b-20">
							<form method="GET" action="/{{ env('APP_NAME') }}/form/ubahkobar">
								<div class="form-group">
									<div class="col-md-6">
										<input type="text" name="nabar" class="form-control" placeholder="Cari" value="{{ $nabar }}" autocomplete="off" required="">
									</div>
								</div>
								<button type="submit" class="btn btn-info">Cari</button>
							</form>
						</div>

						<div class="row">
							<div class="table-responsive" style="overflow: visible;">
								@if (!(isset($kobars[0]))) 
								<table class="table table-bordered">
									<thead>
										<tr>
											<th>No</th>
											<th>Barang</th> 
											<th>Deskripsi</th>
											<th>Keterangan</th>
											<th>Gambar</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td colspan="6" class="text-center" style="color: red;"><b>Data tidak ditemukan</b></td>
										</tr>
									</tbody>
								</table>
								@else
								<table id="myTable" class="table table-bordered" >
									<thead>
										<tr>
											<th>No</th>
											<th>Barang</th> 
											<th>Detail</th>
											<th> Jenis </th>
											<th> Objek </th>
											<th> Rincian Objek </th>
											<th> Sub Rincian Objek </th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										@foreach($kobars as $key => $kobar)
										<tr>
											<td>{{ $key+1 }}</td>
											<td>
												<b>{{ $kobar['KOBAR'] }}</b><br>
												{{ $kobar['NABAR'] }}
											</td>
											<td >
												<span class="mytooltip tooltip-effect-1" style="z-index: 0"> 
													<span class="tooltip-item">Detail</span> 
													<span class="tooltip-content clearfix"> 
														<table class="table table-bordered">
															<tbody>
																<tr>
																	<td><strong>Deskripsi</strong></td>
																	<td>
																		{{ $kobar['KOBAR_DESK'] ?? '-' }}
																	</td>
																</tr>
																<tr>
																	<td><strong>Gambar</strong></td>
																	<td>
																		<a href="javascript:void(0)" @if($kobar['KOBAR_IMG']) class="pop" @endif>
																		<img src="{{ $kobar['KOBAR_IMG'] ? config('app.openfileimgkobar') .'/'. $kobar['KOBAR'] .'/'. $kobar['KOBAR_IMG'] : config('app.openfileimgcontentdefault') }}">
																		</a>
																	</td>
																</tr>
																
															</tbody>
														</table> 
													</span> 
												</span>
											</td>
											{{-- <td>
												<b>{{ $kobar['KELOMPOK'] ?? '-' }}</b><br>
												{{ $kobar['JENIS'] ?? '-' }}<br>
												{{ $kobar['OBJEK'] ?? '-' }}<br>
												{{ $kobar['RINCIAN_OBJEK'] ?? '-' }}<br>
												{{ $kobar['SUB_RINCIAN_OBJEK'] ?? '-' }}
											</td> --}}
											<td><b>{{ $kobar['KELOMPOK'] }}</b><span class="text-muted">{{ $kobar['JENIS'] ? ' - ' . $kobar['JENIS'] : '-' }}</span></td>
											<td>{{ $kobar['OBJEK'] ?? '-' }}</td>
											<td>{{ $kobar['RINCIAN_OBJEK'] ?? '-' }}<br></td>
											<td>{{ $kobar['SUB_RINCIAN_OBJEK'] ?? '-' }}</td>
											
											<td class="text-nowrap">
												<button type="submit" class="btn btn-warning btn-update-kobar" data-toggle="modal" data-target="#modal-ubah"
													data-kobar="{{ $kobar['KOBAR'] }}"
													data-nabar="{{ $kobar['NABAR'] }}"
													data-desk="{{ $kobar['KOBAR_DESK'] }}"
													data-img="{{ $kobar['KOBAR_IMG'] }}"
													data-sts="{{ $kobar['sts'] }}"
												><i class="fa fa-edit"></i></button>
												@if($kobar['sts'] == '1')
												<button type="submit" class="btn btn-danger btn-delete-kobar" data-toggle="modal" data-target="#modal-hapus"
													data-kobar="{{ $kobar['KOBAR'] }}"
													data-kobarkode="{{ $kobar['KOBAR_KODE'] }}"
													data-nabar="{{ $kobar['NABAR'] }}"
												><i class="fa fa-trash"></i></button>
												@endif
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
			<div id="modal-ubah" class="modal fade" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content modal-lg">
						<form method="POST" action="/{{ env('APP_NAME') }}/form/ubahkobar" class="form-horizontal" enctype="multipart/form-data">
						@csrf
							<div class="modal-header">
								<h4 class="modal-title"><b>Ubah Data Kode Barang</b></h4>
							</div>
							<div class="modal-body">

								<input type="hidden" name="kobar" id="thiskobar">

								<div class="form-group">
									<label for="modal_update_newkobar" class="col-md-3 control-label"> Kode Barang <span style="color: red; font-size: 20px;"> *</span></label>
									<div class="col-md-9">
										<input type="text" disabled="" readonly="" id="modal_update_kobar" class="form-control">
										
									</div>
								</div>

								<div class="form-group" id="formnabar">
									<label for="modal_update_nabar" class="col-md-3 control-label"> Nama Barang <span style="color: red; font-size: 20px;"> *</span></label>
									<div class="col-md-9">
										<input autocomplete="off" type="text" name="nabar" class="form-control" id="modal_update_nabar" required>
									</div>
								</div>

								<div class="form-group">
									<label for="modal_update_desk" class="col-md-3 control-label">Deskripsi</label>
									<div class="col-md-9">
										<textarea name="desk" class="form-control" rows="3" id="modal_update_desk">
										</textarea>
	                                </div>
								</div>

								<div class="form-group">
                                    <label for="modal_update_img" class="col-md-3 control-label"> Gambar <br> 
                                    	<span style="font-size: 10px">Hanya berupa JPG, JPEG, dan PNG</span><br>
                                    	<span style="font-size: 10px">Maksimal 500KB</span>
                                    </label>
                                    <div class="col-md-9">
                                        <input type="file" class="form-control" id="modal_update_img" name="img">
                                        <a target="_blank" id="kobarimg" href=""> Lihat Gambar </a>
                                    </div>
                                </div>

								
							</div>
							<div class="modal-footer">
								<button type="submit" class="btn btn-success pull-right">Simpan</button>
								<button type="button" class="btn btn-inverse pull-right" style="margin-right: 10px" data-dismiss="modal">Close</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="modal fade modal-delete" id="modal-hapus">
				<div class="modal-dialog">
					<div class="modal-content">
						<form method="POST" action="/{{ env('APP_NAME') }}/form/hapuskobar" class="form-horizontal">
						@csrf
							<div class="modal-header">
								<h4 class="modal-title"><b>Hapus Kode Barang</b></h4>
							</div>
							<div class="modal-body">
								<h4 class="label_delete"></h4>
								<input type="hidden" name="kobar" id="modal_delete_kobar" value="">
								<input type="hidden" name="kobarkode" id="modal_delete_kobarkode" value="">
								<input type="hidden" name="nabar" id="modal_delete_nabar" value="">
							</div>
							<div class="modal-footer">
								<button type="submit" class="btn btn-danger pull-right">Hapus</button>
								<button type="button" class="btn btn-default pull-right" style="margin-right: 10px" data-dismiss="modal">Close</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">              
					<div class="modal-body">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<img src="" class="imagepreview" style="width: 100%;">
					</div>
				</div>
			</div>
		</div>
		<!-- /.container-fluid -->
		<footer class="footer text-center"> {{ date('Y') }} &copy; Ample Admin brought to you by themedesigner.in </footer>
	</div>
	
@endsection

<!-- /////////////////////////////////////////////////////////////// -->

@section('js')
	<script src="/{{ env('APP_NAME') }}{{ ('/ample/plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
	<!-- Bootstrap Core JavaScript -->
	<!-- <script src="https://code.jquery.com/jquery-3.4.1.js"></script> -->
	<script src="/{{ env('APP_NAME') }}{{ ('/ample/bootstrap/dist/js/bootstrap.min.js') }}"></script>
	<!-- Menu Plugin JavaScript -->
	<script src="/{{ env('APP_NAME') }}{{ ('/ample/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js') }}"></script>
	<!--slimscroll JavaScript -->
	<script src="/{{ env('APP_NAME') }}{{ ('/ample/js/jquery.slimscroll.js') }}"></script>
	<!--Wave Effects -->
	<script src="/{{ env('APP_NAME') }}{{ ('/ample/js/waves.js') }}"></script>
	<script src="/{{ env('APP_NAME') }}{{ ('/ample/js/mask.js') }}"></script>
	<!-- Custom Theme JavaScript -->
	<script src="/{{ env('APP_NAME') }}{{ ('/ample/js/custom.min.js') }}"></script>
	<script src="/{{ env('APP_NAME') }}{{ ('/ample/plugins/bower_components/custom-select/custom-select.min.js') }}" type="text/javascript"></script>
	<script src="/{{ env('APP_NAME') }}{{ ('/ample/plugins/bower_components/datatables/jquery.dataTables.min.js') }}"></script>
	<!--Style Switcher -->
	<script src="/{{ env('APP_NAME') }}{{ ('/ample/plugins/bower_components/styleswitcher/jQuery.style.switcher.js') }}"></script>


	<script type="text/javascript">
		$(function () {
			$(".select2").select2();

			$('.pop').on('click', function() {
				$('.imagepreview').attr('src', $(this).find('img').attr('src'));
				$('#imagemodal').modal('show');   
			});	

		    $('#myTable').DataTable({
		    	"oLanguage": {
					"sSearch": "Filter Barang:"
				},
                paging: false,
		    });

		    $('.btn-update-kobar').on('click', function () {
				var $el = $(this);
				$("#thiskobar").val($el.data('kobar'));
				$("#modal_update_kobar").val($el.data('kobar'));
				$("#modal_update_nabar").val($el.data('nabar'));
				$("#modal_update_desk").val($el.data('desk'));
				$("#modal_update_img").val('');

				if($el.data('sts') == '1'){
					$("#formnabar").show();

				} else {
					$("#formnabar").hide();
				}

				if ($el.data('img') == null || $el.data('img') == '') {
					$("#kobarimg").hide();
					var urlimg = '/ekobar/public/publicimg/imgnotfound.jpg';
					$("#kobarimg").attr("href", urlimg);
				} else {
					$("#kobarimg").show();
					var urlimg = '/ekobar/public/publicfile/kobar/' + $el.data('kobar') + '/' +  $el.data('img');
					$("#kobarimg").attr("href", urlimg);
				}

			});

			$('.btn-delete-kobar').on('click', function () {
				var $el = $(this);
				$(".label_delete").append('Apakah anda yakin ingin menghapus Kode Barang <b>'+ $el.data('kobar') +'</b> dengan nama <b>'+ $el.data('nabar') +'</b>?');
				$("#modal_delete_kobar").val($el.data('kobar'));
				$("#modal_delete_kobarkode").val($el.data('kobarkode'));
				$("#modal_delete_nabar").val($el.data('nabar'));
			});

			$(".modal-delete").on("hidden.bs.modal", function () {
				$(".label_delete").empty();
			});
		});
	</script>
@endsection

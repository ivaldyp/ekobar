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
			
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-info">
                        <div class="panel-heading"> Tambah Kode Barang </div>
                        <div class="panel-wrapper collapse in" aria-expanded="true">
                            <div class="panel-body">
                            	<form class="form-horizontal" method="POST" action="/{{ env('APP_NAME') }}/form/tambahkobar" data-toggle="validator" enctype="multipart/form-data">
                            		@csrf
									<div class="form-group">
										<label for="parentid" class="col-sm-2 control-label">Parent Kobar</label>
										<div class="col-sm-10">
		                                    <select class="form-control select2" id="parentid">
		                                    	<option value="type">-- KETIK SENDIRI --</option>
		                                        @foreach($kobars as $key => $kobar)
		                                        <option <?php if(Session::get('parentbar') == $kobar->KOBAR): ?> selected <?php endif ?> value="{{ $kobar->KOBAR }}||{{ $kobar->NABAR }}||{{ $kobar->KELOMPOK }}||{{ $kobar->JENIS }}||{{ $kobar->OBJEK }}||{{ $kobar->RINCIAN_OBJEK }}||{{ $kobar->SUB_RINCIAN_OBJEK }}||{{ $kobar->KOBAR_KODE }}">[{{ $kobar->KOBAR }}] - {{ $kobar->NABAR }}</option>
		                                        @endforeach
		                                    </select>
		                                </div>
									</div>
									<div class="form-group">
										<label for="kelompok" class="col-sm-2 control-label">Kelompok</label>
										<div class="col-sm-10">
		                                    <p class="form-control-static" id="kelompok"> </p>
		                                </div>
									</div>
									<div class="form-group">
										<label for="jenis" class="col-sm-2 control-label">Jenis</label>
										<div class="col-sm-10">
		                                    <p class="form-control-static" id="jenis"> </p>
		                                </div>
									</div>
									<div class="form-group">
										<label for="objek" class="col-sm-2 control-label">Objek</label>
										<div class="col-sm-10">
		                                    <p class="form-control-static" id="objek"> </p>
		                                </div>
									</div>
									<div class="form-group">
										<label for="rincian" class="col-sm-2 control-label">Rincian Objek</label>
										<div class="col-sm-10">
		                                    <p class="form-control-static" id="rincian"> </p>
		                                </div>
									</div>
									<div class="form-group">
										<label for="subrincian" class="col-sm-2 control-label">Sub Rincian Objek</label>
										<div class="col-sm-10">
		                                    <p class="form-control-static" id="subrincian"> </p>
		                                </div>
									</div>

									<div id="tablechild" class="form-group table-responsive" >
										<label for="tablechild" class="col-sm-2 control-label">List Sub Sub Rincian Objek</label>
										<div class="col-sm-10 table-responsive" style="height: 300px; overflow-y: scroll;">
											<table class="table table-hover table-bordered" >
												<thead>
													<tr>
														<th>Kode</th>
														<th>Barang</th>
														<th>Deskripsi</th>
														<!-- <th>Kategori</th> -->
													</tr>
												</thead>
												<tbody id="bodychild">
													<tr>
														<td>-</td>
														<td>-</td>
														<td>-</td>
														<!-- <td>-</td> -->
													</tr>
												</tbody>
											</table>
										</div>
											
									</div>
									
									<div class="form-group m-t-20">
										<label for="kobar" class="col-sm-2 control-label">Rekomendasi Kode Barang</label>
										<div class="col-sm-4">
		                                    <input type="text" class="form-control" placeholder="" id="kobar" disabled="">
		                                </div>
									
										<label for="missingkobar" class="col-sm-2 control-label">Missing Kode Barang</label>
										<div class="col-sm-4">
		                                    <input type="text" class="form-control" placeholder="" id="missingkobar" disabled="" readonly>
		                                </div>
									</div>

									<div class="form-group">
										<label for="newkobar" class="col-sm-2 control-label">Kode Barang Baru</label>
										<div class="col-sm-10">
		                                    <input type="text" class="form-control" placeholder="Copy kode barang diatas" id="newkobar" required="" data-mask="9.9.9.99.99.99.999" name="newkobar" value="{{ old('newkobar') }}">
		                                </div>
									</div>

									<div class="form-group">
										<label for="nabar" class="col-sm-2 control-label">Nama Barang</label>
										<div class="col-sm-10">
		                                    <input type="text" class="form-control" placeholder="" id="nabar" required="" name="nabar" autocomplete="off" value="{{ old('nabar') }}">
		                                </div>
									</div>

									<div class="form-group">
										<label for="nabar" class="col-md-2 control-label">Deskripsi</label>
										<div class="col-md-10">
											<textarea name="desk" class="form-control" rows="3" id="desk">{{ old('desk') }}</textarea>
		                                </div>
									</div>

									<div class="form-group">
                                        <label for="img" class="col-md-2 control-label"> Gambar <br> 
                                        	<span style="font-size: 10px">Hanya berupa JPG, JPEG, dan PNG</span><br>
                                        	<span style="font-size: 10px">Maksimal 500KB</span>
                                        </label>
                                        <div class="col-md-10">
                                            <input type="file" class="form-control" id="img" name="img">
                                        </div>
                                    </div>

									<input type="hidden" name="formparent" id="formparent" value="">
									<input type="hidden" name="formkelompok" id="formkelompok" value="">
									<input type="hidden" name="formjenis" id="formjenis" value="">
									<input type="hidden" name="formobjek" id="formobjek" value="">
									<input type="hidden" name="formrincian" id="formrincian" value="">
									<input type="hidden" name="formsubrincian" id="formsubrincian" value="">
									<input type="hidden" name="level" id="level" value="">

									<div class="pull-right">
									<button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
									<a href="/{{ env('APP_NAME') }}/form/ubahkobar">
                                    	<button type="button" class="btn btn-inverse waves-effect waves-light">kembali</button>
									</div></a>
								</form>
                            </div>
                        </div>
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
	<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
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

			$("#tablechild").hide();
			// $("#tablechild table").removeClass("myTable");

			var datanow = $(".select2 option:selected").val();
			$("#newkobar").val('');
			const myArr = datanow.split("||");
			$("#formparent").val(myArr[0]);
			$("#kelompok").text(myArr[2]);
			$("#jenis").text(myArr[3]);
			$("#objek").text(myArr[4]);
			$("#rincian").text(myArr[5]);
			$("#subrincian").text(myArr[6]);
			var kode = myArr[7];
			var mykobar = myArr[0];
			$.ajax({ 
			method: "GET", 
			url: "/ekobar/form/getmaxnewkobar",
			data: { kode : kode, mykobar : mykobar },
			}).done(function( data ) { 
				$("#kobar").val(data['max']);
				$("#level").val(data['level']);
				$("#missingkobar").val(data['missing']);

				$("#bodychild").empty();

				if(data['child'].length){
					for (var i = 0; i < data['child'].length; i++) {
						var kobar = data['child'][i]['KOBAR'];
						var nabar = data['child'][i]['NABAR'];
						var desk = data['child'][i]['KOBAR_DESK'] ?? '-';
						var kelompok = data['child'][i]['KELOMPOK'] ?? '-';
						var jenis = data['child'][i]['JENIS'] ?? '-';
						var objek = data['child'][i]['OBJEK'] ?? '-';
						var rincian = data['child'][i]['RINCIAN_OBJEK'] ?? '-';
						var sub = data['child'][i]['SUB_RINCIAN_OBJEK'] ?? '-';

						$('#bodychild').append("<tr>"+
													"<td>"+kobar+"</td>"+
													"<td>"+nabar+"</td>"+
													"<td>"+desk+"</td>"+
													// "<td>"+kelompok+"<br>"+jenis+"<br>"+objek+"<br>"+rincian+"<br>"+sub+"</td>"+
												"</tr>");
					}
				} else {
					$('#bodychild').append("<tr>"+
												"<td>-</td>"+
												"<td>-</td>"+
												"<td>-</td>"+
											"</tr>");
				}

				$("#tablechild").show();
			}); 
			
			$('#parentid').on('change', function() {
				var data = $(".select2 option:selected").val();
				$("#newkobar").val('');

		      	const myArr = data.split("||");

		      	$("#formparent").val(myArr[0]);

		      	$("#kelompok").text(myArr[2]);
				$("#jenis").text(myArr[3]);
				$("#objek").text(myArr[4]);
				$("#rincian").text(myArr[5]);
				$("#subrincian").text(myArr[6]);

				$("#formkelompok").val(myArr[2]);
				$("#formjenis").val(myArr[3]);
				$("#formobjek").val(myArr[4]);
				$("#formrincian").val(myArr[5]);
				$("#formsubrincian").val(myArr[6]);

				var kode = myArr[7];
				var mykobar = myArr[0];

				$.ajax({ 
				method: "GET", 
				url: "/ekobar/form/getmaxnewkobar",
				data: { kode : kode, mykobar : mykobar },
				}).done(function( data ) { 
					$("#kobar").val(data['max']);
					$("#missingkobar").val(data['missing']);
					$("#level").val(data['level']);

					$("#bodychild").empty();

					if(data['child'].length){
						for (var i = 0; i < data['child'].length; i++) {
							var kobar = data['child'][i]['KOBAR'];
							var nabar = data['child'][i]['NABAR'];
							var desk = data['child'][i]['KOBAR_DESK'] ?? '-';
							var kelompok = data['child'][i]['KELOMPOK'] ?? '-';
							var jenis = data['child'][i]['JENIS'] ?? '-';
							var objek = data['child'][i]['OBJEK'] ?? '-';
							var rincian = data['child'][i]['RINCIAN_OBJEK'] ?? '-';
							var sub = data['child'][i]['SUB_RINCIAN_OBJEK'] ?? '-';
	
							$('#bodychild').append("<tr>"+
														"<td>"+kobar+"</td>"+
														"<td>"+nabar+"</td>"+
														"<td>"+desk+"</td>"+
														// "<td>"+kelompok+"<br>"+jenis+"<br>"+objek+"<br>"+rincian+"<br>"+sub+"</td>"+
													"</tr>");
						}
					} else {
						$('#bodychild').append("<tr>"+
													"<td>-</td>"+
													"<td>-</td>"+
													"<td>-</td>"+
												"</tr>");
					}

					$("#tablechild").show();
				});
		    })

			$('#myTable').DataTable({
				"oLanguage": {
					"sSearch": "Filter:"
				},
			});
		});
	</script>
@endsection

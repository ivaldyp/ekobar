@extends('layouts.masterhome')

@section('css')
	<!-- Bootstrap Core CSS -->
	<link href="/{{ env('APP_NAME') }}{{ ('/ample/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
	<!-- Menu CSS -->
	<link href="/{{ env('APP_NAME') }}{{ ('/ample/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css') }}" rel="stylesheet">
	<!-- animation CSS -->
	<link href="/{{ env('APP_NAME') }}{{ ('/ample/css/animate.css') }}" rel="stylesheet">
	<!-- Custom CSS -->
	<link href="/{{ env('APP_NAME') }}{{ ('/ample/css/style.css') }}" rel="stylesheet">
	<!-- color CSS -->
	<link href="/{{ env('APP_NAME') }}{{ ('/ample/css/colors/purple-dark.css') }}" id="theme" rel="stylesheet">
	<!-- Date picker plugins css -->
	<link href="/{{ env('APP_NAME') }}{{ ('/ample/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
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
						<li>{{config('app.name')}}</li>
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
				<div class="col-md-2"></div>
				<div class="col-md-8">
					<form class="form-horizontal" method="POST" action="/{{ env('APP_NAME') }}/kepegawaian/form/tambahpegawai" data-toggle="validator" enctype="multipart/form-data">
					@csrf
						<div class="panel panel-info">
							<div class="panel-heading"> Data Pegawai </div>
							<div class="panel-wrapper collapse in" aria-expanded="true">
								<div class="panel-body">
									<div class="sttabs tabs-style-underline">
										<nav>
											<ul>
												<li><a href="#section-underline-1" class="sticon ti-book"><span>Identitas</span></a></li>
												<li><a href="#section-underline-4" class="sticon ti-camera"><span>Jabatan</span></a></li>
											</ul>
										</nav>
										<div class="content-wrap">
											<section id="section-underline-1">
												<div class="form-group">
													<label for="tgl_join" class="col-md-2 control-label"> TMT </label>
													<div class="col-md-8">
														<input required type="text" name="tgl_join" class="form-control" id="datepicker-autoclose" autocomplete="off" placeholder="dd/mm/yyyy">
													</div>
												</div>

												<div class="form-group">
													<label for="status_emp" class="col-md-2 control-label"> Status Pegawai </label>
													<div class="col-md-8">
														<select class="form-control" name="status_emp" id="status_emp">
															@foreach($statuses as $status)
																<option value="{{ $status['status_emp'] }}"> {{ $status['status_emp'] }} </option>
															@endforeach
														</select>
													</div>
												</div>

												<div class="form-group">
													<label for="ked_emp" class="col-md-2 control-label"> Kedudukan Pegawai </label>
													<div class="col-md-8">
														<select class="form-control" name="ked_emp" id="ked_emp">
															@foreach($kedudukans as $kedudukan)
																<option value="{{ $kedudukan['ked_emp'] }}"> {{ $kedudukan['ked_emp'] }} </option>
															@endforeach
														</select>
													</div>
												</div>

												<div class="form-group">
													<label for="nip_emp" class="col-md-2 control-label"> NIP </label>
													<div class="col-md-8">
														<input autocomplete="off" type="text" name="nip_emp" class="form-control" id="nip_emp">
													</div>
												</div>

												<div class="form-group">
													<label for="nrk_emp" class="col-md-2 control-label"> NRK </label>
													<div class="col-md-8">
														<input autocomplete="off" type="text" name="nrk_emp" class="form-control" id="nrk_emp">
													</div>
												</div>
												
												<div class="form-group">
													<label for="nm_emp" class="col-md-2 control-label"> Nama </label>
													<div class="col-md-8">
														<input autocomplete="off" type="text" name="nm_emp" class="form-control" id="nm_emp" data-error="Masukkan nama">
														<div class="help-block with-errors"></div>
													</div>
												</div>

												<div class="form-group">
													<label for="gelar" class="col-md-2 control-label"> Gelar </label>
													<div class="col-md-4">
														<input autocomplete="off" type="text" name="gelar_dpn" class="form-control" id="gelar_dpn" placeholder="Depan">
													</div>
													<div class="col-md-4">
														<input autocomplete="off" type="text" name="gelar_blk" class="form-control" id="gelar_blk" placeholder="Belakang">
													</div>
												</div>

												<div class="form-group">
													<label class="col-md-2 control-label"> Jenis Kelamin </label>
													<div class="radio-list col-md-8">
														<label class="radio-inline">
															<div class="radio radio-info">
																<input type="radio" name="jnkel_emp" id="kel1" value="L" data-error="Pilih salah satu" required checked>
																<label for="kel1">Laki-laki</label> 
															</div>
														</label>
														<label class="radio-inline">
															<div class="radio radio-info">
																<input type="radio" name="jnkel_emp" id="kel2" value="P">
																<label for="kel2">Perempuan</label>
															</div>
														</label>
														<div class="help-block with-errors"></div>  
													</div>
												</div>

												<div class="form-group">
													<label class="col-md-2 control-label"> Tempat / Tgl Lahir </label>
													<div class="col-md-4">
														<input autocomplete="off" type="text" name="tempat_lahir" class="form-control" id="tempat_lahir" placeholder="Tempat">
													</div>
													<div class="col-md-4">
														<input autocomplete="off" type="text" name="tgl_lahir" class="form-control" id="datepicker-autoclose2" autocomplete="off" placeholder="dd/mm/yyyy">
													</div>
												</div>

												<div class="form-group">
													<label for="idagama" class="col-md-2 control-label"> Agama </label>
													<div class="col-md-8">
														<select class="form-control" name="idagama" id="idagama">
															<option value="A"> Islam </option>
															<option value="B"> Katolik </option>
															<option value="C"> Protestan </option>
															<option value="D"> Budha </option>
															<option value="E"> Hindu </option>
															<option value="F"> Lainnya </option>
															<option value="G"> Konghucu </option>
														</select>
													</div>
												</div>

												<div class="form-group">
													<label for="alamat_emp" class="col-md-2 control-label"> Alamat </label>
													<div class="col-md-8">
														<textarea name="alamat_emp" class="form-control" rows="3"></textarea>
													</div>
												</div>

												<div class="form-group">
													<label for="tlp_emp" class="col-md-2 control-label"> Telepon / HP </label>
													<div class="col-md-8">
														<input autocomplete="off" type="text" name="tlp_emp" class="form-control" id="tlp_emp">
													</div>
												</div>

												<div class="form-group">
													<label for="email_emp" class="col-md-2 control-label"> Email </label>
													<div class="col-md-8">
														<input autocomplete="off" type="email" name="email_emp" class="form-control" id="email_emp" data-error="Masukkan alamat email yang valid">
														<div class="help-block with-errors"></div>
													</div>
												</div>

												<div class="form-group">
													<label for="status_nikah" class="col-md-2 control-label"> Status Nikah </label>
													<div class="col-md-8">
														<select class="form-control" name="status_nikah" id="status_nikah">
															<option value="Belum Kawin"> Belum Kawin </option>
															<option value="Kawin"> Kawin </option>
															<option value="Cerai Hidup"> Cerai Hidup </option>
															<option value="Cerai Mati"> Cerai Mati </option>
														</select>
													</div>
												</div>

												<div class="form-group">
													<label for="gol_darah" class="col-md-2 control-label"> Golongan Darah </label>
													<div class="col-md-8">
														<select class="form-control" name="gol_darah" id="gol_darah">
															<option value="A"> A </option>
															<option value="B"> B </option>
															<option value="AB"> AB </option>
															<option value="O"> O </option>
														</select>
													</div>
												</div>

												<input type="hidden" name="idgroup" value="EMPLOYEE">

												<div class="form-group">
													<label for="passmd5" class="col-md-2 control-label"> Password </label>
													<div class="col-md-8">
														<input autocomplete="off" type="text" name="passmd5" class="form-control" id="passmd5" value="123456">
													</div>
												</div>

												<!-- <div class="form-group">
													<label for="filefoto" class="col-lg-2 control-label"> Upload Foto <br> <span style="font-size: 10px">Hanya berupa JPG, JPEG, dan PNG</span> </label>
													<div class="col-lg-4">
														<input type="file" class="form-control" id="filefoto" name="filefoto">
													</div>
												</div> -->

												<!-- <div class="form-group">
													<label for="filettd" class="col-lg-2 control-label"> Upload Tandatangan <br> <span style="font-size: 10px">Hanya berupa JPG, JPEG, dan PNG</span> </label>
													<div class="col-lg-4">
														<input type="file" class="form-control" id="filettd" name="filettd">
													</div>
												</div> -->
											</section>
											
											<section id="section-underline-4">

												<input type="hidden" name="iddik" value="NA">
												<input type="hidden" name="idgol" value="I/A">
												<input type="hidden" name="jns_kp" value="Reguler">
												<input type="hidden" name="jabatan" value="STRUKTURAL||Administrasi">
												<input type="hidden" name="idlok" value="01">

												<div class="form-group">
													<label for="idunit" class="col-md-2 control-label"> Unit Organisasi </label>
													<div class="col-md-8">
														<select class="form-control select2" name="idunit" id="idunit">
															@foreach($units as $unit)
																<option value="{{ $unit['kd_unit'] }}"> {{ $unit['kd_unit'] }} - {{ $unit['notes'] }}</option>
															@endforeach
														</select>
													</div>
												</div>

												<div class="form-group">
													<label for="eselon" class="col-md-2 control-label"> Golongan </label>
													<div class="col-md-8">
														<select class="form-control select2" name="eselon" id="eselon">
															@foreach($golongans as $golongan)
																<option value="{{ $golongan['gol'] }}"> {{ $golongan['gol'] }} - {{ $golongan['nm_pangkat'] }} </option>
															@endforeach
														</select>
													</div>
												</div>

												<div class="form-group">
													<label class="col-md-2 control-label"> TMT Jabatan </label>
													<div class="col-md-8">
														<input type="text" name="tmt_jab" class="form-control" id="datepicker-autoclose5" autocomplete="off" placeholder="dd/mm/yyyy" required>
													</div>
												</div>

												<div class="form-group">
													<label for="no_sk_jab" class="col-md-2 control-label"> No SK Jabatan </label>
													<div class="col-md-8">
														<input autocomplete="off" type="text" name="no_sk_jab" class="form-control" id="no_sk_jab">
													</div>
												</div>

												<div class="form-group">
													<label class="col-md-2 control-label"> Tanggal SK </label>
													<div class="col-md-8">
														<input type="text" name="tmt_sk_jab" class="form-control" id="datepicker-autoclose6" autocomplete="off" placeholder="dd/mm/yyyy">
													</div>
												</div>

												<!-- <div class="form-group">
													<label for="fileskjab" class="col-lg-2 control-label"> Upload SK <br> <span style="font-size: 10px">Hanya berupa JPG, JPEG, dan PNG</span> </label>
													<div class="col-lg-4">
														<input type="file" class="form-control" id="fileskjab" name="fileskjab">
													</div>
												</div> -->
												<button type="submit" class="btn btn-success pull-right"> Simpan </button>
												<!-- <button type="submit" class="btn btn-default pull-right m-r-10"> Kembali </button> -->
												<button type="button" class="btn btn-default pull-right m-r-10" onclick="goBack()">Kembali</button>
											</section>
										</div>
									</div>
								</div>
							</div>
							<div class="panel-heading">  
								
							</div>
						</div>
	
						<div class="panel panel-info">
							
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection

<!-- /////////////////////////////////////////////////////////////// -->

@section('js')
	<script src="/{{ env('APP_NAME') }}{{ ('/ample/plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
	<!-- Bootstrap Core JavaScript -->
	<script src="/{{ env('APP_NAME') }}{{ ('/ample/bootstrap/dist/js/bootstrap.min.js') }}"></script>
	<!-- Menu Plugin JavaScript -->
	<script src="/{{ env('APP_NAME') }}{{ ('/ample/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js') }}"></script>
	<!--slimscroll JavaScript -->
	<script src="/{{ env('APP_NAME') }}{{ ('/ample/js/jquery.slimscroll.js') }}"></script>
	<!--Wave Effects -->
	<script src="/{{ env('APP_NAME') }}{{ ('/ample/js/waves.js') }}"></script>
	<!-- Custom Theme JavaScript -->
	<script src="/{{ env('APP_NAME') }}{{ ('/ample/js/cbpFWTabs.js') }}"></script>
	<script type="text/javascript">
		(function () {
				[].slice.call(document.querySelectorAll('.sttabs')).forEach(function (el) {
				new CBPFWTabs(el);
			});
		})();
	</script>
	<script src="/{{ env('APP_NAME') }}{{ ('/ample/js/custom.min.js') }}"></script>
	<script src="/{{ env('APP_NAME') }}{{ ('/ample/js/validator.js') }}"></script>
	<script src="/{{ env('APP_NAME') }}{{ ('/ample/plugins/bower_components/custom-select/custom-select.min.js') }}" type="text/javascript"></script>
	<!-- Date Picker Plugin JavaScript -->
	<script src="/{{ env('APP_NAME') }}{{ ('/ample/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
	<script>

		function goBack() {
		  window.history.back();
		}

		$(".select2").select2();

		(function($) {
		  $.fn.inputFilter = function(inputFilter) {
			return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
			  if (inputFilter(this.value)) {
				this.oldValue = this.value;
				this.oldSelectionStart = this.selectionStart;
				this.oldSelectionEnd = this.selectionEnd;
			  } else if (this.hasOwnProperty("oldValue")) {
				this.value = this.oldValue;
				this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
			  } else {
				this.value = "";
			  }
			});
		  };
		}(jQuery));

		$(".intLimitTextBox").inputFilter(function(value) {
			return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 99); 
		});

		jQuery('#datepicker-autoclose').datepicker({
			autoclose: true
			, todayHighlight: true
			, format: 'dd/mm/yyyy'
		});

		jQuery('#datepicker-autoclose2').datepicker({
			autoclose: true
			, todayHighlight: false
			, format: 'dd/mm/yyyy'
		});

		jQuery('#datepicker-autoclose3').datepicker({
			autoclose: true
			, todayHighlight: false
			, format: 'dd/mm/yyyy'
		});

		jQuery('#datepicker-autoclose4').datepicker({
			autoclose: true
			, todayHighlight: false
			, format: 'dd/mm/yyyy'
		});

		jQuery('#datepicker-autoclose5').datepicker({
			autoclose: true
			, todayHighlight: false
			, format: 'dd/mm/yyyy'
		});

		jQuery('#datepicker-autoclose6').datepicker({
			autoclose: true
			, todayHighlight: false
			, format: 'dd/mm/yyyy'
		});
	</script>

	
@endsection
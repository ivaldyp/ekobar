<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Traits\SessionCheckTraits;

use App\Emp_data;
use App\Emp_dik;
use App\Emp_gol;
use App\Emp_jab;
use App\Fr_disposisi;
use App\Glo_dik;
use App\Glo_disposisi_kode;
use App\Glo_disposisi_penanganan;
use App\Glo_org_golongan;
use App\Glo_org_jabatan;
use App\Glo_org_kedemp;
use App\Glo_org_lokasi;
use App\Glo_org_statusemp;
use App\glo_org_unitkerja;
use App\Sec_access;
use App\Sec_menu;

session_start();

class ProfilController extends Controller
{
	use SessionCheckTraits;

	public function __construct()
	{
		$this->middleware('auth');
	}

	public function pegawai(Request $request)
	{
		$this->checkSessionTime();
		$currentpath = str_replace("%20", " ", $_SERVER['REQUEST_URI']);
		$currentpath = explode("?", $currentpath)[0];
		$currentpath = explode(env('APP_NAME'), $currentpath)[1];
		$thismenu = Sec_menu::where('urlnew', $currentpath)->first('ids');
		$access = $this->checkAccess($_SESSION['kobar_data']['idgroup'], $thismenu['ids']);


		$accessid = $this->checkAccess($_SESSION['kobar_data']['idgroup'], 37);
		$accessdik = $this->checkAccess($_SESSION['kobar_data']['idgroup'], 65);
		$accessgol = $this->checkAccess($_SESSION['kobar_data']['idgroup'], 71);
		$accessjab = $this->checkAccess($_SESSION['kobar_data']['idgroup'], 72);

		$emp_data = Emp_data::
						where('id_emp', Auth::user()->id_emp)
						->where('sts', 1)
						->get();

		$emp_dik = Emp_dik::with('dik')
						->where('noid', Auth::user()->id_emp)
						->where('sts', 1)
						->get();

		$emp_gol = Emp_gol::with('gol')
						->where('noid', Auth::user()->id_emp)
						->where('sts', 1)
						->get();

		$emp_jab = Emp_jab::with('jabatan')
						->with('lokasi')
						->with('unit')
						->where('noid', Auth::user()->id_emp)
						->where('sts', 1)
						->get();

		$statuses = Glo_org_statusemp::get();
		$pendidikans = Glo_dik::
						orderBy('urut')
						->get();

		return view('pages.kobarprofil.pegawai')
				->with('id_emp', Auth::user()->id_emp)
				->with('emp_data', $emp_data[0])
				->with('emp_dik', $emp_dik)
				->with('emp_gol', $emp_gol)
				->with('emp_jab', $emp_jab)
				->with('access', $access)
				->with('accessid', $accessid)
				->with('accessdik', $accessdik)
				->with('accessgol', $accessgol)
				->with('accessjab', $accessjab)
				->with('statuses', $statuses)
				->with('pendidikans', $pendidikans);	
	}

	public function formupdateidpegawai(Request $request)
	{
		$this->checkSessionTime();

		$id_emp = $request->id_emp;
		$filefoto = '';

		// (IDENTITAS) cek dan set variabel untuk file foto pegawai
		if (isset($request->filefoto)) {
			$file = $request->filefoto;

			if ($file->getSize() > 2222222) {
				return redirect('/profil/pegawai')->with('message', 'Ukuran file foto pegawai terlalu besar (Maksimal 2MB)');     
			} 

			$filefoto .= $id_emp . ".". $file->getClientOriginalExtension();

			$tujuan_upload = config('app.savefileimg');
			$file->move($tujuan_upload, $filefoto);
		}
			
		if (!(isset($filefoto))) {
			$filefoto = '';
		}

		if (isset($request->tgl_join)) {
			$tgl_join = date('Y-m-d',strtotime($request->tgl_join));
		} else {
			$tgl_join = '';
		}

		if (isset($request->tgl_lahir)) {
			$tgl_lahir = date('Y-m-d',strtotime($request->tgl_lahir));
		} else {
			$tgl_lahir = '';
		}

		Emp_data::where('id_emp', $id_emp)
			->update([
				'tgl_join' => (isset($request->tgl_join) ? date('Y-m-d',strtotime(str_replace('/', '-', $request->tgl_join))) : null),
				'status_emp' => $request->status_emp,
				'nrk_emp' => ($request->nrk_emp ? $request->nrk_emp : ''),
				'nm_emp' => ($request->nm_emp ? $request->nm_emp : ''),
				'gelar_dpn' => ($request->gelar_dpn ? $request->gelar_dpn : ''),
				'gelar_blk' => ($request->gelar_blk ? $request->gelar_blk : ''),
				'jnkel_emp' => $request->jnkel_emp,
				'tempat_lahir' => ($request->tempat_lahir ? $request->tempat_lahir : ''),
				'tgl_lahir' => (isset($request->tgl_lahir) ? date('Y-m-d',strtotime(str_replace('/', '-', $request->tgl_lahir))) : null),
				'idagama' => $request->idagama,
				'alamat_emp' => ($request->alamat_emp ? $request->alamat_emp : ''),
				'tlp_emp' => ($request->tlp_emp ? $request->tlp_emp : ''),
				'email_emp' => ($request->email_emp ? $request->email_emp : ''),
				'status_nikah' => $request->status_nikah,
				'gol_darah' => $request->gol_darah,
				'nm_bank' => ($request->nm_bank ? $request->nm_bank : ''),
				'cb_bank' => ($request->cb_bank ? $request->cb_bank : ''),
				'an_bank' => ($request->an_bank ? $request->an_bank : ''),
				'nr_bank' => ($request->nr_bank ? $request->nr_bank : ''),
				'no_taspen' => ($request->no_taspen ? $request->no_taspen : ''),
				'npwp' => ($request->npwp ? $request->npwp : ''),
				'no_askes' => ($request->no_askes ? $request->no_askes : ''),
				'no_jamsos' => ($request->no_jamsos ? $request->no_jamsos : ''),
			]);

		if ($filefoto != '') {
			Emp_data::where('id_emp', $id_emp)
			->update([
				'tampilnew' => 1,
				'foto' => $filefoto,
			]);
		}

		return redirect('/profil/pegawai')
					->with('message', 'Pegawai '.$request->nm_emp.' berhasil diubah. Apabila terdapat kesalahan data, mohon melakukan login ulang')
					->with('msg_num', 1);
	}

	public function forminsertdikpegawai (Request $request)
	{
		$this->checkSessionTime();

		$id_emp = $_SESSION['kobar_data']['id_emp'];
		$fileijazah = '';

		// (PENDIDIKAN) cek dan set variabel untuk file foto ijazah
		if (isset($request->fileijazah)) {
			$file = $request->fileijazah;

			if ($file->getSize() > 2222222) {
				return redirect('/profil/pegawai')->with('message', 'Ukuran file foto ijazah terlalu besar (Maksimal 2MB)');     
			} 

			$fileijazah .= "dik_" . $request->iddik . "_" . $id_emp . ".". $file->getClientOriginalExtension();

			$tujuan_upload = config('app.savefileimg');
			$tujuan_upload .= "/" . $id_emp;

			$file->move($tujuan_upload, $fileijazah);
		}
			
		if (!(isset($fileijazah))) {
			$fileijazah = '';
		}

		$insert_emp_dik = [
				// PENDIDIKAN
				'sts' => 1,
				'uname'     => (Auth::user()->usname ? Auth::user()->usname : Auth::user()->id_emp),
				'tgl'       => date('Y-m-d H:i:s'),
				'ip'        => '',
				'logbuat'   => '',
				'noid' => $id_emp,
				'iddik' => $request->iddik,
				'prog_sek' => ($request->prog_sek ? $request->prog_sek : ''),
				'nm_sek' => ($request->nm_sek ? $request->nm_sek : ''),
				'no_sek' => ($request->no_sek ? $request->no_sek : ''),
				'th_sek' => ($request->th_sek ? $request->th_sek : ''),
				'gelar_dpn_sek' => ($request->gelar_dpn_sek ? $request->gelar_dpn_sek : ''),
				'gelar_blk_sek' => ($request->gelar_blk_sek ? $request->gelar_blk_sek : ''),
				'ijz_cpns' => $request->ijz_cpns,
				'gambar' => $fileijazah,
				'tampilnew' => 1,
			];

		Emp_dik::insert($insert_emp_dik);

		return redirect('/profil/pegawai')
					->with('message', 'Data pendidikan pegawai berhasil ditambah')
					->with('msg_num', 1);
	}

	public function formupdatedikpegawai (Request $request)
	{
		$this->checkSessionTime();

		$id_emp = $_SESSION['kobar_data']['id_emp'];
		$fileijazah = '';

		$nm_ijazah = Emp_dik::where('ids', $request->ids)->first();

		// (PENDIDIKAN) cek dan set variabel untuk file foto ijazah
		if (isset($request->fileijazah)) {
			$file = $request->fileijazah;

			if ($file->getSize() > 2222222) {
				return redirect('/profil/pegawai')->with('message', 'Ukuran file foto ijazah terlalu besar (Maksimal 2MB)')->with('msg_num', 2);     
			} 

			$fileijazah .= "dik_" . $request->iddik . "_" . $id_emp . ".". $file->getClientOriginalExtension();

			$tujuan_upload = config('app.savefileimg');
			$tujuan_upload .= "/" . $id_emp;
			if ($request->fileijazah) {
				$filepath = $tujuan_upload . "/" . $nm_ijazah['gambar'];
				unlink($filepath);
			}


			$file->move($tujuan_upload, $fileijazah);
		}
			
		if (!(isset($fileijazah))) {
			$fileijazah = '';
		}

		Emp_dik::where('noid', $id_emp)
			->where('ids', $request->ids)
			->update([
				'iddik' => $request->iddik,
				'prog_sek' => ($request->prog_sek ? $request->prog_sek : ''),
				'nm_sek' => ($request->nm_sek ? $request->nm_sek : ''),
				'no_sek' => ($request->no_sek ? $request->no_sek : ''),
				'th_sek' => ($request->th_sek ? $request->th_sek : ''),
				'gelar_dpn_sek' => ($request->gelar_dpn_sek ? $request->gelar_dpn_sek : ''),
				'gelar_blk_sek' => ($request->gelar_blk_sek ? $request->gelar_blk_sek : ''),
				'ijz_cpns' => $request->ijz_cpns,
				'gambar' => $fileijazah,
			]);

		if ($fileijazah != '') {
			Emp_dik::where('noid', $id_emp)
			->where('ids', $request->ids)
			->update([
				'tampilnew' => 1,
				'gambar' => $fileijazah,
			]);
		}

		return redirect('/profil/pegawai')
					->with('message', 'Data pendidikan pegawai berhasil diubah')
					->with('msg_num', 1);
	}

	public function formdeletedikpegawai(Request $request)
	{
		$this->checkSessionTime();

		$id_emp = $_SESSION['kobar_data']['id_emp'];

		Emp_dik::where('noid', $id_emp)
		->where('ids', $request->ids)
		->update([
			'sts' => 0,
		]);

		return redirect('/profil/pegawai')
					->with('message', 'Data pendidikan pegawai berhasil dihapus')
					->with('msg_num', 1);
	}
}

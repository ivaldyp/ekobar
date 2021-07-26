<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Nabar;
use App\Nakom;

session_start();

class FormController extends Controller
{
	public function __construct()
	{
		$this->db = config('app.DB1');
		$this->tabelnabar =  $this->db . ".dbo." . config('app.DB_TABEL2');
	}

	public function getmaxnewkobar(Request $request)
	{
		$kobar = $request->kode;
		$kobarclean = str_replace(".", "", $kobar);
		$arr = [];

		if ($kobar == '1.0') {
			$max = Nabar::
					where('KOBAR', 'LIKE', '1_%')
					->where('KOBAR', 'LIKE', '%0000000000')
					->max('KOBAR');
			$level = 0;
		} else {
			if (substr_count($kobar, ".") == 1) {
				$max = Nabar::
						where('KOBAR', 'LIKE', $kobarclean.'_%')
						->where('KOBAR', 'LIKE', '%000000000')
						->max('KOBAR');
				$level = 1;
			} elseif (substr_count($kobar, ".") == 2) {
				$max = Nabar::
						where('KOBAR', 'LIKE', $kobarclean.'__%')
						->where('KOBAR', 'LIKE', '%0000000')
						->max('KOBAR');
				$level = 2;
			} elseif (substr_count($kobar, ".") == 3) {
				$max = Nabar::
						where('KOBAR', 'LIKE', $kobarclean.'__%')
						->where('KOBAR', 'LIKE', '%00000')
						->max('KOBAR');
				$level = 3;
			} elseif (substr_count($kobar, ".") == 4) {
				$max = Nabar::
						where('KOBAR', 'LIKE', $kobarclean.'__%')
						->where('KOBAR', 'LIKE', '%000')
						->max('KOBAR');
				$level = 4;
			} elseif (substr_count($kobar, ".") == 5) {
				$max = Nabar::
						where('KOBAR', 'LIKE', $kobarclean.'___%')
						->max('KOBAR');
				$level = 5;
			}
		}

		$arr['max'] = $max;
		$arr['level'] = $level;

		return $arr;
	}

	public function pagetambahkobar(Request $request)
	{
		$kobars = Nabar::
					where('KOBAR', 'like', '%000')
					->OrderBy('KOBAR')->get(['KOBAR','NABAR','KELOMPOK','JENIS','OBJEK','RINCIAN_OBJEK','SUB_RINCIAN_OBJEK','KOBAR_KODE']);

		return view('pages.kobarform.tambahkobar')
			->with('kobars', $kobars);
	}

	public function pagekodekomponen(Request $request)
	{
		if ($request->nabar) {
			$nabarcari = $request->nabar;
			$kobars = Nabar::
						where('NABAR', 'LIKE', '%'.$nabarcari.'%')
						->OrderBy('KOBAR')
						->get();
		} else {
			$nabarcari = NULL;
			$kobars = NULL;
		}
		
		if ($request->nakom) {
			$nakomcari = $request->nakom;
			$komponens = Nakom::
						where('KOMPONEN_NAMA', 'LIKE', '%'.$nakomcari.'%')
						->OrderBy('KOBAR_PERMENDAGRI')
						->OrderBy('KOMPONEN_KODE')
						->get();
		} else {
			$nakomcari = NULL;
			$komponens = NULL;
		}

		return view('pages.kobarform.kodekomponen')
			->with('kobars', $kobars)
			->with('komponens', $komponens)
			->with('nabar', $nabarcari)
			->with('nakom', $nakomcari);
	}

	public function forminsertkobar(Request $request)
	{
		$kobar = $request->newkobar;
		$kobarclean = str_replace(".", "", $kobar);

		$formkelompok = $request->formkelompok;
		$formjenis = $request->formjenis;
		$formobjek = $request->formobjek;
		$formrincian_objek = $request->formrincian_objek;
		$formsub_rincian_objek = $request->formsub_rincian_objek;

		$cek = Nabar::where('KOBAR', 'like', $kobarclean)->first();
		if ($cek) {
			return redirect()->back()->with('message', 'Kode Barang sudah ada');
		}

		$parent = Nabar::where('KOBAR', 'like', $request->formparent)->first();

		if (substr($kobar, 4) == "0") {
			$kobarcut = substr($kobar, 0, 3);
			$nabar = strtoupper($request->nabar); 
		} elseif (substr($kobar, 6, 2) == "00") {
			$kobarcut = substr($kobar, 0, 5);
			$nabar = strtoupper($request->nabar); 
		} elseif (substr($kobar, 9, 2) == "00") {
			$kobarcut = substr($kobar, 0, 8);
			$nabar = strtoupper($request->nabar); 
		} elseif (substr($kobar, 12, 2) == "00") {
			$kobarcut = substr($kobar, 0, 11);
			$nabar = strtoupper($request->nabar); 
		} elseif (substr($kobar, 15, 3) == "000") {
			$kobarcut = substr($kobar, 0, 14);
			$nabar = strtoupper($request->nabar); 
		} else {
			$kobarcut = $kobar;
			$nabar = ucwords(strtolower($request->nabar)); 
		}

		$insert = [
				'KOBAR'       		=> $kobarclean,
				'KOBAR_PANJANG'     => $kobar,
				'KOBAR_KODE'       	=> $kobarcut,
				'NABAR'        		=> $nabar,
				'KATEGORI'   		=> $formkelompok ?? NULL,
				'SUBKATEGORI'     	=> $formjenis ?? NULL,
				'NAMA_KIB108'   	=> $formkelompok . " - " . $formjenis,
				'KELOMPOK'   		=> $parent['KELOMPOK'],
				'JENIS'  			=> $parent['JENIS'],
				'OBJEK' 			=> $parent['OBJEK'],
				'RINCIAN_OBJEK' 	=> $parent['RINCIAN_OBJEK'],
				'SUB_RINCIAN_OBJEK' => $parent['SUB_RINCIAN_OBJEK'],
				'kobar1' => $parent['kobar1'],
				'kobar2' => $parent['kobar2'],
				'kobar3' => $parent['kobar3'],
				'kobar4' => $parent['kobar4'],
				'kobar5' => $parent['kobar5'],
				'create_date' => date('Y-m-d H:i:s'),
				'update_date' => date('Y-m-d H:i:s'),
			];
		Nabar::insert($insert);

		if (substr($kobar, 4) == "0") {
			Nabar::
			where('KOBAR', $kobarclean)
			->update([
				'KATEGORI'			=> $nabar,
				'kobar2'      		=> $kobarcut,
				'JENIS' 			=> $nabar,
				'update_date' 		=> date('Y-m-d H:i:s'),
			]);
		} elseif (substr($kobar, 6, 2) == "00") {
			Nabar::
			where('KOBAR', $kobarclean)
			->update([
				'SUBKATEGORI'		=> $nabar,
				'NAMA_KIB108'		=> $formkelompok . " - " . $nabar,
				'kobar2'      		=> $kobarcut,
				'JENIS' 			=> $nabar,
				'update_date' 		=> date('Y-m-d H:i:s'),
			]);
		} elseif (substr($kobar, 9, 2) == "00") {
			Nabar::
			where('KOBAR', $kobarclean)
			->update([
				'kobar3'      		=> $kobarcut,
				'OBJEK' 			=> $nabar,
				'update_date' 		=> date('Y-m-d H:i:s'),
			]);
		} elseif (substr($kobar, 12, 2) == "00") {
			Nabar::
			where('KOBAR', $kobarclean)
			->update([
				'kobar4'      		=> $kobarcut,
				'RINCIAN_OBJEK' 	=> $nabar,
				'update_date' 		=> date('Y-m-d H:i:s'),
			]);
		} elseif (substr($kobar, 15, 3) == "000") {
			Nabar::
			where('KOBAR', $kobarclean)
			->update([
				'kobar5'      		=> $kobarcut,
				'SUB_RINCIAN_OBJEK' => $nabar,
				'update_date' 		=> date('Y-m-d H:i:s'),
			]);
		} else {
			$kobarcut = $kobar;
			$nabar = ucwords(strtolower($request->nabar)); 
		}

		return redirect('/home')
					->with('message', 'Kode Barang '.$request->nabar.' berhasil ditambah')
					->with('msg_num', 1);
	}

	public function formupdatekomponen(Request $request)
	{
		$komponen = $request->komponen_kode;
		$kobar = $request->newkobar;
		$kobarclean = str_replace(".", "", $kobar);

		$databar = Nabar::
					where('KOBAR', '=', $kobarclean)
					->first();

		if (is_null($databar)) {
			return redirect()->back()->with('message', 'Kode Barang tidak ditemukan');
		}	

		Nakom::
			where('KOMPONEN_KODE', $komponen)
			->update([
				'KOBAR_PERMENDAGRI'		=> $databar['KOBAR'],
				'NABAR_PERMENDAGRI'		=> $databar['NABAR'],
			]);

		return redirect()->back()
					->with('message', 'Kode komponen '.$request->nabar.' berhasil ditambah')
					->with('msg_num', 1);
	}

}

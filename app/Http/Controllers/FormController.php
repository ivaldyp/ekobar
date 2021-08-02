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
					->where('sts', 1)
					->OrderBy('KOBAR')->get(['KOBAR','NABAR','KELOMPOK','JENIS','OBJEK','RINCIAN_OBJEK','SUB_RINCIAN_OBJEK','KOBAR_KODE']);

		return view('pages.kobarform.tambahkobar')
			->with('kobars', $kobars);
	}

	public function pageubahkobar(Request $request)
	{
		// if ($request->krit) {
		// 	$krit = $request->krit;
		// } else {
		// 	$krit = NULL;
		// }

		if ($request->nabar) {
			$nabarcari = $request->nabar;
			$kobars = Nabar::
						where(function($q) use ($nabarcari) {
						$q->where('NABAR', 'like', '%'.$nabarcari.'%')
	                   	  ->orWhere('KOBAR', 'like', '%'.$nabarcari.'%');
			            })
						->where('sts', 1)
						->OrderBy('KOBAR')
						->get();
		} else {
			$nabarcari = NULL;
			$kobars = NULL;
		}

		return view('pages.kobarform.ubahkobar')
			->with('nabar', $nabarcari)
			// ->with('krit', $krit)
			->with('kobars', $kobars);
	}

	public function pagekodekomponen(Request $request)
	{
		if ($request->nabar) {
			$nabarcari = $request->nabar;
			$kobars = Nabar::
						where(function($q) use ($nabarcari) {
						$q->where('NABAR', 'like', '%'.$nabarcari.'%')
	                   	  ->orWhere('KOBAR', 'like', '%'.$nabarcari.'%');
			            })
						->where('sts', 1)
						->OrderBy('KOBAR')
						->get();
		} else {
			$nabarcari = NULL;
			$kobars = NULL;
		}

		// if (isset($request->btnSubmit) || $request->btnKomp == "submit") {
		// 	$button = "submit";
		// } elseif (isset($request->btnKosong) || $request->btnKomp == "kosong") {
		// 	$button = "kosong";
		// } else {
		// 	$button = NULL;
		// }
		
		if (isset($request->btnKosong) || is_null($request->nakom)) {
			$nakomcari = NULL;
			$komponens = Nakom::
						whereNull('KOBAR_PERMENDAGRI')
						->orWhere('KOBAR_PERMENDAGRI', '=', '')
						->orWhere('KOBAR_PERMENDAGRI', '=', '-')
						->OrderBy('KOBAR_PERMENDAGRI')
						->OrderBy('KOMPONEN_KODE')
						->get();
		// } elseif (is_null($request->nakom)) {
		// 	$nakomcari = NULL;
		// 	$komponens = NULL;
		} elseif (!(is_null($request->nakom)) || isset($request->btnSubmit)) {
			$nakomcari = $request->nakom;
			$komponens = Nakom::
						where(function($q) use ($nakomcari) {
						$q->where('KOMPONEN_NAMA', 'like', '%'.$nakomcari.'%')
	                   	  ->orWhere('KOMPONEN_KODE', 'like', '%'.$nakomcari.'%');
			            })
						->OrderBy('KOBAR_PERMENDAGRI')
						->OrderBy('KOMPONEN_KODE')
						->get();
		} 

		

		return view('pages.kobarform.kodekomponen')
			->with('kobars', $kobars)
			->with('komponens', $komponens)
			->with('nabar', $nabarcari)
			->with('nakom', $nakomcari);
			// ->with('button', $button);
	}

	public function forminsertkobar(Request $request)
	{
		$kobar = $request->newkobar;
		$kobarclean = str_replace(".", "", $kobar);

		if (is_null($request->formparent) || $request->formparent == 'type') {
			if (substr($kobar, 4) == "0") {
				$formparent = str_replace(".", "", substr($kobar, 0, 1));
				$formparent = str_pad($formparent, 12, '0', STR_PAD_RIGHT);
			} elseif (substr($kobar, 6, 2) == "00") {
				$formparent = str_replace(".", "", substr($kobar, 0, 3));
				$formparent = str_pad($formparent, 12, '0', STR_PAD_RIGHT); 
			} elseif (substr($kobar, 9, 2) == "00") {
				$formparent = str_replace(".", "", substr($kobar, 0, 5));
				$formparent = str_pad($formparent, 12, '0', STR_PAD_RIGHT);
			} elseif (substr($kobar, 12, 2) == "00") {
				$formparent = str_replace(".", "", substr($kobar, 0, 8));
				$formparent = str_pad($formparent, 12, '0', STR_PAD_RIGHT); 
			} elseif (substr($kobar, 15, 3) == "000") {
				$formparent = str_replace(".", "", substr($kobar, 0, 11));
				$formparent = str_pad($formparent, 12, '0', STR_PAD_RIGHT);  
			} else {
				$formparent = str_replace(".", "", substr($kobar, 0, 14));
				$formparent = str_pad($formparent, 12, '0', STR_PAD_RIGHT); 
			}
		} else {
			$formparent = $request->formparent;
		}

		$cekkode = Nabar::
				where('KOBAR', 'like', $kobarclean)
				->where('sts', 1)
				->first();
		if ($cekkode) {
			return redirect()->back()->with('message', 'Kode Barang '.$kobarclean.' sudah ada');
		}

		$ceknama = Nabar::
				where('NABAR', 'like', '%'.$request->nabar.'%')
				->where('sts', 1)
				->first();
		if ($ceknama) {
			return redirect()->back()->with('message', 'Nama Barang '.$request->nabar.' sudah ada');
		}

		$filekobar = '';

		if (isset($request->img)) {
			$file = $request->img;

			if ($file->getSize() > 600000) {
				return redirect()->back()->with('message', 'Ukuran file terlalu besar (Maksimal 500KB)');     
			} 

			if (strtolower($file->getClientOriginalExtension()) != "png" && strtolower($file->getClientOriginalExtension()) != "jpg" && strtolower($file->getClientOriginalExtension()) != "jpeg") {
				return redirect()->back()->with('message', 'File yang diunggah harus berbentuk JPG / JPEG / PNG');     
			}

			$filekobar .= "KOBAR_" . $kobarclean . "." . $file->getClientOriginalExtension();

			$tujuan_upload = config('app.savefileimgkobar');
			$tujuan_upload .= "\\" . $kobarclean . "\\";

			if (file_exists($tujuan_upload . $filekobar )) {
				unlink($tujuan_upload . $filekobar);
			}

			$file->move($tujuan_upload, $filekobar);
		}
			
		if ($filekobar == '') {
			$filekobar = NULL;
		}

		$parent = Nabar::where('KOBAR', 'like', $formparent)->first();


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
				'KATEGORI'   		=> $parent['KELOMPOK'] ?? NULL,
				'SUBKATEGORI'     	=> $parent['JENIS'] ?? NULL,
				'NAMA_KIB108'   	=> $parent['KELOMPOK'] . " - " . $parent['JENIS'],
				'KELOMPOK'   		=> $parent['KELOMPOK'] ?? NULL,
				'JENIS'  			=> $parent['JENIS'] ?? NULL,
				'OBJEK' 			=> $parent['OBJEK'] ?? NULL,
				'RINCIAN_OBJEK' 	=> $parent['RINCIAN_OBJEK'] ?? NULL,
				'SUB_RINCIAN_OBJEK' => $parent['SUB_RINCIAN_OBJEK'] ?? NULL,
				'kobar1' => $parent['kobar1'],
				'kobar2' => $parent['kobar2'],
				'kobar3' => $parent['kobar3'],
				'kobar4' => $parent['kobar4'],
				'kobar5' => $parent['kobar5'],
				'create_date' => date('Y-m-d H:i:s'),
				'update_date' => date('Y-m-d H:i:s'),
				'KOBAR_DESK' 	=> $request->desk ?? NULL,
				'KOBAR_IMG' 	=> $filekobar ?? NULL,
				'sts' => 1,
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
				'NAMA_KIB108'		=> $parent['KELOMPOK'] . " - " . $nabar,
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
		} 

		return redirect('/form/ubahkobar')
					->with('message', 'Kode Barang '.$kobar.' dengan nama '. $nabar .' berhasil ditambah')
					->with('msg_num', 1);
	}

	public function formupdatekobar(Request $request)
	{
		$kobar = $request->kobar;
		$nabar = $request->nabar;

		if (substr($kobar, 1, 1) == '.') {
			$kobarclean = str_replace(".", "", $kobar);
			$kobardot = $kobar;
		} else {
			$kobarclean = $kobar;
			$a = substr($kobar, 0, 1);
			$b = substr($kobar, 1, 1);
			$c = substr($kobar, 2, 1);
			$d = substr($kobar, 3, 2);
			$e = substr($kobar, 5, 2);
			$f = substr($kobar, 7, 2);
			$g = substr($kobar, 9, 3);
			$kobardot = $a . "." . $b . "." . $c . "." . $d . "." . $e . "." . $f . "." . $g; 
		}

		$filekobar = '';

		if (isset($request->img)) {
			$file = $request->img;

			if ($file->getSize() > 600000) {
				return redirect()->back()->with('message', 'Ukuran file terlalu besar (Maksimal 500KB)');     
			} 

			if (strtolower($file->getClientOriginalExtension()) != "png" && strtolower($file->getClientOriginalExtension()) != "jpg" && strtolower($file->getClientOriginalExtension()) != "jpeg") {
				return redirect()->back()->with('message', 'File yang diunggah harus berbentuk JPG / JPEG / PNG');     
			}

			$filekobar .= "KOBAR_" . $kobarclean . "." . $file->getClientOriginalExtension();

			$tujuan_upload = config('app.savefileimgkobar');
			$tujuan_upload .= "\\" . $kobarclean . "\\";

			if (file_exists($tujuan_upload . $filekobar )) {
				unlink($tujuan_upload . $filekobar);
			}

			$file->move($tujuan_upload, $filekobar);
		}
			
		if ($filekobar != '') {
			Nabar::where('KOBAR', $kobarclean)
				->update([
					'KOBAR_IMG' 	=> $filekobar ?? NULL,
				]);
		}

		Nabar::
		where('KOBAR', $kobarclean)
		->update([
			'NABAR'        	=> $nabar,
			'update_date'	=> date('Y-m-d H:i:s'),
			'KOBAR_DESK' 	=> $request->desk ?? NULL,
		]);

		return redirect()->back()
					->with('message', 'Kode Barang '.$kobar.' dengan nama '. $nabar .' berhasil diubah')
					->with('msg_num', 1);
	}

	public function formdeletekobar(Request $request)
	{
		$kobar = $request->kobar;
		$nabar = $request->nabar;

		Nabar::where('KOBAR', $kobar)
				->update([
					'sts' => 0,
					'update_date'	=> date('Y-m-d H:i:s'),
				]);

		return redirect()->back()
					->with('message', 'Kode Barang '.$kobar.' dengan nama '. $nabar .' berhasil dihapus')
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
					->with('message', 'Kode komponen '.$komponen.' berhasil diupdate')
					->with('msg_num', 1);
	}

}

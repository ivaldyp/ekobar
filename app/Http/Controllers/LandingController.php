<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Nabarkom;
use App\Nabar;
use App\Nakom;

session_start();

class LandingController extends Controller
{
	public function __construct()
	{
		$this->db = config('app.DB1');
		$this->tabelnabarkom =  $this->db . ".dbo." . config('app.DB_TABEL1');
		$this->tabelnabar =  $this->db . ".dbo." . config('app.DB_TABEL2');
		$this->tabelnakom =  $this->db . ".dbo." . config('app.DB_TABEL3');
	}

	public function index(Request $request)
	{
		$kat = $request->kat;

		if ($request->cari) {
			$cari = $request->cari;
			if (substr($cari, 1, 1) == '.' && substr($cari, 3, 1) == '.' && substr($cari, 5, 1) == '.') {
				$cari = str_replace('.', '', $cari);
			}

			if ($kat == 'nabar') {
				$datas = Nabar::
							leftJoin($this->tabelnakom, 'KOBAR_PERMENDAGRI', '=', 'KOBAR')
							->where(function($q) use ($cari) {
							$q->where('NABAR', 'like', '%'.$cari.'%')
							  ->orWhere('KOBAR', 'like', '%'.$cari.'%');
							})
							->where(function($q) {
								$q->where('sts', 1)
									->orWhereNull('sts');
								})
							->whereRaw('RIGHT(KOBAR, 3) != '."000".'')
							->orderBy('KOBAR', 'ASC')
							->orderBy('KOMPONEN_KODE', 'ASC')
							->get();
			} elseif ($kat == 'nakom') {
				$datas = Nabar::
							leftJoin($this->tabelnakom, 'KOBAR_PERMENDAGRI', '=', 'KOBAR')
							->where(function($q) use ($cari) {
							$q->where('KOMPONEN_NAMA', 'like', '%'.$cari.'%')
							  ->orWhere('KOMPONEN_KODE', 'like', '%'.$cari.'%');
							})
							->where(function($q) {
								$q->where('sts', 1)
									->orWhereNull('sts');
								})
							->whereRaw('RIGHT(KOBAR, 3) != '."000".'')
							->orderBy('KOBAR', 'ASC')
							->orderBy('KOMPONEN_KODE', 'ASC')
							->get();
			} elseif ($kat == 'nabarkom') {
				$datas = Nabar::
							leftJoin($this->tabelnakom, 'KOBAR_PERMENDAGRI', '=', 'KOBAR')
							->where(function($q) {
								$q->where('sts', 1)
									->orWhereNull('sts');
								})
							->whereRaw('RIGHT(KOBAR, 3) != '."000".'')
							->where(function($q) use ($cari) {
							$q->where('KOMPONEN_NAMA', 'like', '%'.$cari.'%')
								->orWhere('NABAR', 'like', '%'.$cari.'%')
								->orWhere('KOBAR', 'like', '%'.$cari.'%');
							})
							->orderBy('KOBAR', 'ASC')
							->orderBy('KOMPONEN_KODE', 'ASC')
							->get();
			}
		} else {
			$cari = NULL;
			$datas = NULL;
		}

		return view('index')
				->with('searchnow', $cari)
				->with('katnow', $kat)
				->with('datas', $datas);
	}
}
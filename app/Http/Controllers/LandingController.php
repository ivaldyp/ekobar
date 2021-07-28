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

			if ($kat == 'nabar') {
				$datas = Nabar::
							leftJoin($this->tabelnakom, 'KOBAR_PERMENDAGRI', '=', 'KOBAR')
							->where('NABAR', 'like', '%'.$cari.'%')
							->where('sts', 1)
							->orderBy('KOBAR', 'ASC')
							->orderBy('KOMPONEN_KODE', 'ASC')
							->get();

				// $datas = DB::select( DB::raw("
				// 	SELECT *
				// 	from [2021nabar] as nabar
				// 	left join [2021nakom] as nakom on nakom.KOBAR_PERMENDAGRI = nabar.KOBAR
				// 	where NABAR like '%$cari%'
				// 	order by KOBAR, KOMPONEN_KODE
				// 	"));
				// $datas = json_decode(json_encode($datas), true);
			} elseif ($kat == 'nakom') {
				$datas = Nabar::
							leftJoin($this->tabelnakom, 'KOBAR_PERMENDAGRI', '=', 'KOBAR')
							->where('KOMPONEN_NAMA', 'like', '%'.$cari.'%')
							->where('sts', 1)
							->orderBy('KOBAR', 'ASC')
							->orderBy('KOMPONEN_KODE', 'ASC')
							->get();

				// $datas = DB::select( DB::raw("
				// 	SELECT *
				// 	from [2021nabar] as nabar
				// 	left join [2021nakom] as nakom on nakom.KOBAR_PERMENDAGRI = nabar.KOBAR
				// 	where KOMPONEN_NAMA like '%$cari%'
				// 	order by KOBAR, KOMPONEN_KODE
				// 	"));
				// $datas = json_decode(json_encode($datas), true);
				// $datas = Nabarkom::where('komponen_nama', 'like', '%'.$cari.'%')->get();
			} elseif ($kat == 'nabarkom') {
				$datas = Nabar::
							leftJoin($this->tabelnakom, 'KOBAR_PERMENDAGRI', '=', 'KOBAR')
							->where('sts', 1)
							->where(function($q) use ($cari) {
				            $q->where('KOMPONEN_NAMA', 'like', '%'.$cari.'%')
								->orWhere('NABAR', 'like', '%'.$cari.'%');
				            })
							->orderBy('KOBAR', 'ASC')
							->orderBy('KOMPONEN_KODE', 'ASC')
							->get();

				// $datas = DB::select( DB::raw("
				// 	SELECT *
				// 	from [2021nabar] as nabar
				// 	left join [2021nakom] as nakom on nakom.KOBAR_PERMENDAGRI = nabar.KOBAR
				// 	where NABAR like '%$cari%'
				// 	OR KOMPONEN_NAMA like '%$cari%'
				// 	order by KOBAR, KOMPONEN_KODE
				// 	"));
				// $datas = json_decode(json_encode($datas), true);

				// $datas = Nabarkom::
				// 			where('komponen_nama', 'like', '%'.$cari.'%')
				// 			->orWhere('nabar_permendagri', 'like', '%'.$cari.'%')
				// 			->get();
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
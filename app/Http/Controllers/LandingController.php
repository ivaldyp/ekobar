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
		$this->db = 'bpadkobar';
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
                $datas = DB::connection('server76')->table('bpadkobar.dbo.data_nabarkom AS nabarkom')->select([
                        'nabarkom.KOBAR_PERMENDAGRI',
                        'nabarkom.KOBAR_PERMENDAGRI as KOBAR',
                        'nabarkom.NABAR_PERMENDAGRI as NABAR',
                        'nabarkom.KOMPONEN_KODE',
                        'nabarkom.KOMPONEN_NAMA',
                        'nabarkom.SATUAN',
                        'nabarkom.SPESIFIKASI',
                        'nabarkom.HARGA',
                        'nabar.KOBAR_DESK',
                        'nabar.KOBAR_IMG',                                                                                          
                        'nabar.KELOMPOK',
                        'nabar.JENIS',
                        'nabar.OBJEK',
                        'nabar.RINCIAN_OBJEK',
                        'nabar.SUB_RINCIAN_OBJEK',
                    ])
                    ->join('bpadkobar.dbo.data_nabar AS nabar', 'nabarkom.KOBAR_PERMENDAGRI', '=', 'nabar.KOBAR')
                    ->whereRaw('RIGHT(nabarkom.KOBAR_PERMENDAGRI, 3) != '."000".'')
                    ->where(function($q) use ($cari) {
                        $q->where('NABAR_PERMENDAGRI', 'like', '%'.$cari.'%')
                            ->orWhere('KOBAR_PERMENDAGRI', 'like', '%'.$cari.'%');
                        })
                    ->orderBy('nabarkom.KOBAR_PERMENDAGRI', 'ASC')
                    ->orderBy('nabarkom.KOMPONEN_KODE', 'ASC')
                    ->get();
                $datas = json_decode(json_encode($datas), true);

				// $datas = Nabar::
				// 			leftJoin($this->tabelnakom, 'KOBAR_PERMENDAGRI', '=', 'KOBAR')
				// 			->where(function($q) use ($cari) {
				// 			$q->where('NABAR', 'like', '%'.$cari.'%')
				// 			  ->orWhere('KOBAR', 'like', '%'.$cari.'%');
				// 			})
				// 			->where(function($q) {
				// 				$q->where('sts', 1)
				// 					->orWhereNull('sts');
				// 				})
				// 			->whereRaw('RIGHT(KOBAR, 3) != '."000".'')
				// 			->orderBy('KOBAR', 'ASC')
				// 			->orderBy('KOMPONEN_KODE', 'ASC')
				// 			->get();
			} elseif ($kat == 'nakom') {
                $datas = DB::connection('server76')->table('bpadkobar.dbo.data_nabarkom AS nabarkom')->select([
                        'nabarkom.KOBAR_PERMENDAGRI',
                        'nabarkom.KOBAR_PERMENDAGRI as KOBAR',
                        'nabarkom.NABAR_PERMENDAGRI as NABAR',
                        'nabarkom.KOMPONEN_KODE',
                        'nabarkom.KOMPONEN_NAMA',
                        'nabarkom.SATUAN',
                        'nabarkom.SPESIFIKASI',
                        'nabarkom.HARGA',
                        'nabar.KOBAR_DESK',
                        'nabar.KOBAR_IMG',                                                                                          
                        'nabar.KELOMPOK',
                        'nabar.JENIS',
                        'nabar.OBJEK',
                        'nabar.RINCIAN_OBJEK',
                        'nabar.SUB_RINCIAN_OBJEK',
                    ])
                    ->join('bpadkobar.dbo.data_nabar AS nabar', 'nabarkom.KOBAR_PERMENDAGRI', '=', 'nabar.KOBAR')
                    ->whereRaw('RIGHT(nabarkom.KOBAR_PERMENDAGRI, 3) != '."000".'')
                    ->where(function($q) use ($cari) {
                        $q->where('KOMPONEN_NAMA', 'like', '%'.$cari.'%')
                            ->orWhere('KOMPONEN_KODE', 'like', '%'.$cari.'%');
                        })
                    ->orderBy('nabarkom.KOBAR_PERMENDAGRI', 'ASC')
                    ->orderBy('nabarkom.KOMPONEN_KODE', 'ASC')
                    ->get();
                $datas = json_decode(json_encode($datas), true);
            
				// $datas = Nabar::
				// 			leftJoin($this->tabelnakom, 'KOBAR_PERMENDAGRI', '=', 'KOBAR')
				// 			->where(function($q) use ($cari) {
				// 			$q->where('KOMPONEN_NAMA', 'like', '%'.$cari.'%')
				// 			  ->orWhere('KOMPONEN_KODE', 'like', '%'.$cari.'%');
				// 			})
				// 			->where(function($q) {
				// 				$q->where('sts', 1)
				// 					->orWhereNull('sts');
				// 				})
				// 			->whereRaw('RIGHT(KOBAR, 3) != '."000".'')
				// 			->orderBy('KOBAR', 'ASC')
				// 			->orderBy('KOMPONEN_KODE', 'ASC')
				// 			->get();
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
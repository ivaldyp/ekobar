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
                $datas = DB::connection('server76')->table('bpadkobar.dbo.data_nabar AS nabar')->select([     
                    'nabar.KOBAR',
                    'nabar.NABAR',
                    'nabar.KOBAR_DESK',
                    'nabar.KOBAR_IMG',                                                                                          
                    'nabar.KELOMPOK',
                    'nabar.JENIS',
                    'nabar.OBJEK',
                    'nabar.RINCIAN_OBJEK',
                    'nabar.SUB_RINCIAN_OBJEK',
                    'nabarkom.KOBAR_PERMENDAGRI',
                    'nabarkom.KOMPONEN_KODE',
                    'nabarkom.KOMPONEN_NAMA',
                    'nabarkom.SATUAN',
                    'nabarkom.SPESIFIKASI',
                    'nabarkom.HARGA',
                    'm_barang.MASA_MANFAAT',
                    'm_barang.KD_SATUAN',
                ])
                ->leftJoin('bpadkobar.dbo.data_nabarkom AS nabarkom', 'nabar.KOBAR', '=', 'nabarkom.KOBAR_PERMENDAGRI')
                ->leftJoin('SERVER77.bpadmaster.dbo.master_barang AS m_barang', 'm_barang.kobar_108', '=', 'nabar.KOBAR')
                ->whereRaw('RIGHT(nabar.KOBAR, 3) != '."000".'')
                ->where(function($q) use ($cari) {
                    $q->where('NABAR', 'like', '%'.$cari.'%')
                        ->orWhere('KOBAR', 'like', '%'.$cari.'%');
                    })
                ->where(function($q) {
                    $q->where('nabar.sts', 1)
                        ->orWhereNull('nabar.sts');
                    })
                ->orderBy('nabar.KOBAR', 'ASC')
                ->orderBy('nabarkom.KOMPONEN_KODE', 'ASC')
                ->get();
			} elseif ($kat == 'nakom') {
                $datas = DB::connection('server76')->table('bpadkobar.dbo.data_nabar AS nabar')->select([     
                    'nabar.KOBAR',
                    'nabar.NABAR',
                    'nabar.KOBAR_DESK',
                    'nabar.KOBAR_IMG',                                                                                          
                    'nabar.KELOMPOK',
                    'nabar.JENIS',
                    'nabar.OBJEK',
                    'nabar.RINCIAN_OBJEK',
                    'nabar.SUB_RINCIAN_OBJEK',
                    'nabarkom.KOBAR_PERMENDAGRI',
                    'nabarkom.KOMPONEN_KODE',
                    'nabarkom.KOMPONEN_NAMA',
                    'nabarkom.SATUAN',
                    'nabarkom.SPESIFIKASI',
                    'nabarkom.HARGA',
                    'm_barang.MASA_MANFAAT',
                    'm_barang.KD_SATUAN',
                ])
                ->leftJoin('bpadkobar.dbo.data_nabarkom AS nabarkom', 'nabar.KOBAR', '=', 'nabarkom.KOBAR_PERMENDAGRI')
                ->leftJoin('SERVER77.bpadmaster.dbo.master_barang AS m_barang', 'm_barang.kobar_108', '=', 'nabar.KOBAR')
                ->whereRaw('RIGHT(nabar.KOBAR, 3) != '."000".'')
                ->where(function($q) use ($cari) {
                    $q->where('nabarkom.KOMPONEN_KODE', 'like', '%'.$cari.'%')
                        ->orWhere('nabarkom.KOMPONEN_NAMA', 'like', '%'.$cari.'%');
                    })
                ->where(function($q) {
                    $q->where('nabar.sts', 1)
                        ->orWhereNull('nabar.sts');
                    })
                ->orderBy('nabar.KOBAR', 'ASC')
                ->orderBy('nabarkom.KOMPONEN_KODE', 'ASC')
                ->get();
			} elseif ($kat == 'nabarkom') {
                $datas = DB::connection('server76')->table('bpadkobar.dbo.data_nabar AS nabar')->select([     
                    'nabar.KOBAR',
                    'nabar.NABAR',
                    'nabar.KOBAR_DESK',
                    'nabar.KOBAR_IMG',                                                                                          
                    'nabar.KELOMPOK',
                    'nabar.JENIS',
                    'nabar.OBJEK',
                    'nabar.RINCIAN_OBJEK',
                    'nabar.SUB_RINCIAN_OBJEK',
                    'nabarkom.KOBAR_PERMENDAGRI',
                    'nabarkom.KOMPONEN_KODE',
                    'nabarkom.KOMPONEN_NAMA',
                    'nabarkom.SATUAN',
                    'nabarkom.SPESIFIKASI',
                    'nabarkom.HARGA',
                    'm_barang.MASA_MANFAAT',
                    'm_barang.KD_SATUAN',
                ])
                ->leftJoin('bpadkobar.dbo.data_nabarkom AS nabarkom', 'nabar.KOBAR', '=', 'nabarkom.KOBAR_PERMENDAGRI')
                ->leftJoin('SERVER77.bpadmaster.dbo.master_barang AS m_barang', 'm_barang.kobar_108', '=', 'nabar.KOBAR')
                ->whereRaw('RIGHT(nabar.KOBAR, 3) != '."000".'')
                ->where(function($q) use ($cari) {
                    $q->where('nabarkom.KOMPONEN_KODE', 'like', '%'.$cari.'%')
                        ->orWhere('nabarkom.KOMPONEN_NAMA', 'like', '%'.$cari.'%')
                        ->orWhere('NABAR', 'like', '%'.$cari.'%')
					    ->orWhere('KOBAR', 'like', '%'.$cari.'%');
                    })
                ->where(function($q) {
                    $q->where('nabar.sts', 1)
                        ->orWhereNull('nabar.sts');
                    })
                ->orderBy('nabar.KOBAR', 'ASC')
                ->orderBy('nabarkom.KOMPONEN_KODE', 'ASC')
                ->get();
			}

            $arrdatas = json_decode(json_encode($datas), true);
            $countkobar = array_map(function($kobar) {
                return $kobar['KOBAR'];
            }, $arrdatas);

            $countkobar = count(array_count_values($countkobar));
		} else {
			$cari = NULL;
			$datas = NULL;
            $countkobar = 0;
		}

		return view('index')
				->with('searchnow', $cari)
				->with('katnow', $kat)
				->with('countkobar', $countkobar)
				->with('datas', $datas);
	}
}
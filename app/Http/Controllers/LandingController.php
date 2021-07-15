<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Nabarkom;

session_start();

class LandingController extends Controller
{
	public function __construct()
	{
		$this->db = env('DB_DATABASE');
	}

	public function index(Request $request)
	{
		$kat = $request->kat;

		if ($request->cari) {
			$cari = $request->cari;

			if ($kat == 'nabar') {
				$datas = Nabarkom::where('nabar_permendagri', 'like', '%'.$cari.'%')->get();
			} elseif ($kat == 'nakom') {
				$datas = Nabarkom::where('komponen_nama', 'like', '%'.$cari.'%')->get();
			} elseif ($kat == 'nabarkom') {
				$datas = Nabarkom::
							where('komponen_nama', 'like', '%'.$cari.'%')
							->orWhere('nabar_permendagri', 'like', '%'.$cari.'%')
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
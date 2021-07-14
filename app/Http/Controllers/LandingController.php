<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

session_start();

class LandingController extends Controller
{
	public function __construct()
	{
		$this->db = env('DB_DATABASE');

	}

	public function index(Request $request)
	{
		if ($request->cari) {
			$cari = $request->cari;
		} else {
			$cari = NULL;
		}

		if ($request->kat) {
			$kat = $request->kat;
		} else {
			$kat = 'nabarkom';
		}

		return view('index')
				->with('searchnow', $cari)
				->with('katnow', $kat);
	}
}
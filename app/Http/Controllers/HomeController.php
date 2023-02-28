<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Traits\SessionCheckTraits;
use App\Traits\SessionCheckNotif;

use App\Emp_data;
use App\Emp_notif;
use App\Sec_access;
use App\Sec_logins;
use App\Sec_menu;
use App\Fr_disposisi;

session_start();

class HomeController extends Controller
{
	use SessionCheckTraits;

	private $db;

	public function __construct()
	{
		$this->middleware('auth');
		set_time_limit(300);
		$this->db = env('DB_DATABASE');
	}

	public function logout()
	{
		unset($_SESSION['kobar_data']);
		Auth::logout();
		return redirect('/');
	}

	public function display_menus($query, $parent, $level = 0, $idgroup)
	{
        $query = DB::connection('sqlsrv')->table('bpadkobar.dbo.sec_menu AS menu')->select()
                ->join('bpadkobar.dbo.sec_access AS access', 'access.idtop', '=', 'menu.ids')
                ->where('access.idgroup', $idgroup)
                ->where('access.zviw', 'y')
                ->where('menu.tampilnew', 1)
                ->orderBy('menu.urut')->orderBy('menu.ids');
                
        if ($parent == 0) {
			$query = $query
                        ->where(function($q) {
                            $q->where('menu.sao', 0)
                                ->orWhereNull('menu.sao');
                            });
		} else {
			$query = $query->where('menu.sao', $parent);
		}
        $query = $query->get();
        $query = json_decode(json_encode($query), true);

		$result = '';

		$link = '';
		$arrLevel = ['<ul class="nav" id="side-menu">', '<ul class="nav nav-second-level">', '<ul class="nav nav-third-level">', '<ul class="nav nav-fourth-level">', '<ul class="nav nav-fourth-level">'];

		if (count($query) > 0) {

			$result .= $arrLevel[$level];

			if ($level == 0) {
				$result .= '<li id="li_portal"> <a href="/'.env('app_name').'" class="waves-effect"> <i class="fa fa-globe fa-fw"></i> <span class="hide-menu">Kode Barang</span></a></li>';
			}
		
			foreach ($query as $menu) {
				if (is_null($menu['urlnew'])) {
					$link = 'javascript:void(0)';
				} elseif (substr($menu['urlnew'], 0, 4) == 'http') {
					$link = $menu['urlnew'];
				} else {
					if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') 
						$link = "https"; 
					else
						$link = "http"; 
					  
					$link .= "://";       
					$link .= $_SERVER['HTTP_HOST']; 
					$link .= "/" . env('app_name');
					$link .= $menu['urlnew'];
				}

				if ($menu['child'] == 0) {
					$result .= '<li> <a href="'.$link.'" class="waves-effect"><i class="fa '. (($menu['iconnew'])? $menu['iconnew'] :'').' fa-fw"></i> <span class="hide-menu">'.$menu['desk'].'</span></a></li>';
					
				} elseif ($menu['child'] == 1) {
					$result .= '<li> <a href="'.$link.'" class="waves-effect"><i class="fa '. (($menu['iconnew'])? $menu['iconnew'] :'').' fa-fw"></i> <span class="hide-menu">'.$menu['desk'].'<span class="fa arrow"></span></span></a>';
					
					$result .= $this->display_menus($query, $menu['ids'], $level+1, $idgroup);

					$result .= '</li>';
				}
			}

			$result .= '</ul>';
		}
		return $result;
	}

	public function password(Request $request)
	{
		if (Auth::user()->id_emp) {
			$ids = Auth::user()->id_emp;

			Emp_data::
			where('id_emp', $ids)
			->update([
				'passmd5' => md5($request->passmd5),
			]);
		} else {
			$ids = Auth::user()->usname;

			Sec_logins::
			where('usname', $ids)
			->update([
				'passmd5' => md5($request->passmd5),
			]);
		}

		return redirect('/home')
					->with('message', 'Password berhasil diubah')
					->with('msg_num', 1);
	}

	public function index(Request $request)
	{
		$this->checkSessionTime();
		
		unset($_SESSION['user_kobar']);

		date_default_timezone_set('Asia/Jakarta');

		if (isset(Auth::user()->usname)) {
			$iduser = Auth::user()->usname;

			$user_data = Sec_logins::
							where('usname', $iduser)
							->first();

			Sec_logins::where('usname', $user_data['usname'])
			->update([
				'lastlogin' => date('Y-m-d H:i:s'),
			]);	
		} else {
			$iduser = Auth::user()->id_emp;

			$user_data = DB::select( DB::raw("
						SELECT id_emp, nrk_emp, nip_emp, nm_emp, a.idgroup_aset as idgroup, tgl_lahir, jnkel_emp, tgl_join, status_emp, tbjab.idjab, tbjab.idunit, tbunit.child, tbunit.nm_unit from bpadkobar.dbo.emp_data as a
						CROSS APPLY (SELECT TOP 1 tmt_jab,idskpd,idunit,idlok,tmt_sk_jab,no_sk_jab,jns_jab,replace(idjab,'NA::','') as idjab,eselon,gambar FROM bpadkobar.dbo.emp_jab WHERE a.id_emp=emp_jab.noid AND emp_jab.sts='1' ORDER BY tmt_jab DESC) tbjab
						CROSS APPLY (SELECT TOP 1 * FROM bpadkobar.dbo.glo_org_unitkerja WHERE glo_org_unitkerja.kd_unit = tbjab.idunit) tbunit
						,bpadkobar.dbo.glo_skpd as b,bpadkobar.dbo.glo_org_unitkerja as c,bpadkobar.dbo.glo_org_lokasi as d WHERE tbjab.idskpd=b.skpd AND tbjab.idskpd+'::'+tbjab.idunit=c.kd_skpd+'::'+c.kd_unit AND tbjab.idskpd+'::'+tbjab.idlok=d.kd_skpd+'::'+d.kd_lok AND a.sts='1' AND b.sts='1' AND c.sts='1' AND d.sts='1' 
						and id_emp = '$iduser' and ked_emp = 'aktif'
						order by tbunit.kd_unit") )[0];
			$user_data = json_decode(json_encode($user_data), true);

			Emp_data::where('id_emp', $user_data['id_emp'])
			->update([
				'lastlogin' => date('Y-m-d H:i:s'),
			]);	
		}

		$homeview = DB::select( DB::raw("
					exec homeview
					"))[0];
		$homeview = json_decode(json_encode($homeview), true);

		$_SESSION['kobar_data'] = $user_data;

		$all_menu = [];

		$menus = $this->display_menus($all_menu, 0, 0, $_SESSION['kobar_data']['idgroup']);

		$_SESSION['kobar_menus'] = $menus;

		return view('home')
				->with('iduser', $iduser)
				->with('homeview', $homeview);
	}
}

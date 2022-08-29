<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Route::get('/', 'LandingController@index');
Route::get('/logout', 'HomeController@logout');
Route::post('/home/password', 'HomeController@password');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'profil'], function () {
	Route::get('/pegawai', 'ProfilController@pegawai');
	Route::post('/form/ubahidpegawai', 'ProfilController@formupdateidpegawai');
	Route::post('/form/tambahdikpegawai', 'ProfilController@forminsertdikpegawai');
	Route::post('/form/ubahdikpegawai', 'ProfilController@formupdatedikpegawai');
	Route::post('/form/hapusdikpegawai', 'ProfilController@formdeletedikpegawai');
});

Route::group(['prefix' => 'cms'], function () {
	Route::get('/menu', 'CmsController@menuall');
	Route::post('/form/tambahmenu', 'CmsController@forminsertmenu');
	Route::post('/form/ubahmenu', 'CmsController@formupdatemenu');
	Route::post('/form/hapusmenu', 'CmsController@formdeletemenu');
	Route::get('/menuakses', 'CmsController@menuakses');
	Route::post('/form/ubahaccess', 'CmsController@formupdateaccess');
});

Route::group(['prefix' => 'security'], function () {
	Route::get('/group user', 'SecurityController@grupall');
	Route::get('/group user/ubah', 'SecurityController@grupubah');
	Route::post('/form/tambahgrup', 'SecurityController@forminsertgrup');
	Route::post('/form/ubahgrup', 'SecurityController@formupdategrup');
	Route::post('/form/hapusgrup', 'SecurityController@formdeletegrup');

	Route::get('/tambah user', 'SecurityController@tambahuser');
	Route::post('/form/tambahuser', 'SecurityController@forminsertuser');

	Route::get('/manage user', 'SecurityController@manageuser');
	Route::post('/form/tambahuser', 'SecurityController@forminsertuser');
	Route::post('/form/ubahuser', 'SecurityController@formupdateuser');
	Route::post('/form/ubahpassuser', 'SecurityController@formupdatepassuser');
	Route::post('/form/hapususer', 'SecurityController@formdeleteuser');
});

/////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////

Route::group(['prefix' => 'form'], function () {
	Route::get('/getmaxnewkobar', 'FormController@getmaxnewkobar');

	Route::get('/tambahkobar', 'FormController@pagetambahkobar');
	Route::post('/tambahkobar', 'FormController@forminsertkobar');

	Route::get('/ubahkobar', 'FormController@pageubahkobar');
	Route::post('/ubahkobar', 'FormController@formupdatekobar');
	Route::post('/hapuskobar', 'FormController@formdeletekobar');
    
	Route::get('/kodekomponen', 'FormController@pagekodekomponen');
	Route::post('/kodekomponen', 'FormController@formupdatekomponen');
	Route::post('/formupdatekomponenajax', 'FormController@formupdatekomponenajax');
});
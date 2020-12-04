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

Route::get('/logout', 'HomeController@logout');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'disposisi'], function () {
	Route::get('/formdisposisi', 'DisposisiController@formdisposisi');
	Route::get('/hapusfiledisposisi', 'DisposisiController@disposisihapusfile');
	Route::get('/tambah disposisi', 'DisposisiController@disposisitambah');
	Route::get('/ubah disposisi', 'DisposisiController@disposisiubah');
	Route::post('form/tambahdisposisi', 'DisposisiController@forminsertdisposisi');
	Route::post('form/ubahdisposisi', 'DisposisiController@formupdatedisposisi');
	Route::get('form/hapusdisposisi', 'DisposisiController@formdeletedisposisi');
	Route::get('form/resetdisposisi', 'DisposisiController@formresetdisposisi');

	Route::get('/disposisi', 'DisposisiController@disposisi');
	Route::get('/lihat disposisi', 'DisposisiController@disposisilihat');
	Route::post('form/lihatdisposisi', 'DisposisiController@formlihatdisposisi');
	Route::get('form/hapusdisposisiemp', 'DisposisiController@formdeletedisposisiemp');

	Route::get('/excel', 'DisposisiController@printexcel');
	Route::get('/log', 'DisposisiController@log');
});

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

Route::group(['prefix' => 'kepegawaian'], function () {
	Route::get('/setup/unit', 'KepegawaianSetupController@unitall');
	Route::post('/form/tambahunit', 'KepegawaianSetupController@forminsertunit');
	Route::post('/form/ubahunit', 'KepegawaianSetupController@formupdateunit');
	Route::post('/form/hapusunit', 'KepegawaianSetupController@formdeleteunit');

	Route::get('/excel', 'KepegawaianController@printexcel');
	Route::get('/excelpegawai', 'KepegawaianController@printexcelpegawai');

	Route::get('/data pegawai', 'KepegawaianController@pegawaiall');
	Route::get('/tambah pegawai', 'KepegawaianController@pegawaitambah');
	Route::get('/ubah pegawai', 'KepegawaianController@pegawaiubah');
	Route::post('/form/tambahpegawai', 'KepegawaianController@forminsertpegawai');
	Route::post('/form/ubahpegawai', 'KepegawaianController@formupdatepegawai');
	Route::post('/form/hapuspegawai', 'KepegawaianController@formdeletepegawai');
	Route::post('/form/ubahpassuser', 'KepegawaianController@formupdatepassuser');
	Route::post('/form/ubahstatuspegawai', 'KepegawaianController@formupdatestatuspegawai');
	Route::post('/form/tambahdikpegawai', 'KepegawaianController@forminsertdikpegawai');
	Route::post('/form/ubahdikpegawai', 'KepegawaianController@formupdatedikpegawai');
	Route::post('/form/hapusdikpegawai', 'KepegawaianController@formdeletedikpegawai');
	Route::post('/form/tambahgolpegawai', 'KepegawaianController@forminsertgolpegawai');
	Route::post('/form/ubahgolpegawai', 'KepegawaianController@formupdategolpegawai');
	Route::post('/form/hapusgolpegawai', 'KepegawaianController@formdeletegolpegawai');
	Route::post('/form/tambahjabpegawai', 'KepegawaianController@forminsertjabpegawai');
	Route::post('/form/ubahjabpegawai', 'KepegawaianController@formupdatejabpegawai');
	Route::post('/form/hapusjabpegawai', 'KepegawaianController@formdeletejabpegawai');

	Route::get('/status disposisi', 'KepegawaianController@statusdisposisi');
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

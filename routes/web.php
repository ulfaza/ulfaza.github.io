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
    return view('auth.login');
});



Auth::routes();

Route::group(['prefix' => 'admin',  'middleware' => 'is_admin'], function(){
	Route::get('/lte', 'LteController@index');
	// Route dashboard 
	Route::get('/home', 'AdminController@index')->name('adminhome');
	// Route profil 
	Route::get('/profil/{id}', 'AdminController@edit')->name('profil.admin');
	Route::post('/update{id}','AdminController@update')->name('update.admin');
	// Route guru
	Route::get('/daftar/guru', 'UserController@guru')->name('list.guru');
	Route::get('/tambah/guru', 'UserController@insert')->name('insert.guru');
	Route::post('/store/guru', 'UserController@store')->name('store.guru');
	Route::get('/edit/guru/{id}', 'UserController@edit')->name('edit.list.guru');
	Route::post('/update/guru/{id}','UserController@update')->name('update.list.guru');
	Route::get('/delete/guru/{id}', 'UserController@delete')->name('delete.list.guru');
	Route::get('/import/guru', 'UserController@import')->name('import.guru');
	Route::post('/guru/importExcel', 'UserController@importExcel');
	// Route kelas
	Route::get('/kelas', 'KelasController@index')->name('kelas');
	Route::get('/tambahkelas', 'KelasController@insert')->name('insert.kelas');
	Route::post('/store/kelas', 'KelasController@store')->name('store.kelas');
	Route::get('/edit/kelas/{id}', 'KelasController@edit')->name('edit.kelas');
	Route::post('/update/kelas/{id}','KelasController@update')->name('update.kelas');
	Route::get('/delete/kelas/{id}', 'KelasController@delete')->name('delete.kelas');
	Route::get('/import/kelas', 'KelasController@import')->name('import.kelas'); 
	Route::post('/importExcel', 'KelasController@importExcel');
	Route::get('/import/walikelas', 'KelasController@importwali')->name('import.wali.kelas'); 
	Route::post('/wali/importExcel', 'KelasController@importwaliExcel')->name('excel.wali');
	// Route Siswa
	Route::get('/{id}/siswa', 'SiswaController@index')->name('siswa');
	Route::post('/siswa/action', 'SiswaController@action')->name('action.siswa');
	Route::get('/tambah/{id}/siswa', 'SiswaController@insert')->name('insert.siswa');
	Route::post('/store/{id}/siswa', 'SiswaController@store')->name('store.siswa');
	Route::get('/import/{id}/siswa', 'SiswaController@import')->name('import.siswa'); 
	Route::post('/siswa/{id}/importExcel', 'SiswaController@importExcel')->name('excel.siswa');
	//Route kh
	Route::get('/jenis_kh', 'KhController@index')->name('kh');
	Route::post('/jenis_kh/action', 'KhController@actionkh')->name('action.kh');
	Route::get('/tambah/jenis_kh', 'KhController@insert')->name('insert.kh');
	Route::post('/store/jenis_kh', 'KhController@store')->name('store.kh');
	// Route Tahun Ajar
	Route::get('/th_ajar', 'ThAjarController@index')->name('th_ajar');
	Route::get('/tambah/th_ajar', 'ThAjarController@insert')->name('insert.th_ajar');
	Route::post('/store/th_ajar', 'ThAjarController@store')->name('store.th_ajar');
	Route::get('/edit/th_ajar/{id}', 'ThAjarController@edit')->name('edit.th_ajar');
	Route::post('/update/th_ajar/{id}','ThAjarController@update')->name('update.th_ajar');
	Route::get('/delete/th_ajar/{id}', 'ThAjarController@delete')->name('delete.th_ajar');
	Route::get('/rekap/kh/{id}', 'ThAjarController@rekapkh')->name('rekap.kh');
	Route::get('/rekap/{ta_id}/{k_id}', 'ThAjarController@rekapsiswa')->name('rekap.siswa');
	Route::get('/rekap/siswa/{ta_id}', 'ThAjarController@rekapsemua')->name('rekap.semua');
	Route::get('/rekap/keseluruhan/{ta_id}', 'ThAjarController@rekaptotal')->name('rekap.total');
	//Route Penguji KH
	Route::get('/uji/{id}/{nama}', 'UjiKhController@index')->name('ujikh');
	Route::get('/edit/penguji/{id}', 'UjiKhController@edit')->name('edit.ujikh');
	Route::post('/update/penguji/{id}/{ta_id}/{kh_nama}','UjiKhController@update')->name('update.ujikh');
	Route::get('/import/penguji/{ta_id}/{id_kh}', 'UjiKhController@import')->name('import.penguji');
	Route::get('/template/penguji', 'UjiKhController@download')->name('download.template'); 
	Route::post('/penguji/importExcel/{ta_id}/{id_kh}', 'UjiKhController@importExcel')->name('excel.penguji');
	// Route Rekap KH
	Route::get('/rekap/{id}', 'RekapKhController@index')->name('rekap');
	Route::post('/rekap/action', 'RekapKhController@actionrekap')->name('action.rekap');
});

Route::group(['prefix' => 'guru',  'middleware' => 'is_user'], function(){
	// Route dashboard 
	Route::get('/home', 'GuruController@index')->name('guruhome');
	// Route profil guru
	Route::get('/profil/{id}', 'GuruController@edit')->name('profil.guru');
	Route::post('/update{id}','GuruController@update')->name('update.guru');
	// Route Rekap KH
	Route::get('/rekap/{id}', 'GuruController@rekap')->name('rekap.guru');
	Route::post('/rekap/{r_id}/{uji_id}', 'GuruController@updatenilai')->name('edit.rekap');
	// Route wali kelas
	Route::get('/kelas/{id}', 'GuruController@kelas')->name('kelas.guru');
});
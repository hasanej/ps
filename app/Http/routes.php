<?php

/** 
*
* @author       : Hasan El Jabir <eljabirhasan@gmail.com>
* @copyright    : Gunadarma University Computing Center
* @contact      : 0812 8923 3370 
*
**/

Route::get('/', 'HomeController@index'); //Landing page

//Menerapkan middleware web ke library Laravel Auth
Route::group(['middleware' => 'web'], function()
{
	Route::auth();
});


//Cek role user
Route::group(['middleware' => ['web', 'auth', 'id_role']], function()
{
	Route::get('administrator', function()
	{
			return view('admin.beranda');
	});
});

//Manajemen Berita
Route::resource('berita', 'BeritaController');
Route::resource('komenBerita', 'KomenBeritaController', ['only' => ['destroy']]); //Manajemen Komentar Berita - Hanya bisa hapus komentar

//Manajemen Artikel
Route::resource('artikel', 'ArtikelController');
Route::resource('komenArtikel', 'KomenArtikelController', ['only' => ['destroy']]); //Manajemen Komentar Artikel - Hanya bisa hapus komentar

//Manajemen Publikasi
Route::resource('publikasi', 'PublikasiController');

//Manajemen Kategori
Route::resource('kategori', 'KategoriController', ['except' => ['show']]);

//Manajemen Administrator
Route::resource('admin', 'AdminController', ['except' => ['show']]);
// Route::get('admin', 'AdminController@index')->name('admin.index');
// Route::get('admin/tambah', 'AdminController@tambah')->name('admin.tambah');
// Route::post('admin', 'AdminController@simpan')->name('admin.simpan');
// Route::get('admin/{id}/edit', 'AdminController@ubah')->name('admin.ubah');
// Route::patch('admin/{id}', 'AdminController@update')->name('admin.update');
// Route::delete('admin/{id}', 'AdminController@hapus')->name('admin.hapus');

//Manajemen Pengguna
Route::resource('user', 'UserController', ['except' => ['show']]);


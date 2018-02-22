<?php

/** 
*
* @author       : Hasan El Jabir <eljabirhasan@gmail.com>
* @copyright    : Gunadarma University Computing Center
* @contact      : 0812 8923 3370 
*
**/

namespace App\Http\Controllers;

use App\KomenBerita; //Model komentar berita

class KomenBeritaController extends Controller
{
    
    //Fungsi yang otomatis dijalankan saat controller dipanggil 
    public function __construct()
    {
    	//Autentifikasi
    	$this->middleware('auth');
    }

    //Fungsi hapus komentar berita
    public function destroy($id)
    {
    	//Hapus komentar berita 
    	KomenBerita::find($id)->delete();

    	//Redirect ke halaman indeks komentar
    	return redirect()->back()->with('feedback','<div class="alert alert-success"><p>Komentar berhasil dihapus</p></div>');
    }

}
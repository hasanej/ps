<?php

/** 
*
* @author       : Hasan El Jabir <eljabirhasan@gmail.com>
* @copyright    : Gunadarma University Computing Center
* @contact      : 0812 8923 3370 
*
**/

namespace App\Http\Controllers;

use App\User; //Model user
use App\Berita; //Model berita
use App\Artikel; //Model artikel
use App\Beranda; //Model beranda
use Illuminate\Http\Request; //Library untuk request input
use App\Http\Controllers\Controller; //Controller Laravel 

class BerandaController extends Controller
{

    //Fungsi yang otomatis dijalankan saat controller dipanggil 
    public function __construct()
    {
        //Autentifikasi
        $this->middleware('auth');
    }

    //Fungsi default yang dipanggil 
    public function index()
    {
        //Overview
        $data['jumlahAdmin'] = User::where('id_role', '<', 3)->count();
        $data['jumlahUser'] = User::where('id_role', '>=', 3)->count();
        $data['jumlahBerita'] = Berita::get()->count();
        $data['jumlahBeritaTerbit'] = Berita::where('status', '=', 1)->count();
        $data['jumlahArtikel'] = Artikel::get()->count();
        $data['jumlahArtikelTerbit'] = Artikel::where('status', '=', 1)->count();

        //Mengambil data beranda dari tb_beranda
        $data['beranda'] = Beranda::first();

        //Menampilkan data beranda ke view
        return view('admin.beranda',compact('data'));
    }

    //Fungsi menyimpan beranda
    public function store(Request $request)
    {
        //Validasi form
        $this->validate($request, [
            'judul' => 'required|min:5|max:255',
            'konten' => 'required',
        ]);

        //Mengosongkan tb_beranda
        Beranda::truncate();

        //Menyimpan data ke tb_beranda
        Beranda::create($request->all());

        //Redirect ke halaman indeks beranda
        return redirect()->route('beranda.index')
            ->with('feedback','<div class="alert alert-success"><p>Halaman beranda berhasil diperbaharui</p></div>');
    }

}
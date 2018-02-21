<?php

/** 
*
* @author       : Hasan El Jabir <eljabirhasan@gmail.com>
* @copyright    : Gunadarma University Computing Center
* @contact      : 0812 8923 3370 
*
**/

namespace App\Http\Controllers;

use App\Kategori; //Model Kategori
use Illuminate\Http\Request; //Library untuk request input
use App\Http\Controllers\Controller; //Controller Laravel 

class KategoriController extends Controller
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
        //Nomor urut data pada view
        $number = 0;

        //Mengambil daftar kategori dari tb_kategori
        $data = Kategori::orderBy('id','DESC')->get();

        //Menampilkan daftar kategori ke view
        return view('admin.kategori.index',compact('data','number'));
    }

    //Fungsi menampilkan view tambah kategori
    public function create()
    {
        //Menampilkan view tambah kategori
        return view('admin.kategori.tambah');
    }

    //Fungsi menyimpan kategori
    public function store(Request $request)
    {
        //Validasi form
        $this->validate($request, [
            'nama' => 'required',
        ]);

        //Mengambil semua data input
        $input = $request->all();

        //Menyimpan data kategori ke tb_kategori
        Kategori::create($input); 

        //Redirect ke halaman indeks kategori
        return redirect()->route('kategori.index')
            ->with('feedback','<div class="alert alert-success"><p>Kategori berhasil ditambah</p></div>');
    }

    //Fungsi menampilkan view edit kategori
    public function edit($id)
    {
        //Ambil data kategori yang dipilih dari tb_kategori
        $data = Kategori::find($id);

        //Menampilkan form edit
        return view('admin.kategori.ubah',compact('data'));
    }

    //Fungsi update kategori
    public function update(Request $request, $id)
    {
        //Validasi form
        $this->validate($request, [
            'nama' => 'required',
        ]);

        //Mengambil semua data input
        $input = $request->all();

        //Update data kategori yang dipilih pada tb_kategori
        Kategori::find($id)->update($input);

        //Redirect ke halaman indeks kategori
        return redirect()->route('kategori.index')
            ->with('feedback','<div class="alert alert-success"><p>Kategori berhasil di update</p></div>');
    }
    
    //Fungsi hapus berita
    public function destroy($id)
    {
        //Hapus data kategori yang dipilih dari tb_kategori
        Kategori::find($id)->delete();

        //Redirect ke halaman indeks kategori
        return redirect()->route('kategori.index')
            ->with('feedback','<div class="alert alert-success"><p>Kategori berhasil dihapus</p></div>');
    }

}
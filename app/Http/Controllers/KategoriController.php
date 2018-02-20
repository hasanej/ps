<?php

/** 
*
* @author       : Hasan El Jabir <eljabirhasan@gmail.com>
* @copyright    : Gunadarma University Computing Center
* @contact      : 0812 8923 3370 
*
**/

namespace App\Http\Controllers;

use App\Kategori;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KategoriController extends Controller
{

    public function __construct()
    {
        //Memanggil middleware auth
        $this->middleware('auth');
    }

    public function index()
    {
        //Nomor urut data pada view
        $number = 0;

        //Mengambil daftar kategori
        $data = Kategori::orderBy('id','DESC')->paginate(10);

        //Menampilkan daftar kategori ke view
        return view('admin.kategori.index',compact('data','number'));
    }

    public function create()
    {
        //Menampilkan view tambah kategori
        return view('admin.kategori.tambah');
    }

    public function store(Request $request)
    {
        //Validasi form
        $this->validate($request, [
            'nama' => 'required',
        ]);

        //Mengambil semua data input
        $input = $request->all();

        //Menyimpan data kategori ke tabel
        Kategori::create($input); 

        //Redirect ke halaman indeks kategori
        return redirect()->route('kategori.index')
            ->with('success','Kategori berhasil ditambah');
    }

    public function edit($id)
    {
        //Ambil data kategori yang dipilih dari tabel
        $data = Kategori::find($id);

        //Menampilkan form edit
        return view('admin.kategori.ubah',compact('data'));
    }

    public function update(Request $request, $id)
    {
        //Validasi form
        $this->validate($request, [
            'nama' => 'required',
        ]);

        //Mengambil semua data input
        $input = $request->all();

        //Update data kategori yang dipilih pada tabel
        Kategori::find($id)->update($input);

        //Redirect ke halaman indeks kategori
        return redirect()->route('kategori.index')
            ->with('success','Kategori berhasil di update');
    }
    
    public function destroy($id)
    {
        //Hapus data kategori yang dipilih pada tabel
        Kategori::find($id)->delete();

        //Redirect ke halaman indeks kategori
        return redirect()->route('kategori.index')
            ->with('success','Kategori berhasil dihapus');
    }

}
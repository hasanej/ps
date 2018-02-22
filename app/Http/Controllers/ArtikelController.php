<?php

/** 
*
* @author       : Hasan El Jabir <eljabirhasan@gmail.com>
* @copyright    : Gunadarma University Computing Center
* @contact      : 0812 8923 3370 
*
**/

namespace App\Http\Controllers;

use Image; //Library tambahan untuk manipulasi gambar
use File; //Library upload file
use App\Artikel; //Model artikel
use App\FilesArtikel; //Model file artikel
use App\Kategori; //Model kategori
use App\KomenArtikel; //Model komentar artikel
use Illuminate\Http\Request; //Library untuk request input
use App\Http\Controllers\Controller; //Controller Laravel 

class ArtikelController extends Controller
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

        //Mengambil data artikel dari tb_artikel
        $data = Artikel::orderBy('id','DESC')->get();

        //Menampilkan data artikel ke view
        return view('admin.artikel.index',compact('data','number'));
    }

    //Fungsi menampilkan view tambah artikel
    public function create()
    {
        //Mengambil list kategori dari tb_kategori untuk ditampilkan ke Form::select
        $kategori = Kategori::pluck('nama', 'id');

        //Menampilkan view tambah artikel
        return view('admin.artikel.tambah', compact('kategori'));
    }

    //Fungsi menyimpan artikel
    public function store(Request $request)
    {
        //Validasi form
        $this->validate($request, [
            'judul' => 'required|min:5|max:255',
            'konten' => 'required',
            'gambar' => 'image|max:2048', //Format gambar yang didukung : jpeg, jpg, png, bmp, gif, svg
        ]);

        //Mengambil semua data input kecuali input file
        $inputArtikel = $request->except('file');

        $gambar = $request->file('gambar'); //Mengambil input gambar
        $files = $request->file('file'); //Mengambil input file

        //Proses jika ada input gambar
        if($gambar!=null)
        {
            //Menamakan file gambar
            $nama = md5(microtime(true)).md5($gambar->getClientOriginalName()).'.'.$gambar->extension(); 

            //Memindahkan file gambar ke folder upload/gambar_artikel
            $gambar->move(public_path('upload/gambar_artikel'), $nama);

            //Resize dan save gambar ke folder upload/gambar_artikel
            Image::make(public_path('upload/gambar_artikel/'.$nama))->encode('jpg', 90)->resize(500, null, function($cons) {
            $cons->aspectRatio();
            $cons->upsize();
            })->save(public_path('upload/gambar_artikel/'.$nama));

            //Meletakkan nilai gambar ke array
            $inputArtikel['gambar'] = $nama;
        }      

        //Menyimpan data artikel ke tb_artikel
        $artikel = Artikel::create($inputArtikel);   

        //Proses jika ada input file
        if($files[0]!=null)
        {
            //Foreach digunakan karena input berupa array (Multiple files)
            foreach($files as $file)
            {
                //Ambil ekstensi file 
                $ext = $file->extension(); 

                //Validasi tipe file
                if($ext=='doc' || $ext=='docx' || $ext=='xls' || $ext=='xlsx' || $ext=='ppt' || $ext=='pptx' || $ext=='pdf')
                {
                    //Menamakan file
                    $nama = time().'_'.$file->getClientOriginalName();

                    //Memindahkan file ke folder upload/file_artikel
                    $file->move(public_path('upload/file_artikel'), $nama);
                      
                    //Input file ke tb_file_artikel
                    FilesArtikel::create([
                        'id_artikel' => $artikel->id,
                        'file' => $nama
                    ]);
                }
                else
                {   
                    //Pesan error 
                    $errors = "Format file yang didukung : doc, docx, xls, xlsx, ppt, pptx, pdf";

                    //Mengambil nama gambar
                    $gambar = Artikel::where('id', $artikel->id)->first()->gambar;
                        
                    //Hapus gambar
                    File::delete(public_path('upload/gambar_artikel/'.$gambar));

                    //Hapus artikel agar data tidak duplikat 
                    Artikel::find($artikel->id)->delete();

                    //Reload halaman
                    return redirect()->back()
                        ->withErrors($errors)
                        ->withInput($request->input());
                }
            }
        }

        //Redirect ke halaman indeks artikel
        return redirect()->route('artikel.index')
            ->with('feedback','<div class="alert alert-success"><p>Artikel berhasil ditambah</p></div>');
    }

    //Fungsi menampilkan daftar komentar artikel
    public function show($id)
    {
        //Nomor urut data pada view
        $number = 0;

        //Ambil data komentar artikel dari tb_komen_artikel
        $data = KomenArtikel::where('id_artikel', $id)->get();

        //Menampilkan data komentar pada artikel yang dipilih
        return view('admin.artikel.komen',compact('data', 'number'));
    }

    //Fungsi menampilkan view edit artikel
    public function edit($id)
    {
        //Mengambil list kategori dari tb_kategori untuk ditampilkan ke Form::select
        $kategori = Kategori::pluck('nama', 'id');

        //Ambil data artikel yang dipilih dari tb_artikel
        $data = Artikel::find($id);

        //Ambil daftar file dari tb_file_artikel
        $daftarFile = FilesArtikel::where('id_artikel', $id)->get();

        //Menampilkan form edit
        return view('admin.artikel.ubah',compact('data', 'kategori', 'daftarFile'));
    }

    //Fungsi update artikel
    public function update(Request $request, $id)
    {
        //Validasi form
        $this->validate($request, [
            'judul' => 'required|min:5|max:255',
            'konten' => 'required',
            'gambar' => 'image|max:2048', //Format gambar yang didukung : jpeg, png, bmp, gif, svg
        ]);

        //Mengambil semua data input kecuali input file
        $inputArtikel = $request->except('file');

        $gambar = $request->file('gambar'); //Mengambil input gambar
        $files = $request->file('file'); //Mengambil input file

        //Proses jika ada input gambar
        if($gambar!=null)
        {
            //Mengambil gambar lama
            $gambar_lama = Artikel::where('id', $id)->first()->gambar;
            
            //Hapus gambar lama
            File::delete(public_path('upload/gambar_artikel/'.$gambar_lama));

            //Menamakan file gambar baru
            $nama = md5(microtime(true)).md5($gambar->getClientOriginalName()).'.'.$gambar->extension();

            //Memindahkan file gambar baru ke folder upload/gambar_artikel
            $gambar->move(public_path('upload/gambar_artikel'), $nama);

            //Resize dan save gambar baru ke folder upload/gambar_artikel
            Image::make(public_path('upload/gambar_artikel/'.$nama))->encode('jpg', 90)->resize(500, null, function($cons) {
            $cons->aspectRatio();
            $cons->upsize();
            })->save(public_path('upload/gambar_artikel/'.$nama));

            //Meletakkan nilai gambar ke array
            $inputArtikel['gambar'] = $nama;
        }

        //Update data artikel pada tb_artikel
        Artikel::find($id)->update($inputArtikel); 

        //Proses jika ada input file
        if($files[0]!=null)
        {
            //Mengambil daftar file(s) lama 
            $files_lama = FilesArtikel::where('id_artikel', $id)->pluck('file');

            //Hapus file(s) lama
            foreach($files_lama as $file_lama)
            {
                File::delete(public_path('upload/file_artikel/'.$file_lama));
            }

            //Hapus data file artikel dari tb_file_artikel
            FilesArtikel::where('id_artikel',$id)->delete();
    
            //Foreach digunakan karena input berupa array (Multiple files)
            foreach($files as $file)
            {
                //Ambil ekstensi file 
                $ext = $file->extension(); 

                //Validasi tipe file
                if($ext=='doc' || $ext=='docx' || $ext=='xls' || $ext=='xlsx' || $ext=='ppt' || $ext=='pptx' || $ext=='pdf')
                {
                    //Menamakan file
                    $nama = time().'_'.$file->getClientOriginalName();

                    //Memindahkan file ke folder upload/file_artikel
                    $file->move(public_path('upload/file_artikel'), $nama);
                      
                    //Input file ke tb_file_artikel
                    FilesArtikel::create([
                        'id_artikel' => $id,
                        'file' => $nama
                    ]);
                }
                else
                {   
                    //Pesan error 
                    $errors = "Format file yang didukung : doc, docx, xls, xlsx, ppt, pptx, pdf";

                    //Reload halaman
                    return redirect()->back()
                        ->withErrors($errors)
                        ->withInput($request->input());
                }
            }
        }

        //Redirect ke halaman indeks artikel
        return redirect()->route('artikel.index')
            ->with('feedback','<div class="alert alert-success"><p>Artikel berhasil di update</p></div>');
    }
    
    //Fungsi hapus artikel
    public function destroy($id)
    {
        //Mengambil nama gambar
        $gambar = Artikel::where('id', $id)->first()->gambar;

        //Mengambil daftar file(s) 
        $files = FilesArtikel::where('id_artikel', $id)->pluck('file');

        //Hapus gambar
        File::delete(public_path('upload/gambar_artikel/'.$gambar));

        //Hapus file(s)
        foreach($files as $file)
        {
            //Proses jika input file tidak kosong
            if($file!=null)
            {
                File::delete(public_path('upload/file_artikel/'.$file));
            }
        }

        //Hapus data file artikel dari tb_file_artikel
        FilesArtikel::where('id_artikel', $id)->delete();

        //Hapus data artikel dari tb_artikel
        Artikel::find($id)->delete();

        //Redirect ke halaman indeks artikel
        return redirect()->route('artikel.index')
            ->with('feedback','<div class="alert alert-success"><p>Artikel berhasil dihapus</p></div>');
    }

}
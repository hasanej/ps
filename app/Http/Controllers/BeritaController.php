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
use App\Berita; //Model berita
use App\FilesBerita; //Model file berita
use App\Kategori; //Model kategori
use Illuminate\Http\Request; //Library untuk request input
use App\Http\Controllers\Controller; //Controller Laravel 

class BeritaController extends Controller
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

        //Mengambil data berita dari tb_berita
        $data = Berita::orderBy('id','DESC')->paginate(10);

        //Menampilkan data berita ke view
        return view('admin.berita.index',compact('data','number'));
    }

    //Fungsi menampilkan view tambah berita
    public function create()
    {
        //Mengambil list kategori dari tb_kategori untuk ditampilkan ke Form::select
        $kategori = Kategori::pluck('nama', 'id');

        //Menampilkan view tambah berita
        return view('admin.berita.tambah', compact('kategori'));
    }

    //Fungsi menyimpan berita
    public function store(Request $request)
    {
        //Validasi form
        $this->validate($request, [
            'judul' => 'required|min:5|max:255',
            'konten' => 'required',
            'gambar' => 'image|max:2048', //Format gambar yang didukung : jpeg, jpg, png, bmp, gif, svg
        ]);

        //Mengambil semua data input kecuali input file
        $inputBerita = $request->except('file');

        $gambar = $request->file('gambar'); //Mengambil input gambar
        $files = $request->file('file'); //Mengambil input file

        //Proses jika ada input gambar
        if($gambar!=null)
        {
            //Menamakan file gambar
            $nama = md5(microtime(true)).md5($gambar->getClientOriginalName()).'.'.$gambar->extension(); 

            //Memindahkan file gambar ke folder upload/gambar_berita
            $gambar->move(public_path('upload/gambar_berita'), $nama);

            //Resize dan save gambar ke folder upload/gambar_berita
            Image::make(public_path('upload/gambar_berita/'.$nama))->encode('jpg', 90)->resize(500, null, function($cons) {
            $cons->aspectRatio();
            $cons->upsize();
            })->save(public_path('upload/gambar_berita/'.$nama));

            //Meletakkan nilai gambar ke array
            $inputBerita['gambar'] = $nama;
        }      

        //Menyimpan data berita ke tb_berita
        $berita = Berita::create($inputBerita);   

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

                    //Memindahkan file ke folder upload/file_berita
                    $file->move(public_path('upload/file_berita'), $nama);
                      
                    //Input file ke tb_file_berita
                    FilesBerita::create([
                        'id_berita' => $berita->id,
                        'file' => $nama
                    ]);
                }
                else
                {   
                    //Pesan error 
                    $errors = "Format file yang didukung : doc, docx, xls, xlsx, ppt, pptx, pdf";

                    //Mengambil nama gambar
                    $gambar = Berita::where('id', $berita->id)->first()->gambar;
                        
                    //Hapus gambar
                    File::delete(public_path('upload/gambar_berita/'.$gambar));

                    //Hapus berita agar data tidak duplikat 
                    Berita::find($berita->id)->delete();

                    //Reload halaman
                    return redirect()->back()
                        ->withErrors($errors)
                        ->withInput($request->input());
                }
            }
        }

        //Redirect ke halaman indeks berita
        return redirect()->route('berita.index')
            ->with('feedback','<div class="alert alert-success"><p>Berita berhasil ditambah</p></div>');
    }

    public function show($id)
    {
        //Ambil data berita yang dipilih dari tb_berita
        $data = Berita::find($id);

        //Menampilkan data berita yang dipilih
        return view('admin.berita.show',compact('data'));
    }

    //Fungsi menampilkan view edit berita
    public function edit($id)
    {
        //Mengambil list kategori dari tb_kategori untuk ditampilkan ke Form::select
        $kategori = Kategori::pluck('nama', 'id');

        //Ambil data berita yang dipilih dari tb_berita
        $data = Berita::find($id);

        //Ambil daftar file dari tb_file_berita
        $daftarFile = FilesBerita::where('id_berita', $id)->get();

        //Menampilkan form edit
        return view('admin.berita.ubah',compact('data', 'kategori', 'daftarFile'));
    }

    //Fungsi update berita
    public function update(Request $request, $id)
    {
        //Validasi form
        $this->validate($request, [
            'judul' => 'required|min:5|max:255',
            'konten' => 'required',
            'gambar' => 'image|max:2048', //Format gambar yang didukung : jpeg, png, bmp, gif, svg
        ]);

        //Mengambil semua data input kecuali input file
        $inputBerita = $request->except('file');

        $gambar = $request->file('gambar'); //Mengambil input gambar
        $files = $request->file('file'); //Mengambil input file

        //Proses jika ada input gambar
        if($gambar!=null)
        {
            //Mengambil gambar lama
            $gambar_lama = Berita::where('id', $id)->first()->gambar;
            
            //Hapus gambar lama
            File::delete(public_path('upload/gambar_berita/'.$gambar_lama));

            //Menamakan file gambar baru
            $nama = md5(microtime(true)).md5($gambar->getClientOriginalName()).'.'.$gambar->extension();

            //Memindahkan file gambar baru ke folder upload/gambar_berita
            $gambar->move(public_path('upload/gambar_berita'), $nama);

            //Resize dan save gambar baru ke folder upload/gambar_berita
            Image::make(public_path('upload/gambar_berita/'.$nama))->encode('jpg', 90)->resize(500, null, function($cons) {
            $cons->aspectRatio();
            $cons->upsize();
            })->save(public_path('upload/gambar_berita/'.$nama));

            //Meletakkan nilai gambar ke array
            $inputBerita['gambar'] = $nama;
        }

        //Update data berita pada tb_berita
        Berita::find($id)->update($inputBerita); 

        //Proses jika ada input file
        if($files[0]!=null)
        {
            //Mengambil daftar file(s) lama 
            $files_lama = FilesBerita::where('id_berita', $id)->pluck('file');

            //Hapus file(s) lama
            foreach($files_lama as $file_lama)
            {
                File::delete(public_path('upload/file_berita/'.$file_lama));
            }

            //Hapus data file berita dari tb_file_berita
            FilesBerita::where('id_berita',$id)->delete();
    
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

                    //Memindahkan file ke folder upload/file_berita
                    $file->move(public_path('upload/file_berita'), $nama);
                      
                    //Input file ke tb_file_berita
                    FilesBerita::create([
                        'id_berita' => $id,
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

        //Redirect ke halaman indeks berita
        return redirect()->route('berita.index')
            ->with('feedback','<div class="alert alert-success"><p>Berita berhasil di update</p></div>');
    }
    
    //Fungsi hapus berita
    public function destroy($id)
    {
        //Mengambil nama gambar
        $gambar = Berita::where('id', $id)->first()->gambar;

        //Mengambil daftar file(s) 
        $files = FilesBerita::where('id_berita', $id)->pluck('file');

        //Hapus gambar
        File::delete(public_path('upload/gambar_berita/'.$gambar));

        //Hapus file(s)
        foreach($files as $file)
        {
            //Proses jika input file tidak kosong
            if($file!=null)
            {
                File::delete(public_path('upload/file_berita/'.$file));
            }
        }

        //Hapus data file berita dari tb_file_berita
        FilesBerita::where('id_berita', $id)->delete();

        //Hapus data berita dari tb_berita
        Berita::find($id)->delete();

        //Redirect ke halaman indeks berita
        return redirect()->route('berita.index')
            ->with('feedback','<div class="alert alert-success"><p>Berita berhasil dihapus</p></div>');
    }

}
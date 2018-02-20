<?php

/** 
*
* @author       : Hasan El Jabir <eljabirhasan@gmail.com>
* @copyright    : Gunadarma University Computing Center
* @contact      : 0812 8923 3370 
*
**/

namespace App\Http\Controllers;

use Image;
use File;
use App\Berita;
use App\FilesBerita;
use App\Kategori;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BeritaController extends Controller
{

    public function __construct()
    {
        //Autentifikasi
        $this->middleware('auth');
    }

    public function index()
    {
        //Nomor urut data pada view
        $number = 0;

        //Mengambil data berita
        $data = Berita::orderBy('id','DESC')->paginate(10);

        //Menampilkan data berita ke view
        return view('admin.berita.index',compact('data','number'));
    }

    public function create()
    {
        //Mengambil list kategori untuk ditampilkan ke Form::select
        $kategori = Kategori::pluck('nama', 'id');

        //Menampilkan view tambah berita
        return view('admin.berita.tambah', compact('kategori'));
    }

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

        //Proses jika ada input gambar
        if($gambar = $request->file('gambar'))
        {
            //Menamakan file gambar
            $nama = 'gambar_'.md5(microtime(true)).md5($gambar->getClientOriginalName()).'.'.$gambar->extension(); 

            //Memindahkan file gambar ke folder upload/gambar_berita
            $gambar->move(public_path('upload/gambar_berita'), $nama);

            //Resize dan save gambar ke folder upload/gambar_berita
            Image::make(public_path('upload/gambar_berita/'.$nama))->encode('jpg', 90)->resize(500, null, function($cons) {
            $cons->aspectRatio();
            $cons->upsize();
            })->save(public_path('upload/gambar_berita/'.$nama));

            //Input data ke database
            $inputBerita['gambar'] = $nama;
        }      

        //Menyimpan data berita ke tb_berita
        $berita = Berita::create($inputBerita);   

        //Proses jika ada input file
        if($files = $request->file('file'))
        {
            //Foreach digunakan karena input berupa array (Multiple files)
            foreach($files as $file)
            {
                //Proses jika input file tidak kosong
                if($file!=null)
                {
                    //Ambil ekstensi file 
                    $ext = $file->extension(); 

                    //Validasi tipe file
                    if($ext=='doc' || $ext=='docx' || $ext=='xls' || $ext=='xlsx' || $ext=='ppt' || $ext=='pptx' || $ext=='pdf')
                    {
                        //Menamakan file
                        $nama = $file->getClientOriginalName();

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

                        //Hapus berita agar data tidak duplikat 
                        Berita::find($berita->id)->delete();

                        //Reload halaman
                        return redirect()->back()
                            ->withErrors($errors)
                            ->withInput($request->input());
                    }
                }

            }
        }

        //Redirect ke halaman indeks berita
        return redirect()->route('berita.index')
            ->with('success','Berita berhasil ditambah');
    }

    public function show($id)
    {
        //Ambil data berita yang dipilih dari tb_berita
        $data = Berita::find($id);

        //Menampilkan data berita yang dipilih
        return view('admin.berita.show',compact('data'));
    }

    public function edit($id)
    {
        //Mengambil list kategori untuk ditampilkan ke Form::select
        $kategori = Kategori::pluck('nama', 'id');

        //Ambil data berita yang dipilih dari tb_berita
        $data = Berita::find($id);

        //Ambil daftar file
        $daftarFile = FilesBerita::where('id_berita', $id)->get();

        //Menampilkan form edit
        return view('admin.berita.ubah',compact('data', 'kategori', 'daftarFile'));
    }

    public function update(Request $request, $id)
    {
        //Validasi form
        $this->validate($request, [
            'judul' => 'required|min:5|max:255',
            'konten' => 'required',
            'gambar' => 'image|max:2048', //Format gambar yang didukung : jpeg, png, bmp, gif, svg
        ]);

        //Mengambil nama file gambar
        $file = Berita::where('id', $id)->first()->gambar;

        //Mengambil semua data input kecuali input file
        $inputBerita = $request->except('file');

        //Cek ada gambar atau tidak
        if($gambar = $request->file('gambar'))
        {
            //Hapus file gambar sebelumnya
            File::delete(public_path('upload/gambar_berita/'.$file));

            //Menamakan file gambar baru
            $nama = 'gambar_'.md5(microtime(true)).md5($gambar->getClientOriginalName()).'.'.$gambar->extension();

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

        // $berita = Berita::find($id)->with('fileBerita')->get(); dd($berita->toArray());      

        //Proses jika ada input file
        if($files = $request->file('file'))
        {
            // dd($files);
            //Foreach digunakan karena input berupa array (Multiple files)
            foreach($files as $file)
            {
                //Proses jika input file tidak kosong
                if($file!=null)
                {
                    //Ambil ekstensi file 
                    $ext = $file->extension(); 

                    //Validasi tipe file
                    if($ext=='doc' || $ext=='docx' || $ext=='xls' || $ext=='xlsx' || $ext=='ppt' || $ext=='pptx' || $ext=='pdf')
                    {
                        // //Mengambil daftar file(s) 
                        // $files_lama = FilesBerita::where('id_berita', $id)->pluck('file');

                        // //Hapus file(s)
                        // foreach($files_lama as $file_lama)
                        // {
                        //     File::delete(public_path('upload/file_berita/'.$file_lama));
                        // }

                        //Menamakan file
                        $nama = $file->getClientOriginalName();

                        //Memindahkan file ke folder upload/file_berita
                        $file->move(public_path('upload/file_berita'), $nama);
                      
                        // FilesBerita::where('id_berita', $id)->delete();

                        //Input file ke tb_file_berita
                        // FilesBerita::create([
                        //     'id_berita' => $id,
                        //     'file' => $nama,
                        // ]);

                        $inputFile['id_berita'] = $id;
                        $inputFile['file'] = $nama;
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
        }

        //Mengambil daftar file(s) 
        $files_lama = FilesBerita::where('id_berita', $id)->pluck('file');

        //Hapus file(s)
        foreach($files_lama as $file_lama)
        {
            File::delete(public_path('upload/file_berita/'.$file_lama));
        }

        FilesBerita::where('id_berita',$id)->delete();

        FilesBerita::create($inputFile);

        //Update data berita pada tb_berita
        Berita::find($id)->update($inputBerita); 

        //Redirect ke halaman indeks berita
        return redirect()->route('berita.index')
            ->with('success','Berita berhasil di update');
    }
    
    public function destroy($id)
    {
        //Mengambil nama gambar
        $gambar = Berita::where('id', $id)->first()->gambar;

        //Mengambil daftar file(s) 
        $files = FilesBerita::where('id_berita', $id)->pluck('file');
        // dd($files->toArray());

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
            ->with('success','Berita berhasil dihapus');
    }

}
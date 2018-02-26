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
use App\Publikasi; //Model publikasi
use App\FilesPublikasi; //Model file publikasi
use App\KomenPublikasi; //Model komentar publikasi
use Illuminate\Http\Request; //Library untuk request input
use App\Http\Controllers\Controller; //Controller Laravel 

class PublikasiController extends Controller
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

        //Mengambil data publikasi dari tb_publikasi
        $data = Publikasi::orderBy('id','DESC')->get();

        //Menampilkan data publikasi ke view
        return view('admin.publikasi.index',compact('data','number'));
    }

    //Fungsi menampilkan view tambah publikasi
    public function create()
    {
        //Menampilkan view tambah publikasi
        return view('admin.publikasi.tambah');
    }

    //Fungsi menyimpan publikasi
    public function store(Request $request)
    {
        //Validasi form
        $this->validate($request, [
            'judul' => 'required|min:5|max:255',
            'konten' => 'required',
            'gambar' => 'image|max:2048', //Format gambar yang didukung : jpeg, jpg, png, bmp, gif, svg
        ]);

        //Mengambil semua data input kecuali input file
        $inputPublikasi = $request->except('file');

        $gambar = $request->file('gambar'); //Mengambil input gambar
        $files = $request->file('file'); //Mengambil input file

        //Proses jika ada input gambar
        if($gambar!=null)
        {
            //Menamakan file gambar
            $nama = md5(microtime(true)).md5($gambar->getClientOriginalName()).'.'.$gambar->extension(); 

            //Memindahkan file gambar ke folder upload/gambar_publikasi
            $gambar->move(public_path('upload/gambar_publikasi'), $nama);

            //Resize dan save gambar ke folder upload/gambar_publikasi
            Image::make(public_path('upload/gambar_publikasi/'.$nama))->encode('jpg', 90)->resize(500, null, function($cons) {
            $cons->aspectRatio();
            $cons->upsize();
            })->save(public_path('upload/gambar_publikasi/'.$nama));

            //Meletakkan nilai gambar ke array
            $inputPublikasi['gambar'] = $nama;
        }      

        //Menyimpan data publikasi ke tb_publikasi
        $publikasi = Publikasi::create($inputPublikasi);   

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

                    //Memindahkan file ke folder upload/file_publikasi
                    $file->move(public_path('upload/file_publikasi'), $nama);
                      
                    //Input file ke tb_file_publikasi
                    FilesPublikasi::create([
                        'id_publikasi' => $publikasi->id,
                        'file' => $nama
                    ]);
                }
                else
                {   
                    //Pesan error 
                    $errors = "Format file yang didukung : doc, docx, xls, xlsx, ppt, pptx, pdf";

                    //Mengambil nama gambar
                    $gambar = Publikasi::where('id', $publikasi->id)->first()->gambar;
                        
                    //Hapus gambar
                    File::delete(public_path('upload/gambar_publikasi/'.$gambar));

                    //Hapus publikasi agar data tidak duplikat 
                    Publikasi::find($publikasi->id)->delete();

                    //Reload halaman
                    return redirect()->back()
                        ->withErrors($errors)
                        ->withInput($request->input());
                }
            }
        }

        //Redirect ke halaman indeks publikasi
        return redirect()->route('publikasi.index')
            ->with('feedback','<div class="alert alert-success"><p>Publikasi berhasil ditambah</p></div>');
    }

    //Fungsi menampilkan daftar komentar publikasi
    public function show($id)
    {
        //Nomor urut data pada view
        $number = 0;

        //Ambil data komentar publikasi dari tb_komen_publikasi
        $data = KomenPublikasi::where('id_publikasi', $id)->get();

        //Menampilkan data komentar pada publikasi yang dipilih
        return view('admin.publikasi.komen',compact('data', 'number'));
    }

    //Fungsi menampilkan view edit publikasi
    public function edit($id)
    {
        //Ambil data publikasi yang dipilih dari tb_publikasi
        $data = Publikasi::find($id);

        //Ambil daftar file dari tb_file_publikasi
        $daftarFile = FilesPublikasi::where('id_publikasi', $id)->get();

        //Menampilkan form edit
        return view('admin.publikasi.ubah',compact('data', 'daftarFile'));
    }

    //Fungsi update publikasi
    public function update(Request $request, $id)
    {
        //Validasi form
        $this->validate($request, [
            'judul' => 'required|min:5|max:255',
            'konten' => 'required',
            'gambar' => 'image|max:2048', //Format gambar yang didukung : jpeg, png, bmp, gif, svg
        ]);

        //Mengambil semua data input kecuali input file
        $inputPublikasi = $request->except('file');

        $gambar = $request->file('gambar'); //Mengambil input gambar
        $files = $request->file('file'); //Mengambil input file

        //Proses jika ada input gambar
        if($gambar!=null)
        {
            //Mengambil gambar lama
            $gambar_lama = Publikasi::where('id', $id)->first()->gambar;
            
            //Hapus gambar lama
            File::delete(public_path('upload/gambar_publikasi/'.$gambar_lama));

            //Menamakan file gambar baru
            $nama = md5(microtime(true)).md5($gambar->getClientOriginalName()).'.'.$gambar->extension();

            //Memindahkan file gambar baru ke folder upload/gambar_publikasi
            $gambar->move(public_path('upload/gambar_publikasi'), $nama);

            //Resize dan save gambar baru ke folder upload/gambar_publikasi
            Image::make(public_path('upload/gambar_publikasi/'.$nama))->encode('jpg', 90)->resize(500, null, function($cons) {
            $cons->aspectRatio();
            $cons->upsize();
            })->save(public_path('upload/gambar_publikasi/'.$nama));

            //Meletakkan nilai gambar ke array
            $inputPublikasi['gambar'] = $nama;
        }

        //Update data publikasi pada tb_publikasi
        Publikasi::find($id)->update($inputPublikasi); 

        //Proses jika ada input file
        if($files[0]!=null)
        {
            //Mengambil daftar file(s) lama 
            $files_lama = FilesPublikasi::where('id_publikasi', $id)->pluck('file');

            //Hapus file(s) lama
            foreach($files_lama as $file_lama)
            {
                File::delete(public_path('upload/file_publikasi/'.$file_lama));
            }

            //Hapus data file publikasi dari tb_file_publikasi
            FilesPublikasi::where('id_publikasi',$id)->delete();
    
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

                    //Memindahkan file ke folder upload/file_publikasi
                    $file->move(public_path('upload/file_publikasi'), $nama);
                      
                    //Input file ke tb_file_publikasi
                    FilesPublikasi::create([
                        'id_publikasi' => $id,
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

        //Redirect ke halaman indeks publikasi
        return redirect()->route('publikasi.index')
            ->with('feedback','<div class="alert alert-success"><p>Publikasi berhasil di update</p></div>');
    }
    
    //Fungsi hapus publikasi
    public function destroy($id)
    {
        //Mengambil nama gambar
        $gambar = Publikasi::where('id', $id)->first()->gambar;

        //Mengambil daftar file(s) 
        $files = FilesPublikasi::where('id_publikasi', $id)->pluck('file');

        //Hapus gambar
        File::delete(public_path('upload/gambar_publikasi/'.$gambar));

        //Hapus file(s)
        foreach($files as $file)
        {
            //Proses jika input file tidak kosong
            if($file!=null)
            {
                File::delete(public_path('upload/file_publikasi/'.$file));
            }
        }

        //Hapus data file publikasi dari tb_file_publikasi
        FilesPublikasi::where('id_publikasi', $id)->delete();

        //Hapus data publikasi dari tb_publikasi
        Publikasi::find($id)->delete();

        //Redirect ke halaman indeks publikasi
        return redirect()->route('publikasi.index')
            ->with('feedback','<div class="alert alert-success"><p>Publikasi berhasil dihapus</p></div>');
    }

}
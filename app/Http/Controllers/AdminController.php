<?php

/** 
*
* @author       : Hasan El Jabir <eljabirhasan@gmail.com>
* @copyright    : Gunadarma University Computing Center
* @contact      : 0812 8923 3370 
*
**/

namespace App\Http\Controllers;

use Auth; //Laravel Auth
use App\Role; //Model role
use App\User; //Model user
use Illuminate\Http\Request; //Library untuk request input
use App\Http\Controllers\Controller; //Controller Laravel 

class AdminController extends Controller
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

        //Mengambil daftar admin dari tabel users
    	$data = User::where('id_role', '<', 3)->orderBy('id', 'DESC')->with('role')->get();

        //Menampilkan daftar admin ke view
        return view('admin.admin.index', compact('data', 'number'));
    }

    //Fungsi menampilkan view tambah user
    public function create()
    {
        //Mengambil daftar role dari tb_role
        $role = Role::where('id', '<', 3)->pluck('nama', 'id');

        //Menampilkan view tambah admin
        return view('admin.admin.tambah', compact('role'));
    }

    //Fungsi menyimpan admin baru
    public function store(Request $request)
    {
        //Validasi form
        $this->validate($request, [
            'name' => 'required|max:255',
            'username' => 'required|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        //Mengambil semua data input
        $input = [
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')), //Enkripsi password
            'id_role' => $request->input('id_role'),
        ];

        //Menyimpan data admin
        User::create($input); 

        //Redirect ke halaman indeks admin
        return redirect()->route('admin.index')
            ->with('feedback','<div class="alert alert-success"><p>Admin berhasil ditambah</p></div>');
    }

    //Fungsi menampilkan view edit user
    public function edit($id)
    {
        //Ambil data admin yang dipilih dari tabel users
        $data = User::find($id);

        //Mengambil daftar role dari tb_role
        $role = Role::where('id', '<', 3)->pluck('nama', 'id');
        
        //Menampilkan form edit
        return view('admin.admin.ubah',compact('data', 'role'));
    }

    //Fungsi update admin
    public function update(Request $request, $id)
    {
        //Ambil username dan email lama
        $username_lama = User::where('id', $id)->first()->username;
        $email_lama = User::where('id', $id)->first()->email;

        //Ambil username dan email inputan
        $username = $request->input('username');
        $email = $request->input('email');
        
        //Input jika username dan email masih sama
        if($username==$username_lama && $email==$email_lama)
        {
            //Validasi form
            $this->validate($request, [
                'name' => 'required|max:255',
                'password' => 'required|min:6|confirmed', //Enkripsi Password
            ]);

            //Definisi inputan
            $input = [
                'name' => $request->input('name'),
                'password' => bcrypt($request->input('password')), //Enkripsi password
                'id_role' => $request->input('id_role'),
            ];
        }
        //Input jika username masih sama
        else if($username==$username_lama) 
        {
            //Validasi form
            $this->validate($request, [
                'name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|min:6|confirmed',
            ]);

            //Definisi inputan
            $input = [
                'name' => $request->input('name'),
                'email' => $email,
                'password' => bcrypt($request->input('password')), //Enkripsi password
                'id_role' => $request->input('id_role'),
            ];
        }
        //Input jika email masih sama
        else if($email==$email_lama) 
        {
            //Validasi form
            $this->validate($request, [
                'name' => 'required|max:255',
                'username' => 'required|max:255|unique:users',
                'password' => 'required|min:6|confirmed',
            ]);

            //Definisi inputan
            $input = [
                'name' => $request->input('name'),
                'username' => $username,
                'password' => bcrypt($request->input('password')), //Enkripsi password
                'id_role' => $request->input('id_role'),
            ];
        }
        //Input jika username dan email diganti
        else
        {
            //Validasi form
            $this->validate($request, [
                'name' => 'required|max:255',
                'username' => 'required|max:255|unique:users',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|min:6|confirmed',
            ]);
            //Definisi inputan
            $input = [
                'name' => $request->input('name'),
                'username' => $username,
                'email' => $email,
                'password' => bcrypt($request->input('password')), //Enkripsi password
                'id_role' => $request->input('id_role'),
            ];
        }

        //Update data admin
        User::find($id)->update($input);    
        
        //Redirect ke halaman indeks admin
        return redirect()->route('admin.index')
            ->with('success','<div class="alert alert-success"><p>Admin berhasil di update</p></div>');
    }

    //Fungsi hapus user
    public function destroy($id)
    {
        //Ambil id user yang sedang log in
        $logged_in = Auth::user()->id;

        //Jika user sedang login
        if($id==$logged_in)
        {
            //Redirect ke halaman indeks admin
            return redirect()->route('admin.index')
                ->with('feedback','<div class="alert alert-danger"><p>GAGAL - ANDA SEDANG LOGIN !</p></div>');
        }

        //Hapus admin
        User::find($id)->delete();

        //Redirect ke halaman indeks admin
        return redirect()->route('admin.index')
            ->with('feedback','<div class="alert alert-success"><p>Admin berhasil dihapus</p></div>');
    }

}
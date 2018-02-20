<?php

/** 
*
* @author       : Hasan El Jabir <eljabirhasan@gmail.com>
* @copyright    : Gunadarma University Computing Center
* @contact      : 0812 8923 3370 
*
**/

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
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

        //Mengambil daftar admin
    	$data = User::where('id_role', '<', 3)->orderBy('id', 'DESC')->with('role')->get();

        // dd($data->toArray());

        //Menampilkan daftar admin ke view
        return view('admin.admin.index', compact('data', 'number'));
    }

    public function create()
    {
        //Mengambil daftar role
        $role = Role::where('id', '<', 3)->pluck('nama', 'id');

        //Menampilkan view tambah admin
        return view('admin.admin.tambah', compact('role'));
    }

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
            ->with('success','Admin berhasil ditambah');
    }

    public function edit($id)
    {
        //Ambil data admin yang dipilih
        $data = User::find($id);

        //Mengambil daftar role
        $role = Role::where('id', '<', 3)->pluck('nama', 'id');
        
        //Menampilkan form edit
        return view('admin.admin.ubah',compact('data', 'role'));
    }

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
            ->with('success','Admin berhasil di update');
    }

    public function destroy($id)
    {
        //Ambil id user yang sedang log in
        $logged_in = Auth::user()->id;

        //Jika user sedang login
        if($id==$logged_in)
        {
            //Redirect ke halaman indeks admin
            return redirect()->route('admin.index')->with('success','GAGAL - ANDA SEDANG LOGIN !');
        }

        //Hapus admin
        User::find($id)->delete();

        //Redirect ke halaman indeks admin
        return redirect()->route('admin.index')->with('success','Admin berhasil dihapus');
    }

}
<?php

/** 
*
* @author       : Hasan El Jabir <eljabirhasan@gmail.com>
* @copyright    : Gunadarma University Computing Center
* @contact      : 0812 8923 3370 
*
**/

namespace App;

use Illuminate\Database\Eloquent\Model; //Model Laravel

class Artikel extends Model
{
	protected $table = 'tb_artikel'; //Koneksi ke tb_artikel
	
    //Kolom yang dapat diisi
    public $fillable = ['penulis', 'judul', 'konten', 'gambar', 'file', 'status', 'id_kategori'];

    //Satu artikel punya satu kategori
    public function kategori()
    {
        return $this->hasOne('App\Kategori', 'id', 'id_kategori');
    }

    //Satu artikel bisa punya banyak file 
    public function fileArtikel()
    {
        return $this->hasMany('App\FilesArtikel', 'id_artikel', 'id');
    }

    //Satu artikel bisa punya banyak komentar
    public function komenArtikel()
    {
        return $this->hasMany('App\FilesArtikel', 'id_artikel', 'id');
    }
}

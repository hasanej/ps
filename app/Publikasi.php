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

class Publikasi extends Model
{
	protected $table = 'tb_publikasi'; //Koneksi ke tb_publikasi
	
    //Kolom yang dapat diisi
    public $fillable = ['penulis', 'judul', 'konten', 'gambar', 'file', 'status', 'id_kategori'];

    //Satu publikasi bisa punya banyak file 
    public function filePublikasi()
    {
        return $this->hasMany('App\FilesPublikasi', 'id_publikasi', 'id');
    }
}

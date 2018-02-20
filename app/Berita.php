<?php

/** 
*
* @author       : Hasan El Jabir <eljabirhasan@gmail.com>
* @copyright    : Gunadarma University Computing Center
* @contact      : 0812 8923 3370 
*
**/

namespace App;

use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
	protected $table = 'tb_berita';
	
    public $fillable = ['penulis', 'judul', 'konten', 'gambar', 'file', 'status', 'id_kategori'];

    public function kategori()
    {
        return $this->hasOne('App\Kategori', 'id', 'id_kategori');
    }

    public function fileBerita()
    {
        return $this->hasMany('App\FilesBerita', 'id_berita', 'id');
    }
}

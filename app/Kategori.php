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

class Kategori extends Model
{
    protected $table = 'tb_kategori'; //Koneksi ke tb_kategori

    public $fillable = ['nama']; //Kolom yang dapat diisi

    //Reverse relationship ke berita
    public function berita()
    {
        return $this->belongsTo('App\Berita', 'id_kategori', 'id');
    }

    //Reverse relationship ke artikel
    public function artikel()
    {
        return $this->belongsTo('App\Artikel', 'id_kategori', 'id');
    }
}

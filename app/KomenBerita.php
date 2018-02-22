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

class KomenBerita extends Model
{
	protected $table = 'tb_komen_berita'; //Koneksi ke tb_komen_berita

    protected $fillable = ['id_berita', 'user', 'komentar']; //Kolom yang dapat diisi

    //Reverse relationship ke berita
    public function berita()
    {
    	return $this->belongsTo('App\Berita', 'id', 'id_berita');
    }
}

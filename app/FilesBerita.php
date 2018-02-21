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

class FilesBerita extends Model
{
	protected $table = 'tb_file_berita'; //Koneksi ke tb_file_berita

    //Kolom yang dapat diisi
    public $fillable = ['file', 'id_berita'];

    //Reverse relationship ke berita
    public function berita()
    {
        return $this->belongsTo('App\Berita', 'id', 'id_berita');
    }
}

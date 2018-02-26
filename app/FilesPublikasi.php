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

class FilesPublikasi extends Model
{
	protected $table = 'tb_file_publikasi'; //Koneksi ke tb_file_publikasi

    //Kolom yang dapat diisi
    public $fillable = ['file', 'id_publikasi'];

    //Reverse relationship ke publikasi
    public function publikasi()
    {
        return $this->belongsTo('App\Publikasi', 'id', 'id_publikasi');
    }
}

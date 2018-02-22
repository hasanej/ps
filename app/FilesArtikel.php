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

class FilesArtikel extends Model
{
	protected $table = 'tb_file_artikel'; //Koneksi ke tb_file_artikel

    //Kolom yang dapat diisi
    public $fillable = ['file', 'id_artikel'];

    //Reverse relationship ke artikel
    public function artikel()
    {
        return $this->belongsTo('App\Artikel', 'id', 'id_artikel');
    }
}

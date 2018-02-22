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

class KomenArtikel extends Model
{
	protected $table = 'tb_komen_artikel'; //Koneksi ke tb_komen_artikel

    protected $fillable = ['id_artikel', 'user', 'komentar']; //Kolom yang dapat diisi

    //Reverse relationship ke artikel
    public function artikel()
    {
    	return $this->belongsTo('App\Artikel', 'id', 'id_artikel');
    }
}

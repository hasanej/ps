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

class Kategori extends Model
{
    protected $table = 'tb_kategori';

    public $fillable = ['nama'];

    public function berita()
    {
        return $this->belongsTo('App\Berita', 'id_kategori', 'id');
    }

    public function artikel()
    {
        return $this->belongsTo('App\Artikel', 'id_kategori', 'id');
    }
}

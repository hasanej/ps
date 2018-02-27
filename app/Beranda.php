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

class Beranda extends Model
{
    protected $table = 'tb_beranda'; //Koneksi ke tb_beranda
 
    protected $fillable = ['judul', 'konten']; //Kolom yang dapat diisi
}

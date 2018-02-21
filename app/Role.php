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

class Role extends Model
{
    protected $table = 'tb_role'; //Koneksi ke tb_role

    //Reverse relation ke user
    public function user()
    {
    	return $this->belongsTo('App\User', 'id_role', 'id');
    }
}

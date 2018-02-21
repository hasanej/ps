<?php

/** 
*
* @author       : Hasan El Jabir <eljabirhasan@gmail.com>
* @copyright    : Gunadarma University Computing Center
* @contact      : 0812 8923 3370 
*
**/

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable; //Laravel Auth

class User extends Authenticatable
{
    protected $fillable = ['name', 'username', 'email', 'password', 'id_role']; //Kolom yang dapat diisi

    protected $hidden = ['password', 'remember_token',]; 

    //Setiap user punya satu role
    public function role()
    {
        return $this->hasOne('App\Role', 'id', 'id_role');
    }
}

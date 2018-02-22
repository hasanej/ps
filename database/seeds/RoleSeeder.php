<?php

/** 
*
* @author       : Hasan El Jabir <eljabirhasan@gmail.com>
* @copyright    : Gunadarma University Computing Center
* @contact      : 0812 8923 3370 
*
**/

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tb_role')->delete();

        DB::table('tb_role')->insert(array(
            array('nama'=>'Superadmin'),
            array('nama'=>'Admin'),
            array('nama'=>'User'),
        ));
    }
}

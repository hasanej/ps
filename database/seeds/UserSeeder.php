<?php

/** 
*
* @author       : Hasan El Jabir <eljabirhasan@gmail.com>
* @copyright    : Gunadarma University Computing Center
* @contact      : 0812 8923 3370 
*
**/

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        $faker = Faker\Factory::create();

        for ($i = 0; $i < 100; $i++)
		{
  			$user = User::create(array(
                'name' => $faker->firstName,
	    		'username' => str_random(5),
	    		'email' => $faker->email,
	    		'password' => $faker->word,
	    		'id_role' => mt_rand(1,3)
  			));
		}
    }
}

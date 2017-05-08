<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
	    $admin = User::where('name', 'admin')->first();
	    if(empty($admin)){
		    $admin = User::create([
		    	'name' => 'admin',
			    'password' =>  bcrypt('admin123!'),
			    'status' => 1,
		    ]);
	    }

    }
}

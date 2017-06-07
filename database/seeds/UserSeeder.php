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
			    'password' =>  md5('888888'),
			    'status' => 1,
		    ]);
	    }

	    $role = \App\Models\Role::where('name', 'admin');
	    if(empty($role)){
	    	$role = \App\Models\Role::create([
	    		'name' => 'admin',
			    'display_name' => '超级管理员',
			    'description' => '超级管理员',
		    ]);
	    }

	    $admin->roles()->sync([$role->id]);
    }
}

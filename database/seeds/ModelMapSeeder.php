<?php

use Illuminate\Database\Seeder;
use App\Models\ModelMap;

class ModelMapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        $entities = ModelMap::all();
//        if(!empty($entities)) {
//            $entities->each(function ($item) {
//                $item->delete();
//            });
//        }
        //
	    $exists = ModelMap::where('model', 'Employee')->count();
	    if($exists == 0) {
		    ModelMap::create([
			    'model' => 'Employee',
			    'table' => 'bd_employees',
			    'foreign_table' => 'bd_employees'
		    ]);
	    }

	    $exists = ModelMap::where('model', 'Attendance')->count();
	    if($exists == 0) {
		    ModelMap::create([
			    'model' => 'Attendance',
			    'table' => 'ms_attendances',
			    'foreign_table' => 'ms_attendances'
		    ]);
	    }

	    $exists = ModelMap::where('model', 'Store')->count();
	    if($exists == 0) {
		    ModelMap::create([
			    'model' => 'Store',
			    'table' => 'st_stores',
			    'foreign_table' => 'st_stores'
		    ]);
	    }

	    $exists = ModelMap::where('model', 'DisplayPolicyStore')->count();
	    if($exists == 0) {
		    ModelMap::create([
			    'model' => 'DisplayPolicyStore',
			    'table' => 'exp_display_policy_store',
			    'foreign_table' => 'exp_display_policy_store'
		    ]);
	    }

    }
}

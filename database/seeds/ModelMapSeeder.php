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
        $entities = ModelMap::all();
        if(!empty($entities)) {
            $entities->each(function ($item) {
                $item->delete();
            });
        }
        //
        ModelMap::create([
            'model' => 'Employee',
            'table' => 'bd_employees',
            'foreign_table' => 'bd_employees'
        ]);
        ModelMap::create([
            'model' => 'Attendance',
            'table' => 'ms_attendances',
            'foreign_table' => 'ms_attendances'
        ]);
        ModelMap::create([
            'model' => 'Store',
            'table' => 'st_stores',
            'foreign_table' => 'st_stores'
        ]);
	    ModelMap::create([
		    'model' => 'DisplayPolicyStore',
		    'table' => 'exp_display_policy_store',
		    'foreign_table' => 'exp_display_policy_store'
	    ]);
	    ModelMap::create([
		    'model' => 'StockIn',
		    'table' => 'st_stock_ins',
		    'foreign_table' => 'st_stock_ins'
	    ]);
	    ModelMap::create([
		    'model' => 'StockInItem',
		    'table' => 'st_stock_in_items',
		    'foreign_table' => 'st_stock_in_items'
	    ]);
    }
}

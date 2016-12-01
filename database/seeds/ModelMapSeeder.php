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
    }
}

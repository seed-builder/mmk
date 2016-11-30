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
            'foreign_table' => 'T_BD_EmpInfo'
        ]);


    }
}

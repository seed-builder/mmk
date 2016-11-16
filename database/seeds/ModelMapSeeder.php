<?php

use Illuminate\Database\Seeder;

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
        DB::table('sys_model_maps')->insert([
            'model' => 'Employee',
            'table' => 'bd_employees',
            'foreign_table' => 'T_BD_EmpInfo'
        ]);


    }
}

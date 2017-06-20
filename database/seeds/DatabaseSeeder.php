<?php

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(ModelMapSeeder::class);
         $this->call(SysConfigSeeder::class);
         $this->call(WorkFlowSeeder::class);
         //$this->call(HolidaySeeder::class);
//	    $this->call(SysCrontabSeeder::class);
//	    $this->call(UserSeeder::class);
    }
}

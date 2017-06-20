<?php

use App\Models\SysConfig;
use Illuminate\Database\Seeder;

class SysConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
	    $exists = SysConfig::where('name', 'app-data-isolate')->count();
	    if($exists == 0) {
		    SysConfig::create([
			    'name' => 'app-data-isolate',
			    'desc' => 'app端数据隔离',
			    'value' => 'Employee,Customer,Attendance,Store',
			    'status' => 1
		    ]);
	    }

	    $exists = SysConfig::where('name', 'mgt-data-isolate')->count();
	    if($exists == 0) {
		    SysConfig::create([
			    'name' => 'mgt-data-isolate',
			    'desc' => '后端数据隔离',
			    'value' => 'Employee,Customer,Attendance,Store',
			    'status' => 1
		    ]);
	    }

	    $exists = SysConfig::where('name', 'no-data-isolate-employees')->count();
	    if($exists == 0) {
		    SysConfig::create([
			    'name' => 'no-data-isolate-employees',
			    'desc' => '不受数据隔离限制的员工',
			    'value' => '',
			    'status' => 1
		    ]);
	    }

	    $exists = SysConfig::where('name', 'sale-variable')->count();
	    if($exists == 0) {
		    SysConfig::create([
			    'name' => 'sale-variable',
			    'desc' => '建议销售系数',
			    'value' => '1.1',
			    'status' => 1
		    ]);
	    }

	    $exists = SysConfig::where('name', 'store-visit-distance')->count();
	    if($exists == 0) {
		    SysConfig::create([
			    'name' => 'store-visit-distance',
			    'desc' => '门店拜访控制距离(单位米)',
			    'value' => '50',
			    'status' => 1
		    ]);
	    }


    }
}

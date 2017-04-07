<?php

use App\Models\SysCrontab;
use Illuminate\Database\Seeder;

class SysCrontabSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    $entities = SysCrontab::all();
	    if(!empty($entities)) {
		    $entities->each(function ($item) {
			    $item->delete();
		    });
	    }
	    //
        //

	    SysCrontab::create([
		    'name' => 'attendance_polling',
		    'command' => 'command:attendance_polling',
		    'desc' => '日完成提醒'
	    ]);

	    SysCrontab::create([
		    'name' => 'att-stc',
		    'command' => 'gen:att-stc',
		    'desc' => '生成考勤统计'
	    ]);

	    SysCrontab::create([
		    'name' => 'att-rpt',
		    'command' => 'gen:att-rpt',
		    'desc' => '生成考勤月报表'
	    ]);

	    SysCrontab::create([
		    'name' => 'visit-calendar-week',
		    'command' => 'function',
		    'desc' => '每周日00:00执行 生成下一周的拜访日记'
	    ]);

	    SysCrontab::create([
		    'name' => 'visit-calendar-day',
		    'command' => 'function',
		    'desc' => '每天00:00点执行 生成拜访日记'
	    ]);

	    SysCrontab::create([
		    'name' => 'check-store-signed',
		    'command' => 'function',
		    'desc' => '每天01:00点执行, 检查更新门店每天的签约状态 '
	    ]);

	    SysCrontab::create([
		    'name' => 'check-stock',
		    'command' => 'function',
		    'desc' => '每天01:00点执行, 自动审核库存盘点数据 '
	    ]);

    }
}

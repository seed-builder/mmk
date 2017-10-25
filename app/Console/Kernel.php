<?php

namespace App\Console;

use App\Models\Busi\DisplayPolicyStore;
use App\Models\Busi\SaleOrder;
use App\Models\Busi\Store;
use App\Models\Busi\VisitLine;
use App\Models\Busi\VisitLineCalendar;
use App\Models\Busi\VisitLineStore;
use App\Models\SysCrontab;
use App\Services\VisitCalendar;
use App\Services\VisitCalendarService;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
        'App\Console\Commands\SwaggerGen',
        'App\Console\Commands\AttendancePolling',
        'App\Console\Commands\AttRepoortGen',
        'App\Console\Commands\AttStatisticGen',
        'App\Console\Commands\ClearEmptyOrder',

    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
	    //下午18点开始每小时执行一次
	    $schedule->command('command:attendance_polling')->cron('10 18-22/1 * * *');
	    $schedule->command('gen:att-stc')->dailyAt('01:10');
	    $schedule->command('gen:att-rpt')->dailyAt('02:10');
	    $schedule->command('clear:empty-order')->dailyAt('00:01');

	    //每周日00:00执行 生成下一周的拜访日记
        $schedule->call(function(VisitCalendarService $calendar){
            for ($fnumber=1;$fnumber<=7;$fnumber++){
                $calendar->byDay(date('Y-m-d',strtotime('+'.$fnumber.' day')));
            }
	        SysCrontab::exec('visit-calendar-week');
        })->weekly();

        //每天00:00点执行 生成拜访日记
        $schedule->call(function(VisitCalendarService $calendar){
            $calendar->byDay(date('Y-m-d'));
	        SysCrontab::exec('visit-calendar-day');
        })->dailyAt('00:00');

	    //每天01:00点执行, 检查更新门店每天的签约状态 及 自动审核库存盘点数据；
        $schedule->call(function(){
			//自动审核库存盘点数据
	        DB::update('update st_stocks set fdocument_status=?,fcheck_type=?,fcheck_date=?,fchecker=? where fdocument_status=? ', ['C','A',date('Y-m-d H:i:s'),'system','A']);
	        SysCrontab::exec('check-stock');

	        DB::update('update st_stores set fis_signed = ?', [0]);
	        $now = date('Y-m-d');
	        //取得当前有效的签约
	        $policies = DisplayPolicyStore::where('fstatus', 1)
		        ->where('fstart_date', '<=', $now)
		        ->where('fend_date', '>=', $now)
		        ->get();
	        if(!empty($policies)){
		        foreach ($policies as $policy) {
			        $store = $policy->store;
			        $store->fis_signed = 1;
			        $store->save();
		        }
	        }
	        SysCrontab::exec('check-store-signed');

        })->dailyAt('01:00');

	    //每天02:00点执行 删除过期的空订单
//	    $schedule->call(function(){
//		    $results = DB::select('select o.id from st_sale_orders o where NOT EXISTS (select 1 from st_sale_order_items item where item.fsale_order_id = o.id)');
//			if(!empty($results)){
//				$ids = [];
//				foreach ($results as $res){
//					$ids[] = $res->id;
//				}
//				SaleOrder::destroy($ids);
//			}
//	    })->dailyAt('02:00');

    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}

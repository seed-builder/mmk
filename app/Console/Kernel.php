<?php

namespace App\Console;

use App\Models\Busi\VisitLine;
use App\Models\Busi\VisitLineCalendar;
use App\Models\Busi\VisitLineStore;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

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
	    $schedule->command('command:attendance_polling')->cron('10 18-23/1 * * *');
	    $schedule->command('gen:att-stc')->dailyAt('22:00');
	    $schedule->command('gen:att-rpt')->dailyAt('23:00');

	    //每周日00:00执行 生成下一周的拜访日记
        $schedule->call(function(VisitLineCalendar $calendar){
            for ($fnumber=1;$fnumber<=7;$fnumber++){
                $line = VisitLine::query()->where('fnumber',$fnumber)->first();
                $vls = VisitLineStore::query()->where('fline_id',$line->id)->get();
                $fdate = date('Y-m-d',strtotime('+'.$fnumber.' day'));

                foreach ($vls as $v){
                    $calendar->makeCalendar($v->femp_id,$line->id,$fdate);
                }
            }

        })->weekly();

        //每天00:00点执行 生成拜访日记
//        $schedule->call(function(VisitLineCalendar $calendar){
//            $fnumber = date("w");
//            $line = VisitLine::query()->where('fnumber',$fnumber)->first();
//            $vls = VisitLineStore::query()->where('fline_id',$line->id)->get();
//            foreach ($vls as $v){
//                $calendar->makeCalendar($v->femp_id,$line->id,date('Y-m-d H:i:s'));
//            }
//
//        })->dailyAt('00:00');
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

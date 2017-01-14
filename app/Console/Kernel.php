<?php

namespace App\Console;

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

<?php

namespace App\Listeners;

use App\Events\EmployeeLoginedEvent;
use App\Models\Busi\Employee;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmployeeLoginedHandler implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  EmployeeLoginedEvent  $event
     * @return void
     */
    public function handle(EmployeeLoginedEvent $event)
    {
        //
	    $emp = Employee::find($event->employee_id);
	    if(!empty($emp)) {
		    $emp->device_sn = $event->sn;
		    $emp->device = $event->device;
		    $emp->login_time += 1;
		    $emp->save();
	    }
    }
}

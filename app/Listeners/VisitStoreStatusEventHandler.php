<?php

namespace App\Listeners;

use App\Events\VisitStoreStatusChangedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Busi\VisitStoreCalendar;
use App\Models\Busi\VisitLineCalendar;
use Log;

class VisitStoreStatusEventHandler implements ShouldQueue
{
	use InteractsWithQueue;
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
     * @param  VisitStoreStatusChangedEvent  $event
     * @return void
     */
    public function handle(VisitStoreStatusChangedEvent $event)
    {
	    Log::info('VisitStoreStatusEventHandler , model = ' . json_encode($event->model));
    	if($event->model->fstatus > 1) {
		    //
		    $lineCalendar = VisitLineCalendar::find($event->model->fline_calendar_id);
		    if ($event->model->fstatus == 2) {
			    $lineCalendar->fstatus = 2;
			    $lineCalendar->save();
		    } elseif ($event->model->fstatus == 3) {
			    $count = VisitStoreCalendar::where('fline_calendar_id', $event->model->fline_calendar_id)->where('fstatus', '<', 3)->count();
			    if ($count == 0) {
				    $lineCalendar->fstatus = 3;
				    $lineCalendar->save();
			    }
		    }
	    }
    }
}

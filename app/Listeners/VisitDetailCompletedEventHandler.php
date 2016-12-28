<?php

namespace App\Listeners;

use App\Events\VisitDetailCompletedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Busi\VisitTodoCalendar;

class VisitDetailCompletedEventHandler
{
	private $completeStatus = 3;
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
     * @param  VisitDetailCompletedEvent  $event
     * @return void
     */
    public function handle(VisitDetailCompletedEvent $event)
    {
        //
		if($event->visit_todo_calendar_id){
			$todoCalendar = VisitTodoCalendar::find($event->visit_todo_calendar_id);
			$todoCalendar->fstatus = $this->completeStatus;
			$todoCalendar->save();
		}
    }
}

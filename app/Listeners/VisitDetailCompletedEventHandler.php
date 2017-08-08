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
			$needDos = $todoCalendar->checkEnd();
			if($needDos == 0) {
				$todoCalendar->fstatus = $this->completeStatus;
				$todoCalendar->save();
			}
		}
    }

//	public function checkEnd($todoCalendar){
//		$needDos = 0;
//		//拜访总结 - 结束
//		if(!empty($todoCalendar->todo) && $todoCalendar->todo->ffunction_number == 'JSBF'){
//			$needDos = VisitTodoCalendar::where('fstore_calendar_id', $todoCalendar->fstore_calendar_id)
//				->where('fparent_id', 0)
//				->where('fis_must_visit', 1)
//				->where('fstatus', '<', 3)
//				->where('id', '<>', $todoCalendar->id)
//				->count();
//		}
//		return $needDos;
//	}


}

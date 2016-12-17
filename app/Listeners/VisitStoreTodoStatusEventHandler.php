<?php

namespace App\Listeners;

use App\Events\VisitTodoStatusChangedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Busi\VisitStoreCalendar;
use App\Models\Busi\VisitTodoCalendar;
use App\Models\Busi\VisitStoreTodo;


class VisitStoreTodoStatusEventHandler  implements ShouldQueue
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
     * 门店巡访项目状态变化
     * （1-未开始， 2-进行中， 3-已完成）
     * Handle the event.
     *
     * @param  VisitTodoStatusChangedEvent  $event
     * @return void
     */
    public function handle(VisitTodoStatusChangedEvent $event)
    {
        //
	    $storeCalendar = VisitStoreCalendar::find($event->model->fstore_calendar_id);
		if($event->model->fstatus == 2){
			if(!empty($storeCalendar)){
				$storeCalendar->fstatus = 2;
				$storeCalendar->save();
			}
		}elseif($event->model->fstatus == 3){
			$count = VisitTodoCalendar::where('fstore_calendar_id', $event->model->fstore_calendar_id)->where('fstatus', 3)->count();
			$todoCount = VisitStoreTodo::where('ffunction_id', '>', 0)->where('fis_must_visit', 1)->count();
			if($count == $todoCount){
				$storeCalendar->fstatus = 3;
				$storeCalendar->save();
			}
		}
    }
}

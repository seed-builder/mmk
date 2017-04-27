<?php

namespace App\Listeners;

use App\Events\VisitTodoStatusChangedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Busi\VisitStoreCalendar;
use App\Models\Busi\VisitTodoCalendar;
use App\Models\Busi\VisitStoreTodo;


class VisitStoreTodoStatusEventHandler  //implements ShouldQueue
{
	//use InteractsWithQueue;
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
	    if($event->model->fstatus > 1) {
		    //
		    $storeCalendar = VisitStoreCalendar::find($event->model->fstore_calendar_id);
		    if ($event->model->fstatus == 2) {
			    if (!empty($storeCalendar)) {
				    $storeCalendar->fstatus = 2;
				    if(empty($storeCalendar->fbegin))
				    {
				    	$storeCalendar->fbegin = date('Y-m-d H:i:s');
				    }
				    $storeCalendar->save();
			    }
		    } elseif ($event->model->fstatus == 3) {
			    $count = VisitTodoCalendar::where('fstore_calendar_id', $event->model->fstore_calendar_id)
				    ->where('fis_must_visit',1)
				    ->where('fstatus', '<', 3)->count();
			    if ($count == 0) {
				    $storeCalendar->fend = date('Y-m-d H:i:s');
				    $storeCalendar->fstatus = 3;
			    }else{
				    if(empty($storeCalendar->fbegin))
				    {
					    $storeCalendar->fbegin = date('Y-m-d H:i:s');
				    }
				    $storeCalendar->fstatus = 2;
			    }
			    $storeCalendar->save();
		    }
		    $this->updateParent($event->model);
	    }
    }

    protected function updateParent(VisitTodoCalendar $todoCalendar){
    	if($todoCalendar && $todoCalendar->fparent_id > 0) {
		    $parent = VisitTodoCalendar::find($todoCalendar->fparent_id);
		    if($todoCalendar->fstatus == 2){
			    $parent->fstatus = 2;
			    if(empty($parent->fbegin))
			    {
				    $parent->fbegin = date('Y-m-d H:i:s');
			    }
			    $parent->save();
		    }elseif($todoCalendar->fstatus == 3){
			    if($parent->todo->fchildren_calculate == 'and') {
				    $count = VisitTodoCalendar::where('fparent_id', $todoCalendar->fparent_id)
					    ->where('fis_must_visit',1)
					    ->where('fstatus', '<', 3)->count();
				    if ($count == 0) {
					    $parent->fend = date('Y-m-d H:i:s');
					    $parent->fstatus = 3;
				    } else {
					    if(empty($parent->fbegin))
					    {
						    $parent->fbegin = date('Y-m-d H:i:s');
					    }
					    $parent->fstatus = 2;
				    }
			    }else if($parent->todo->fchildren_calculate == 'or') {
				    $count = VisitTodoCalendar::where('fparent_id', $todoCalendar->fparent_id)
					    ->where('fis_must_visit',1)
					    ->where('fstatus', '=', 3)->count();
				    if ($count > 0) {
					    $parent->fend = date('Y-m-d H:i:s');
					    $parent->fstatus = 3;
				    } else {
					    if(empty($parent->fbegin))
					    {
						    $parent->fbegin = date('Y-m-d H:i:s');
					    }
					    $parent->fstatus = 2;
				    }
			    }

			    $parent->save();
		    }
		    //$this->updateParent($parent);
	    }
    }

}

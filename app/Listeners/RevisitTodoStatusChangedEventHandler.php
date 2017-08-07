<?php

namespace App\Listeners;

use App\Events\RevisitTodoStatusChangedEvent;
use App\Models\Busi\VisitStoreCalendar;
use App\Models\Busi\VisitTodoCalendar;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RevisitTodoStatusChangedEventHandler
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
	 * 门店巡访项目状态变化
	 * （1-未开始， 2-进行中， 3-已完成）
	 * Handle the event.
	 *
	 * @param  RevisitTodoStatusChangedEvent  $event
	 * @return void
	 */
	public function handle(RevisitTodoStatusChangedEvent $event)
	{
		//LogSvr::todo()->info('handle VisitStoreTodoStatusEventHandler, id=' . $event->model->id);
		if($event->model->fstatus > 1) {
			$this->updateParent($event->model);
			//
			$storeCalendar = VisitStoreCalendar::find($event->model->fstore_calendar_id);
			if ($event->model->fstatus == 2) {
				if (!empty($storeCalendar)) {
					$storeCalendar->frevisit_status = 2;
//					if(empty($storeCalendar->fbegin))
//					{
//						$storeCalendar->fbegin = date('Y-m-d H:i:s');
//					}
					$storeCalendar->save();
				}
			} elseif ($event->model->fstatus == 3) {
				$count = VisitTodoCalendar::where('fstore_calendar_id', $event->model->fstore_calendar_id)
					->where('fparent_id',0)
					->where('fis_must_visit',1)
					->where('fcategory',2)
					->where('fstatus', '<', 3)->count();
				if ($count == 0) {
//					$storeCalendar->fend = date('Y-m-d H:i:s');
					$storeCalendar->frevisit_status = 3;
				}else{
//					if(empty($storeCalendar->fbegin))
//					{
//						$storeCalendar->fbegin = date('Y-m-d H:i:s');
//					}
					$storeCalendar->frevisit_status = 2;
				}
				$storeCalendar->save();
			}

		}
	}

	protected function updateParent(VisitTodoCalendar $todoCalendar){
		//LogSvr::todo()->info('updateParent VisitStoreTodoStatusEventHandler,  id=' . $todoCalendar->id);
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
						->where('fcategory',2)
						->where('fstatus', '<', 3)
						->count();
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
						->where('fcategory',2)
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

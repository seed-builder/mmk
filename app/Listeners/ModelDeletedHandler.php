<?php

namespace App\Listeners;

use App\Events\ModelDeletedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;
use App\Services\KingdeeSyncData;
use App\Models\ModelMap;
use App\Services\LogSvr;

class ModelDeletedHandler implements ShouldQueue
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
     * @param  eloquent.deleted  $event
     * @return void
     */
    public function handle(ModelDeletedEvent $event)
    {
        //
//        LogSvr::Sync()->info('ModelDeletedHandler: '.json_encode($event->model));
        $map = ModelMap::where('table', $event->model->getTable())->first();
        if(!empty($map)){
//            $result = KingdeeSyncData::delete($map->foreign_table, $event->model);

//	        if(empty($result) || $result['Result'] != 1){
//		        LogSvr::Sync()->info('ModelDeletedHandler fail: ');
//		        $this->fail('result is null');
//	        }
//	        LogSvr::Sync()->info('ModelDeletedHandler result: ' . json_encode( $result ) );
	        $dataSync = app('dataSync');
	        $dataSync->send($map->foreign_table, 2,  $event->model->toArray());

        }
    }
}

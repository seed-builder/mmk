<?php

namespace App\Listeners;

use App\Events\ModelCreatedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;
use App\Services\KingdeeSyncData;
use App\Models\ModelMap;
use App\Services\LogSvr;

class ModelCreatedHandler implements ShouldQueue
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
     * @param  eloquent.created  $event
     * @return void
     */
    public function handle(ModelCreatedEvent $event)
    {
        //
        LogSvr::Sync()->info('ModelCreatedHandler: '.json_encode($event->model));
        $map = ModelMap::where('table', $event->model->getTable())->first();
        if(!empty($map)){
            $result = KingdeeSyncData::add($map->foreign_table, $event->model);

//	        if(empty($result) || $result['Result'] != 1){
//		        LogSvr::Sync()->info('ModelCreatedHandler fail: ');
//		        $this->fail('result is null');
//	        }
	        LogSvr::Sync()->info('ModelCreatedHandler result: ' . json_encode( $result ) );
        }
    }
}

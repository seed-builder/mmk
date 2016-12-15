<?php

namespace App\Listeners;

use App\Events\ModelUpdatedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;
use App\Services\KingdeeSyncData;
use App\Models\ModelMap;
use App\Services\LogSvr;

class ModelUpdatedHandler implements ShouldQueue
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
     * @param  eloquent.updated  $event
     * @return void
     */
    public function handle(ModelUpdatedEvent $event)
    {
        //
        LogSvr::Sync()->info('ModelUpdatedHandler: '.json_encode($event->model));
        $map = ModelMap::where('table', $event->model->getTable())->first();
        if(!empty($map)){
            $result = KingdeeSyncData::update($map->foreign_table, $event->model);
            $data = json_encode( $result );
	        if(empty($data)){
		        $this->fail('result is null');
	        }
            LogSvr::Sync()->info('ModelUpdatedHandler result: ' .  $data);
        }
    }
}

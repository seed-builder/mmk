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
        LogSvr::Sync()->info('ModelDeletedHandler: '.json_encode($event->model));
        $map = ModelMap::where('table', $event->model->getTable())->first();
        if(!empty($map)){
            $result = KingdeeSyncData::delete($map->foreign_table, $event->model);
            LogSvr::Sync()->info('ModelDeletedHandler result: ' . json_encode( $result ) );
        }
    }
}

<?php

namespace App\Listeners;

use App\Events\ModelCreatedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;
use App\Services\KingdeeSyncData;
use App\Models\ModelMap;

class ModelCreatedHandler implements ShouldQueue
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
     * @param  eloquent.created  $event
     * @return void
     */
    public function handle(ModelCreatedEvent $event)
    {
        //
        //Log::info('ModelCreatedHandler: '.json_encode($event->model));
        $map = ModelMap::where('table', $event->model->getTable())->first();
        if(!empty($map)){
            $result = KingdeeSyncData::add($map->foreign_table, $event->model);
        }
    }
}

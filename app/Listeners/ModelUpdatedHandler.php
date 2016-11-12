<?php

namespace App\Listeners;

use App\Events\ModelUpdatedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;

class ModelUpdatedHandler implements ShouldQueue
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
     * @param  eloquent.updated  $event
     * @return void
     */
    public function handle(ModelUpdatedEvent $event)
    {
        //
        Log::info('ModelUpdatedHandler: '.json_encode($event->model));
    }
}

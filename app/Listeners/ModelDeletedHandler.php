<?php

namespace App\Listeners;

use App\Events\ModelDeletedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;

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
        Log::info('ModelDeletedHandler: '.json_encode($event->model));
    }
}

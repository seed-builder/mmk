<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
//        'App\Events\SomeEvent' => [
//            'App\Listeners\EventListener',
//        ],
        'App\Events\ModelCreatedEvent' => [
            'App\Listeners\ModelCreatedHandler',
        ],
        'App\Events\ModelDeletedEvent' => [
            'App\Listeners\ModelDeletedHandler',
        ],
        'App\Events\ModelUpdatedEvent' => [
            'App\Listeners\ModelUpdatedHandler',
        ],
	    'App\Events\VisitTodoStatusChangedEvent' => [
		    'App\Listeners\VisitStoreTodoStatusEventHandler',
	    ],
	    'App\Events\VisitStoreStatusChangedEvent' => [
		    'App\Listeners\VisitStoreStatusEventHandler',
	    ],
	    'App\Events\VisitDetailCompletedEvent' => [
		    'App\Listeners\VisitDetailCompletedEventHandler',
	    ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}

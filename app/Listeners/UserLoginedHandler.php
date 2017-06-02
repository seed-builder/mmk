<?php

namespace App\Listeners;

use App\Events\UserLoginedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserLoginedHandler
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
     * @param  UserLoginedEvent  $event
     * @return void
     */
    public function handle(UserLoginedEvent $event)
    {
        //
	    if(!empty($event->user)){
	    	$event->user->login_time += 1;
		    $event->user->save();
	    }
    }
}

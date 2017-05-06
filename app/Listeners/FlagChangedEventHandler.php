<?php

namespace App\Listeners;

use App\Events\FlagChangedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class FlagChangedEventHandler  //implements ShouldQueue
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
     * @param  FlagChangedEvent  $event
     * @return void
     */
    public function handle(FlagChangedEvent $event)
    {
	    //
	    $this->updatePositionFlag($event->entity);
    }

	function updatePositionFlag($entity, $pflag = '', $self = false){
    	if($self) {
		    $entity->flag = $pflag . $entity->id;
		    $entity->save();
	    }
		if(!empty($entity->children)){
			foreach ($entity->children as $child) {
				$this->updatePositionFlag($child, $entity->flag . '-', true);
			}
		}

	}
}

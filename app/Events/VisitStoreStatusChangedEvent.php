<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\Busi\VisitStoreCalendar;

class VisitStoreStatusChangedEvent
{
    use InteractsWithSockets, SerializesModels;

	public $model;

	/**
	 * Create a new event instance.
	 *
	 * @param VisitStoreCalendar $model
	 */
	public function __construct(VisitStoreCalendar $model)
	{
		//
		$this->model = $model;
	}

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}

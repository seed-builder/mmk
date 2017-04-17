<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class EmployeeLoginedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $employee_id;
    public $device;
    public $sn;

	/**
	 * Create a new event instance.
	 *
	 * @param $employee_id
	 * @param $device
	 * @param $sn
	 */
    public function __construct($employee_id, $device, $sn)
    {
        //
	    $this->employee_id = $employee_id;
	    $this->device = $device;
	    $this->sn = $sn;
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

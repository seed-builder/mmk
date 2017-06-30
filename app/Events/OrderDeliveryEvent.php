<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * 订单配送事件
 * Class OrderDeliveryEvent
 * @package App\Events
 */
class OrderDeliveryEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $ids;

	/**
	 * Create a new event instance.
	 *
	 * @param $orderId
	 */
    public function __construct($ids)
    {
        //
	    $this->ids = $ids;
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

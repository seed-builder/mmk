<?php

namespace App\Events;

use App\Models\Busi\SaleOrderItem;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class OrderItemChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $orderItem;

	/**
	 * Create a new event instance.
	 *
	 * @param SaleOrderItem $orderItem
	 */
    public function __construct(SaleOrderItem $orderItem)
    {
        //
	    $this->orderItem = $orderItem;
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

<?php

namespace App\Listeners;

use App\Events\OrderItemChanged;
use App\Models\Busi\SaleOrder;
use App\Models\Busi\SaleOrderItem;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderItemChangedHandler
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
     * @param  OrderItemChanged  $event
     * @return void
     */
    public function handle(OrderItemChanged $event)
    {
        //
	    $order = SaleOrder::find($event->orderItem->fsale_order_id);
	    if (!empty($order)){
	    	$amount = SaleOrderItem::where('fsale_order_id', $order->id)->sum('famount');
	    	$order->update(['ftotal_amount' => $amount]);
	    }
    }
}

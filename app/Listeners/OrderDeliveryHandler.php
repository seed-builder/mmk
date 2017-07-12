<?php

namespace App\Listeners;

use App\Events\OrderDeliveryEvent;
use App\Models\Busi\CustomerPrice;
use App\Models\Busi\SaleOrder;
use App\Models\Busi\SaleOrderItem;
use App\Models\Busi\StockOut;
use App\Models\Busi\StockOutItem;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;

/**
 * 订单配送事件监听
 * 生成出库
 * Class OrderDeliveryHandler
 * @package App\Listeners
 */
class OrderDeliveryHandler //implements ShouldQueue
{
	/**
	 * Create the event listener.
	 *
	 */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  OrderDeliveryEvent  $event
     * @return void
     */
    public function handle(OrderDeliveryEvent $event)
    {
        //
	    if(empty($event->ids) || !is_array($event->ids))
	    	return;

	    foreach ($event->ids as $id) {
		    $order = SaleOrder::find($id);

		    $orderItems = $order->items()->where('fsend_status', 'C')->get();
		    if (!empty($orderItems)) {
			    DB::beginTransaction();
			    try {
				    $out = StockOut::where('fsbill_no', $order->fbill_no)->first();
				    if (empty($out)) {
					    $out = StockOut::create([
						    'fstore_id' => $order->fstore_id,
						    'fdate' => date('Y-m-d H:i:s'),
						    'fsbill_no' => $order->fbill_no,
						    'ftype' => 'A',
						    'fcust_id' => $order->fcust_id,
						    'fdocument_status' => 'C',
					    ]);
				    }
				    foreach ($orderItems as $item) {
				    	$price = CustomerPrice::getPrice($order->fcust_id, $item->fmaterial_id,  $item->box_qty);

					    $outItem = StockOutItem::create([
						    'fstock_out_id' => $out->id,
						    'fmaterial_id' => $item->fmaterial_id,
						    'fsale_unit' => $item->fsale_unit,
						    'fbase_unit' => $item->fbase_unit,
						    'fqty' => $item->fsend_qty,
						    'fbase_qty' => $item->fsend_base_qty,
						    'fdocument_status' => 'C',
						    'box_qty' => $item->box_qty ,
						    'bottle_qty' => $item->bottle_qty ,
						    'present_box_qty' => $item->present_box_qty ,
						    'present_bottle_qty' => $item->present_bottle_qty ,
							'fprice_box' => $price->fprice_box,
							'fprice_bottle' => $price->fprice_bottle,
							'famount' => $price->fprice_box * $item->box_qty + $price->fprice_bottle * $item->bottle_qty,
					    ]);
				    }
				    DB::commit();
			    } catch (Exception $e) {
				    DB::rollback();
			    }
		    }
	    }
    }
}

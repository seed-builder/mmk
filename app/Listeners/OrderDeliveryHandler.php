<?php

namespace App\Listeners;

use App\Events\OrderDeliveryEvent;
use App\Models\Busi\SaleOrder;
use App\Models\Busi\SaleOrderItem;
use App\Models\Busi\CustStockOut;
use App\Models\Busi\CustStockOutItem;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;

/**
 * 订单配送事件监听
 * 生成出库
 * Class OrderDeliveryHandler
 * @package App\Listeners
 */
class OrderDeliveryHandler implements ShouldQueue
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
	    $order = SaleOrder::find($event->orderId);
	    $orderItems = $order->items()->where('fsend_status', 'C')->get();
	    if(!empty($orderItems)){
		    DB::beginTransaction();
		    try {
			    $out = CustStockOut::where('fsbill_no', $order->fbill_no)->first();
			    if (empty($out)) {
				    $out = CustStockOut::create([
					    'fstore_id' => $order->fstore_id,
					    'fdate' => date('Y-m-d H:i:s'),
					    'fsbill_no' => $order->fbill_no,
					    'ftype' => 'A',
					    'fcust_id' => $order->fcust_id,
				    ]);
			    }
			    foreach ($orderItems as $item) {
				    $outItem = CustStockOutItem::create([
					    'fstock_out_id' => $out->id,
					    'fmaterial_id' => $item->fmaterial_id,
					    'fsale_unit' => $item->fsale_unit,
					    'fbase_unit' => $item->fbase_unit,
					    'fqty' => $item->fsend_qty,
					    'fbase_qty' => $item->fsend_base_qty,
				    ]);
			    }
			    DB::commit();
		    } catch (Exception $e) {
		    	DB::rollback();
			}
	    }
    }
}

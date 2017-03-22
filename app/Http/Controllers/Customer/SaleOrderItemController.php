<?php
namespace App\Http\Controllers\Customer;

use App\Events\OrderDeliveryEvent;
use App\Models\Busi\SaleOrder;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Busi\SaleOrderItem;
use Illuminate\Support\Facades\DB;

class SaleOrderItemController extends BaseController
{
	public function newEntity(array $attributes = [])
	{
		// TODO: Implement newEntity() method.
		return new SaleOrderItem($attributes);
	}

	/**
	* Display a listing of the resource.
	*
	* @return  \Illuminate\Http\Response
	*/
	public function index()
	{
		//
		return view('customer.sale-order-item.index');
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return  \Illuminate\Http\Response
	*/
	public function create()
	{
		return view('customer.sale-order-item.create');
	}

	/**
	* Display the specified resource.
	*
	* @param    int  $id
	* @return  \Illuminate\Http\Response
	*/
	public function edit($id)
	{
		$entity = SaleOrderItem::find($id);
		return view('customer.sale-order-item.edit', ['entity' => $entity]);
	}

	/**
	* Display the specified resource.
	*
	* @param    int  $id
	* @return  \Illuminate\Http\Response
	*/
	public function show($id)
	{
		//
	}

	/**
	 * @param  Request $request
	 * @param  array $searchCols
	 * @param  array $with
	 * @param  null $conditionCall
	 * @param bool $all_columns
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function pagination(Request $request, $searchCols = [], $with=[], $conditionCall = null, $all_columns = false){
		$searchCols = ["fbase_unit","fdocument_status","fsale_unit"];

        $with=['order','material'];
		return parent::pagination($request, $searchCols, $with);
	}

	public function makeSure(Request $request, $id){
		$entity = SaleOrderItem::find($id);
		$unit = $request->input('unit');
		$qty = $request->input('qty');
		if($unit == 'sale_unit'){
			$entity->fsend_qty = $qty;
			$entity->fsend_base_qty = $qty * $entity->material->fratio;
		}else{
			$entity->fsend_base_qty = $qty;
			$entity->fsend_qty =  round($qty / $entity->material->fratio, 2);
		}
		$entity->save();
		return $this->success($entity);
	}

	/**
	 * 配送
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function send(Request $request){
		$result = true;
		$msg = '';
		$orderId = $request->input('order_id');
		$ids = $request->input('ids', []);
		DB::beginTransaction();
		try {
			SaleOrderItem::whereIn('id', $ids)->update(['fsend_status' => 'C']);
			$count = SaleOrderItem::where('fsale_order_id', $orderId)->where('fsend_status', '<>', 'C')->count();
			if ($count == 0) {
				$order = SaleOrder::find($orderId)->update(['fsend_status' => 'C']);
				event(new OrderDeliveryEvent($orderId));
			}else{
				$order = SaleOrder::find($orderId)->update(['fsend_status' => 'D']);
			}
			DB::commit();
		} catch (Exception $e) {
			DB::rollBack();
			$result = false;
			$msg = $e->getMessage();
		}
		return $result ? $this->success($order) : $this->fail($msg);
	}

}

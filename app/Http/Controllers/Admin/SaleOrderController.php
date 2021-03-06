<?php
namespace App\Http\Controllers\Admin;

use App\Events\OrderDeliveryEvent;
use App\Models\Busi\CustomerPrice;
use App\Models\Busi\SaleOrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Busi\SaleOrder;
use Illuminate\Support\Facades\DB;

class SaleOrderController extends AdminController
{
	public function newEntity(array $attributes = [])
	{
		// TODO: Implement newEntity() method.
		return new SaleOrder($attributes);
	}

	/**
	* Display a listing of the resource.
	*
	* @return  \Illuminate\Http\Response
	*/
	public function index()
	{
		//
		//

		return view('admin.sale-order.index');
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return  \Illuminate\Http\Response
	*/
	public function create()
	{
		return view('admin.sale-order.create');
	}

	/**
	* Display the specified resource.
	*
	* @param    int  $id
	* @return  \Illuminate\Http\Response
	*/
	public function edit($id)
	{
		$entity = SaleOrder::find($id);
		return view('admin.sale-order.edit', ['entity' => $entity]);
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

	public function entityQuery()
	{
		return DB::table('st_sale_orders')
			->select(['st_sale_orders.id',
				'st_sale_orders.fbill_no',
				'st_sale_orders.fstore_id',
				'st_sale_orders.fdate',
				'st_sale_orders.femp_id',
				'st_sale_orders.fcust_id',
				'st_sale_orders.fsend_status',
				'st_sale_orders.source',
				'st_sale_orders.ftotal_amount',
				'st_sale_orders.fcreate_date',
				'st_sale_orders.fsend_date',
				'bd_customers.fname as customer_name',
				'bd_employees.fname as employee_name',
				'st_stores.ffullname as store_name',
			])
			->leftJoin('bd_customers', 'bd_customers.id', '=', 'st_sale_orders.fcust_id')
			->leftJoin('bd_employees', 'bd_employees.id', '=', 'st_sale_orders.femp_id')
			->leftJoin('st_stores', 'st_stores.id', '=', 'st_sale_orders.fstore_id');
		//return parent::entityQuery(); // TODO: Change the autogenerated stub
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
		$searchCols = ["st_sale_orders.fbill_no"];
        //$with = ['store','employee','customer'];
		return parent::pagination($request, $searchCols, $with, $conditionCall, true);
	}

	/**
	 * 接单
	 * @param Request $request
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function accept(Request $request, $id){
		$result = true;
		$msg = '';
		$entity = SaleOrder::find($id);
		DB::beginTransaction();
		try {
			$entity->fsend_status = 'B';
			$entity->fdocument_status = 'C';
			$entity->save();
			$entity->items()->update(['fsend_status' => 'B', 'fdocument_status' => 'C']);
			DB::commit();
		}catch (\Exception $e){
			DB::rollBack();
			$result = false;
			$msg = $e->getMessage();
		}
		return $result ? $this->success($entity) : $this->fail($msg);
	}

	/**
	 * 配送
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function send(Request $request)
	{
		$result = true;
		$msg = '';
		$ids = $request->input('ids', []);
		$re = $this->checkPrice($ids);
		if($re['success'] == false){
			return $this->fail('【' . $re['material'] .'】未维护售价，无法配送');
		}
		DB::beginTransaction();
		try {
			SaleOrder::whereIn('id', $ids)->update(['fsend_status' => 'C', 'fsend_date' => date('Y-m-d H:i:s')]);
			SaleOrderItem::whereIn('fsale_order_id', $ids)->update(['fsend_status' => 'C']);
			event(new OrderDeliveryEvent($ids));
			DB::commit();
		} catch (Exception $e) {
			DB::rollBack();
			$result = false;
			$msg = $e->getMessage();

		}
		return $result ? $this->success(1) : $this->fail($msg);
	}

	protected function checkPrice($orderIds){
		$orders = SaleOrder::whereIn('id', $orderIds)->get();
		if(!empty($orders)){
			foreach ($orders as $order){
				$items = SaleOrderItem::where('fsale_order_id', $order->id)->where('fmaterial_form', 1)->get();
				foreach ($items as $item){
					$price = CustomerPrice::getPrice($order->fcust_id, $item->fmaterial_id, $item->box_qty);
					if(empty($price))
						return ['success' => false, 'material' => $item->material->fname];
				}
			}
		}
		return ['success' => true];
	}


}

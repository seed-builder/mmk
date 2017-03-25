<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017-03-25
 * Time: 11:55
 */

namespace App\Http\Traits;


use App\Models\Busi\SaleOrder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SaleOrderControllerTrait
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
		$customer = Auth::user();
		$emps = [];
		$stores = [];
		if(!empty($customer->department))
		{
			$employees = $customer->department->getAllEmployeeByDept();
			$emps = $employees->map(function ($employee){
				return ['label' => $employee->fname, 'value' => $employee->id];
			});
			$emps->prepend(['label' => '--请选择--', 'value' => '']);
		}
		if($customer->stores){
			$stores = $customer->stores->map(function ($store){
				return ['label' => $store->ffullname, 'value' => $store->id];
			});
			$stores->prepend(['label' => '--请选择--', 'value' => '']);
		}
		$materials = Material::all();

		return view('customer.sale-order.index', ['stores' => $stores, 'employees' => $emps, 'materials' => $materials]);
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
		$searchCols = ["fbill_no","fdocument_status","fsend_status"];
		$with = ['store','employee','customer'];
		return parent::pagination($request, $searchCols, $with);
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

}
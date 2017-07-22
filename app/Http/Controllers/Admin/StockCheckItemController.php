<?php
namespace App\Http\Controllers\Admin;

use App\Models\Busi\StockCheck;
use App\Services\LogSvr;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Busi\StockCheckItem;
use DB;

class StockCheckItemController extends AdminController
{
	public function newEntity(array $attributes = [])
	{
		// TODO: Implement newEntity() method.
		return new StockCheckItem($attributes);
	}

	/**
	* Display a listing of the resource.
	*
	* @return  \Illuminate\Http\Response
	*/
	public function index()
	{
		//
		return view('admin.stock-check-item.index');
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return  \Illuminate\Http\Response
	*/
	public function create()
	{
		return view('admin.stock-check-item.create');
	}

	/**
	* Display the specified resource.
	*
	* @param    int  $id
	* @return  \Illuminate\Http\Response
	*/
	public function edit($id)
	{
		$entity = StockCheckItem::find($id);
		return view('admin.stock-check-item.edit', ['entity' => $entity]);
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
	* @param  bool $all_columns
	* @return  \Illuminate\Http\JsonResponse
	*/
	public function pagination(Request $request, $searchCols = [], $with=[], $conditionCall = null, $all_columns = false){
		$searchCols = [];
		return parent::pagination($request, $searchCols);
	}

	/**
	 * 月度报表
	 * month_pagination
	 * @param  Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function month_pagination(Request $request){
		$start = $request->input('start', 0);
		$length = $request->input('length', 10);
		$columns = $request->input('columns', []);
		$order = $request->input('order', []);
		$search = $request->input('search', []);
		$draw = $request->input('draw', 0);
        $filter = $request->input('filter', []);

		$queryBuilder = DB::table('st_stock_check_items')
			->join('st_stock_checks', 'st_stock_check_items.fstock_check_id', '=', 'st_stock_checks.id')
			->leftJoin('bd_materials', 'bd_materials.id', '=', 'st_stock_check_items.fmaterial_id')
			->leftJoin('sys_users', 'sys_users.id', '=', 'st_stock_checks.fchecker_id')
			->leftJoin('bd_customers', 'bd_customers.id', '=', 'st_stock_checks.fcust_id')
			->select(['st_stock_check_items.*',
				'st_stock_checks.fyear',
				'st_stock_checks.fmonth',
				'st_stock_checks.fcomplete_date',
				'st_stock_checks.fcheck_status',
				'sys_users.nick_name',
				'bd_materials.fnumber as material_number',
				'bd_materials.fname as material_name',
				'bd_materials.fspecification as material_spec',
				'bd_materials.fratio as material_fratio',
				'st_stock_checks.fcust_id as cust_id',
				'bd_customers.fname as cust_name'
			]);

		$conditions = [];
		foreach ($columns as $column) {
			if (!empty($column['search']['value'])) {
				$conditions[$column['data']] = $column['search']['value'];
			}
		}

		$total = $queryBuilder->count();

		foreach ($conditions as $col => $val) {
			$queryBuilder->where($col, $val);
		}

		if (!empty($filter))
            $this->filter($queryBuilder,$filter);

		//模糊查询
		if (!empty($searchCols) && !empty($search['value'])) {
			$queryBuilder->where(function ($query) use ($search, $searchCols) {
				foreach ($searchCols as $sc) {
					$query->orWhere($sc, 'like binary', '%' . $search['value'] . '%');
				}
			});
		}
		$filterCount = $queryBuilder->count();

		foreach ($order as $o) {
			$index = $o['column'];
			$dir = $o['dir'];
			$queryBuilder->orderBy($columns[$index]['data'], $dir);
		}

		if($length > 0) {
			$entities = $queryBuilder->skip($start)->take($length)->get();
		}else{
			$entities = $queryBuilder->get();
		}
		//$entities = $queryBuilder->skip($start)->take($length)->get();
//	    var_dump($queryBuilder->toSql());
//		LogSvr::sql()->info($queryBuilder->toSql());
		$result = [
			'draw' => $draw,
			'recordsTotal' => $total,
			'recordsFiltered' => $filterCount,
			'data' => $entities
		];
		return response()->json($result);
	}



}

<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Busi\StockCheckItem;

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
	 * @param  array $searchCols
	 * @param  array $with
	 * @param  null $conditionCall
	 * @param  bool $all_columns
	 * @return  \Illuminate\Http\JsonResponse
	 */
	public function month_pagination(Request $request, $searchCols = [], $with=[], $conditionCall = null, $all_columns = false){
		$start = $request->input('start', 0);
		$length = $request->input('length', 10);
		$columns = $request->input('columns', []);
		$order = $request->input('order', []);
		$search = $request->input('search', []);
		$draw = $request->input('draw', 0);
//        $filter = $request->input('filter', 0);

		$queryBuilder = $this->entityQuery(); //$this->newEntity()->newQuery();

		if (!empty($with)) {
			$queryBuilder->with($with);
		}
		$fields = [];
		$conditions = [];
		foreach ($columns as $column) {
			if (!$all_columns)
				$fields[] = $column['data'];
			if (!empty($column['search']['value'])) {
				$conditions[$column['data']] = $column['search']['value'];
			}
		}

		$total = $queryBuilder->count();

//        if (!empty($filter))
//            $this->filter($queryBuilder,$filter);
//        if (!empty($filter)||!empty($tree)||!empty($initFilter)) {
//            $this->adminFilter($queryBuilder,$request);
//        }

		if ($conditionCall != null && is_callable($conditionCall)) {
			$conditionCall($queryBuilder);
		}
		foreach ($conditions as $col => $val) {
			$queryBuilder->where($col, $val);
		}

		//模糊查询
		if (!empty($searchCols) && !empty($search['value'])) {
			$queryBuilder->where(function ($query) use ($search, $searchCols) {
				foreach ($searchCols as $sc) {
					$query->orWhere($sc, 'like binary', '%' . $search['value'] . '%');
				}
			});
		}
		$filterCount = $queryBuilder->get()->count();

		foreach ($order as $o) {
			$index = $o['column'];
			$dir = $o['dir'];
			$queryBuilder->orderBy($columns[$index]['data'], $dir);
		}

		if (!empty($fields)) {
			$queryBuilder->select($fields);
		}
		if($length > 0) {
			$entities = $queryBuilder->skip($start)->take($length)->get();
		}else{
			$entities = $queryBuilder->get();
		}
		//$entities = $queryBuilder->skip($start)->take($length)->get();
//	    var_dump($queryBuilder->toSql());
		//LogSvr::sql()->info($queryBuilder->toSql());
		$result = [
			'draw' => $draw,
			'recordsTotal' => $total,
			'recordsFiltered' => $filterCount,
			'data' => $entities
		];
		return response()->json($result);
	}



}

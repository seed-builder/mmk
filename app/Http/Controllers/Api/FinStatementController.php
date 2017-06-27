<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Models\Busi\FinStatement;

class FinStatementController extends ApiController
{
	//
	public function newEntity(array $attributes = [])
	{
		// TODO: Implement newEntity() method.
		return new FinStatement($attributes);
	}

	public function customer(Request $request, $customerId){
		return view('api.fin-statement.index', ['customerId' => $customerId]);
	}

	/**
	 * Datatables UI page
	 * @param Request $request
	 * @param array $searchCols
	 * @param array $with
	 * @param null $conditionCall
	 * @param bool $all_columns
	 * @return \Illuminate\Http\JsonResponse
	 * @internal param array $columns
	 */
	public function pagination(Request $request, $searchCols = [], $with = [], $conditionCall = null, $all_columns = false)
	{
		$data = $request->all();

		$start = $request->input('start', 0);
		$length = $request->input('length', 10);
		$columns = $request->input('columns', []);
		$order = $request->input('order', []);
		$search = $request->input('search', []);
		$draw = $request->input('draw', 0);
//        $filter = $request->input('filter', 0);

		$queryBuilder = FinStatement::query();//$this->entityQuery(); //$this->newEntity()->newQuery();

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

		if ($conditionCall != null && is_callable($conditionCall)) {
			$conditionCall($queryBuilder);
		}

		if (!empty($data['filter']))
			$this->formFilter($queryBuilder, $data['filter']);


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
		$entities = $queryBuilder->skip($start)->take($length)->get();
		//$entities = $queryBuilder->skip($start)->take($length)->get();
		//var_dump($queryBuilder->toSql());
		//LogSvr::sql()->info($queryBuilder->toSql());
		$result = [
			'draw' => $draw,
			'recordsTotal' => $total,
			'recordsFiltered' => $filterCount,
			'data' => $entities
		];
		return response()->json($result);
	}

	public function formFilter($queryBuilder, $data)
	{
		foreach ($data as $f) {
			if (empty($f['value']))
				continue;
			$queryBuilder = $this->adminFilterQuery($queryBuilder, $f);
		}

		return $queryBuilder;
	}

	public function adminFilterQuery($queryBuilder, $data)
	{
		$operator = !empty($data['operator']) ? $data['operator'] : '=';
		if ($operator == 'like')
			$queryBuilder->where($data['name'], $operator, '%' . $data['value'] . '%');
		else
			$queryBuilder->where($data['name'], $operator, $data['value']);
		return $queryBuilder;
	}

}
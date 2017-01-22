<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

abstract class AdminController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	//
	public abstract function newEntity(array $attributes = []);

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$data = $request->input('data', []);
		if(empty($data))
			return $this->fail('data is empty');
		$props = current($data);
		$fieldErrors = $this->validateFields($props);
		if(!empty($fieldErrors)){
			return $this->fail('validate error', $fieldErrors);
		} else {
			$entity = $this->newEntity($props);
			$entity->save();
			return $this->success($entity);
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		//
		$data = $request->input('data', []);
		if(empty($data))
			return $this->fail('data is empty');

		$props = current($data);
		$fieldErrors = $this->validateFields($props);
		if(!empty($fieldErrors)){
			return $this->fail('validate error', $fieldErrors);
		} else {
			$entity = $this->newEntity()->newQuery()->find($id);
			$entity->fill($props);
			$entity->save();
			return $this->success($entity);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$entity =  $this->newEntity()->newQuery()->find($id);
		$entity->delete();
		$entity=[];
		return $this->success($entity);
	}

	/**
	 * Datatables UI page
	 * @param Request $request
	 * @param array $searchCols
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function pagination(Request $request, $searchCols = []){
		$start =  $request->input('start', 0);
		$length = $request->input('length', 10);
		$columns = $request->input('columns',[]);
		$order = $request->input('order', []);
		$search = $request->input('search', []);
		$draw = $request->input('draw', 0);

		$queryBuilder = $this->newEntity()->newQuery();
		$fields = [];
		$conditions = [];
		foreach ($columns as $column){
			$fields[] = $column['data'];
			if(!empty($column['search']['value'])){
				$conditions[$column['data']] = $column['search']['value'];
			}
		}

		$total = $queryBuilder->count();

		foreach ($conditions as $col => $val) {
			$queryBuilder->where($col, $val);
		}
		//模糊查询
		if(!empty($searchCols) && !empty($search['value'])){
			$queryBuilder->where(function ($query) use ($search, $searchCols) {
				foreach ($searchCols  as $sc){
					if(is_array($sc)){//用于其他表查询 [entity,querykey,localkey]
						foreach ($sc as $s){
							$entities=$s[0]->where($s[1],'like binary', '%' . $search['value'] . '%')->get();
							$ids = [];
							foreach ($entities as $e){
								$ids[] = $e->id;
							}
							$query->orWhereIn($s[2], $ids);
						}
					}else{
						$query->orWhere($sc, 'like binary', '%' . $search['value'] . '%');
					}
				}
			});

		}
		$filterCount = $queryBuilder->count();

		foreach ($order as $o){
			$index = $o['column'];
			$dir = $o['dir'];
			$queryBuilder->orderBy($columns[$index]['data'], $dir);
		}

		$entities = $queryBuilder->select($fields)->skip($start)->take($length)->get();
		$result = [
			'draw' => $draw,
			'recordsTotal' => $total,
			'recordsFiltered' => $filterCount,
			'data' => $entities
		];
		return response()->json($result);
	}

	protected function validateFields($data)
	{
		$fieldErrors = [];
		$entity= $this->newEntity();
		if(isset($entity->validateRules)) {
			$validator = Validator::make($data, $entity->validateRules);
			if ($validator->fails()) {
				$errors = $validator->errors();
				$keys = $errors->keys();
				foreach ($keys as $k) {
					$fieldErrors[] = ['name' => $k, 'status' => $errors->first($k)];
				}
			}
		}
		return $fieldErrors;
	}

	public function success($data){
		return response()->json(['data' => [$data]]);
	}

	public function fail($error, $fieldErrors = []){
		return response()->json(['data' => [], 'error' =>  $error, 'cancelled' => 1, 'fieldErrors' => $fieldErrors]);
	}

	public function flash_success($msg){
		Session::flash('success', $msg);
	}

	public function flash_alert($msg){
		Session::flash('message', $msg);
	}

	public function flash_error($msg){
		Session::flash('error', $msg);
	}

}

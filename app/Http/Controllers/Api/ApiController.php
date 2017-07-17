<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use App\Services\LogSvr;
use Illuminate\Support\Facades\Validator;

abstract class  ApiController extends Controller
{
	//
	public function __construct()
	{
	}

	public abstract function newEntity(array $attributes = []);

	public function fillQueryForIndex(Request $request, Builder &$query)
	{
		$search = $request->input('search', '{}');
		$conditions = json_decode($search, true);
		if (!empty($conditions)) {
			//dump($conditions);
			foreach ($conditions as $k => $v) {
				$tmp = explode(' ', $k);
				if(isset($tmp[1])){
					$operator = trim($tmp[1]);
					$query->where($tmp[0], $operator, $v);
				}else{
					$query->where($tmp[0], $v);
				}
			}
		}
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		//
		$page = $request->input('page', 1);
		$pageSize = $request->input('pageSize', 10);
		$sort = $request->input('sort', 'id asc');
		$entity = $this->newEntity();
		$query = $entity->query();
		$this->fillQueryForIndex($request, $query);
		$count = $query->count();
		$arr = explode(',', $sort);
		//var_dump($arr);
		foreach ($arr as $order) {
			$tmpArr = explode(' ', trim($order));
			$query->orderBy($tmpArr[0], $tmpArr[1]);
		}
		$data = $query->take($pageSize)->skip(($page - 1) * $pageSize)->get();
		//LogSvr::apiSql()->info($query->toSql());
		return response(['count' => $count, 'list' => $data, 'page' => $page, 'pageSize' => $pageSize], 200);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		//
		$data = $request->all();
		unset($data['_sign']);
		$entity = $this->newEntity($data);
	    $fieldErrors = $this->validateFields($data);
	    if (!empty($fieldErrors)) {
	    	$msg = $this->formatFieldErrors($fieldErrors, $entity->fieldNames);
		    return response($msg, 400);
	    }
		//$entity = Entity::create($data);
		$re = $entity->save();
		//LogSvr::Sync()->info('ModelCreated : '.json_encode($entity));
		$status = $re ? 200 : 400;
		return response($entity, $status);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
		if ($id == 0) {
			return response('{}', 404);
		} else {
			$entity = $this->newEntity()->newQuery()->find($id);
			// var_dump($entity);
			return response($entity, 200);
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		//
		$entity = $this->newEntity()->newQuery()->find($id);
		//$entity = Entity::find($id);
		//var_dump($entity);

		$data = $request->all();
		//var_dump($data);
		unset($data['_sign']);
		$entity->fill($data);
		$re = $entity->save();
		//LogSvr::update()->info(json_encode($re));
		$status = $re ? 200 : 401;
		return response(['success' => $re], $status);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		//
		$entity = $this->newEntity()->newQuery()->find($id);
		//var_dump($entity);
		$re = $entity->delete();
		$status = $re ? 200 : 401;
		return response(['success' => $re], $status);
	}

	protected function validateFields($data, $all = false)
	{
		$fieldErrors = [];
		$entity = $this->newEntity();
		if (isset($entity->validateRules)) {
			if($all){
				$rules = $entity->validateRules;
			}else {
				$rules = [];
				foreach ($data as $k => $v) {
					if (array_key_exists($k, $entity->validateRules)) {
						$rules[$k] = $entity->validateRules[$k];
					}
				}
			}
			$validator = Validator::make($data, $rules);
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

	protected function formatFieldErrors(array $fieldErrors, array $fieldNames){
		if(empty($fieldErrors) || empty($fieldNames))
			return '';
		$result = [];
		foreach ($fieldErrors as $error){
			$field = $error['name'];
			if(array_key_exists($field, $fieldNames)) {
				$result[] = str_replace($field, $fieldNames[$field], $error['status']);
			}else{
				$result[] = $error['status'];
			}
		}
		return implode(',', $result);
	}

	public function success($data, $msg = ''){
		return response(['data' => $data, 'code' => 200, 'msg' => $msg, 'success' => true]);
	}

	public function fail($msg){
		return response(['data' => null, 'code' => 401, 'msg' => $msg, 'success' => false]);
	}
}

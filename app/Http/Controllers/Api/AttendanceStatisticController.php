<?php

namespace App\Http\Controllers\Api;

use App\Models\Busi\AttendanceStatistic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AttendanceStatisticController extends ApiController
{
    //
	public function newEntity(array $attributes = [])
	{
		// TODO: Implement newEntity() method.
		return new AttendanceStatistic($attributes);
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
		$arr = explode(' ', $sort);
		$entity = $this->newEntity();
		$query = $entity->query();
		$this->fillQueryForIndex($request, $query);
		$count = $query->count();
		$data = $query->orderBy($arr[0], $arr[1])->take($pageSize)->skip(($page-1)*$pageSize)->get();
		return response(['count' => $count, 'list' => $data, 'page' => $page, 'pageSize' => $pageSize], 200);
	}

}

<?php

namespace App\Http\Controllers\Api;

use App\Models\Busi\VisitStoreCalendar;
use Illuminate\Http\Request;
use App\Models\Busi\VisitLineStore;

class VisitLineStoreController extends ApiController
{
	//
	public function newEntity(array $attributes = [])
	{
		// TODO: Implement newEntity() method.
		return new VisitLineStore($attributes);
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
		$query = $entity->query()->with(['store']);
		$this->fillQueryForIndex($request, $query);
		$count = $query->count();
		$arr = explode(',', $sort);
		//var_dump($arr);
		foreach ($arr as $order) {
			$tmpArr = explode(' ', trim($order));
			$query->orderBy($tmpArr[0], $tmpArr[1]);
		}
		$data = $query->take($pageSize)->skip(($page - 1) * $pageSize)->get();
		foreach ($data as &$d){
			$calendar = VisitStoreCalendar::select(['fstatus'])->where('femp_id', $d->femp_id)->where('fstore_id', $d->fstore_id)->orderBy('id', 'desc')->first();
			$d->store_calender_status = $calendar->fstatus;
		}
		//LogSvr::apiSql()->info($query->toSql());
		return response(['count' => $count, 'list' => $data, 'page' => $page, 'pageSize' => $pageSize], 200);
	}
}
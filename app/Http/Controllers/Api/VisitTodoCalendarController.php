<?php

namespace App\Http\Controllers\Api;

use App\Models\Busi\VisitStoreCalendar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Busi\VisitTodoCalendar;
use App\Models\Busi\VisitStoreTodo;
use DB;

class VisitTodoCalendarController extends ApiController
{
    //
    public function newEntity(array $attributes = [])
    {
        // TODO: Implement newEntity() method.
        return new VisitTodoCalendar($attributes);
    }

	/**
	 * @param Request $request
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 */
	public function index(Request $request)
	{
		$page = $request->input('page', 1);
		$pageSize = $request->input('pageSize', 10);
		$sort = $request->input('sort', 'id asc');
		$entity = $this->newEntity();
		$query = $entity->query();
		$this->fillQueryForIndex($request, $query);
		$count = $query->count();
		$arr = explode(',', $sort);
		//var_dump($arr);
		foreach ($arr as $order){
			$tmpArr = explode(' ', trim($order));
			$query->orderBy($tmpArr[0], $tmpArr[1]);
		}
		$data = $query->take($pageSize)->skip(($page-1)*$pageSize)->get();

		$search = $request->input('search', '{}');
		$conditions = json_decode($search, true);
		if(!empty($conditions['fparent_id'])){
			$parent = VisitTodoCalendar::find($conditions['fparent_id']);
			if($parent->todo->fname == '陈列管理'){
				$storeCalendar = VisitStoreCalendar::find($conditions['fstore_calendar_id']);
				if($storeCalendar->store->fis_signed){
					$data = $data->filter(function($item){
						return isset($item->todo) && $item->todo->fname == '陈列费用政策';
					});
				}else{
					$data = $data->filter(function($item){
						return isset($item->todo) &&  $item->todo->fname == '正常陈列';
					});
				}
			}
		}
		//LogSvr::apiSql()->info($query->toSql());
		return response(['count' => $count, 'list' => $data->flatten(), 'page' => $page, 'pageSize' => $pageSize], 200);
		//return parent::index($request); // TODO: Change the autogenerated stub
	}

//	/**
//	 * Store a newly created resource in storage.
//	 *
//	 * @param  \Illuminate\Http\Request  $request
//	 * @return \Illuminate\Http\Response
//	 */
//	public function store(Request $request)
//	{
//		//
//		$data = $request->all();
//		unset($data['_sign']);
//
//		$todoCalendar = VisitTodoCalendar::where('femp_id', $data['femp_id'])
//			->where('fstore_calendar_id', $data['fstore_calendar_id'])
//			->where('fdate', $data['fdate'])
//			->where('ftodo_id', $data['ftodo_id'])
//			->first();
//
//		if(empty($todoCalendar)){
//			$entity = $this->newEntity($data);
//			$re = $entity->save();
//		}else{
//			$todoCalendar->fstatus =  $data['fstatus'];
//			$re = $todoCalendar->save();
//		}
//
//		//LogSvr::Sync()->info('ModelCreated : '.json_encode($entity));
//		$status = $re ? 200 : 400;
//		return response($entity, $status);
//	}
//
//	public function getStatus(Request $request){
//		$fdate = $request->input('fdate');
//		$femp_id = $request->input('femp_id');
//		$fstore_calendar_id = $request->input('fstore_calendar_id');
//		$ftodo_id = $request->input('ftodo_id');
//
//
//	}

	public function getStatus(Request $request){
		$fdate = $request->input('fdate');
		$femp_id = $request->input('femp_id');
		$fstore_calendar_id = $request->input('fstore_calendar_id');
		$ftodo_id = $request->input('ftodo_id');
	}

}

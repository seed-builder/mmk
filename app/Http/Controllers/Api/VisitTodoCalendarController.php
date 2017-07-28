<?php

namespace App\Http\Controllers\Api;

use App\Models\Busi\DisplayPolicyStore;
use App\Models\Busi\VisitStoreCalendar;
use App\Services\LogSvr;
use App\Services\VisitCalendarService;
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
		$category = $request->input('category', 1);
		$store_calendar_id = $request->input('store_calendar_id', 0);
		$pageSize = $request->input('pageSize', 10);
		$sort = $request->input('sort', 'id asc');
		$entity = $this->newEntity();
		$query = $entity->query()->with(['todo', 'employee']);
		$query->where('fcategory', $category);
		if($store_calendar_id > 0){
			$query->where('fstore_calendar_id', $store_calendar_id);
		}
		$this->fillQueryForIndex($request, $query);
		QUERY:
		$count = $query->count();
		if($count == 0 && $category == 2 && $store_calendar_id >0){
			//LogSvr::apiSql()->info('generateRevisitTodoCalendars');
			//生成组长复巡项
			$srv = new VisitCalendarService();
			$res = $srv->generateRevisitTodoCalendars($store_calendar_id);
			if($res)
				goto QUERY;
		}
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
				if($storeCalendar->is_store_signed){
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

	public function update(Request $request, $id)
	{
		$entity = $this->newEntity()->newQuery()->find($id);
		if(empty($entity)){
			return response(['success' => false, 'msg' => '不存在该巡访日历项'], 401);
		}
		//$entity = Entity::find($id);
		$data = $request->all();
		//var_dump($data);
		$needDos = $this->checkEnd($entity, $data);
		//LogSvr::update()->info('$needDos ' . json_encode($needDos));
		if(empty($needDos)) {
			//LogSvr::update()->info(' do update ');
			if ($data['fstatus'] == 2) {
				$data['fbegin'] = date('Y-m-d H:i:s');
			} else if ($data['fstatus'] == 3) {
				$data['fend'] = date('Y-m-d H:i:s');
			}
			unset($data['_sign']);
			$entity->fill($data);
			$re = $entity->save();
			//LogSvr::update()->info(json_encode($re));
			$status = $re ? 200 : 401;
			return response(['success' => $re], $status);
		}else{
			return response(['success' => false, 'msg' => '未完成的项有：' . implode(',', $needDos)], 401);
		}
	}

	public function checkEnd($todoCalendar, $data){
		$needDos = [];
		//拜访总结 - 结束
		if(!empty($todoCalendar->todo) && $todoCalendar->todo->ffunction_number == 'JSBF' && $data['fstatus'] == 3){
			$calendars = VisitTodoCalendar::where('fstore_calendar_id', $todoCalendar->fstore_calendar_id)
				->where('fparent_id', 0)
				->where('fis_must_visit', 1)
				->where('fstatus', '<', 3)
				->where('id', '<>', $todoCalendar->id)
				->get();
			if(!empty($calendars)){
				foreach ($calendars as $calendar){
					$needDos[] = $calendar->todo->fname;
				}
			}
		}
		return $needDos;
	}

}

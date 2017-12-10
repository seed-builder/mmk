<?php

namespace App\Http\Controllers\Admin;

use App\Models\Busi\Store;
use App\Models\Busi\VisitPzbz;
use App\Models\Busi\VisitStoreTodo;
use App\Models\Busi\VisitTodoCalendar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Busi\VisitStoreCalendar;
use App\Models\Busi\Employee;
use App\Models\Busi\Department;
use Illuminate\Support\Facades\DB;

class VisitStoreCalendarController extends AdminController
{
	public function newEntity(array $attributes = [])
	{
		// TODO: Implement newEntity() method.
		return new VisitStoreCalendar($attributes);
	}
	
	public function index()
	{
		return view('admin.visit_store_calendar.index');
	}

    public function all()
    {
        $ids = $this->getCurUsersEmployeeIds();
        $employees = Employee::query()->whereIn('id',$ids)->get();
        $stores = Store::where('fdocument_status', 'A')->get();
        return view('admin.visit_store_calendar.all',compact('employees','stores'));
    }

    public function revisit()
    {
        return view('admin.visit_store_calendar.revisit');
    }

	/**
	 * @param Request $request
	 * @param array $searchCols
	 * @param array $with
	 * @param null $conditionCall
	 * @param bool $all_columns
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function pagination(Request $request, $searchCols = [], $with = [], $conditionCall = null, $all_columns = true){
		$searchCols = [];

		return parent::pagination($request, $searchCols, $with, function ($queryBuilder){
			$ids = $this->getCurUsersEmployeeIds();
			//var_dump($ids);
			if(!empty($ids))
			{
				$queryBuilder->whereIn('femp_id', $ids);
			}
		},$all_columns);
	}

	public function revisitPagination(Request $request, $searchCols = [], $with = [], $conditionCall = null, $all_columns = true)
    {
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
        $filterCount = $queryBuilder->count();

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

    public function visitStoreCalendarInfo($id){
        $todos = VisitTodoCalendar::query()->where('fstore_calendar_id',$id)->get();
        $sc = VisitStoreCalendar::find($id);

        foreach ($todos as $t){
            $pzs = VisitPzbz::where('flog_id', $t->id)->first();

            if (!empty($pzs)){
                $imageIds=explode(",", $pzs->fphotos);

                $images = [];
                foreach ($imageIds as $i){
                    $images[] = '/admin/show-image?imageId='.$i;
                }
                $t->images = $images;
                $t->remark = $pzs->fremark;
            }

        }


        return view('admin.visit_store_calendar.info',compact('todos','sc'));
    }

    public function formFilter($queryBuilder, $data)
    {
        foreach ($data as $f){

            if (empty($f['value']))
                continue;

            switch ($f['name']){
                case "employee_fname" : {
                    $ids = Employee::query()->where('fname','like','%'.$f['value'].'%')->pluck('id');
                    $queryBuilder->whereIn('femp_id', $ids);
                    break;
                }
                case "store_ffullname" : {
                    $ids = Store::query()->where('ffullname','like','%'.$f['value'].'%')->pluck('id');
                    $queryBuilder->whereIn('fstore_id', $ids);
                    break;
                }
                default : {
                    $queryBuilder=$this->adminFilterQuery($queryBuilder,$f);
                }
            }
        }
    }

    public function pics(Request $request, $id){
        $photos = DB::table('visit_pzbz')
            ->join('visit_todo_calendar', 'visit_todo_calendar.id', '=', 'visit_pzbz.flog_id')
            ->join('visit_store_calendar', 'visit_store_calendar.id', '=', 'visit_todo_calendar.fstore_calendar_id')
            ->where('visit_store_calendar.id', $id)
            ->select('visit_pzbz.fphotos')
            ->get();
        $ids = [];
        if(!empty($photos)){
            foreach ($photos as $photo){
                if(!empty($photo->fphotos)){
                    $ids = array_merge($ids, explode(',', $photo->fphotos));
                }
            }
        }
        return view('admin.visit_store_calendar.pics', ['ids' => $ids]);
    }

}

<?php

namespace App\Http\Controllers\Admin;

use App\Models\Busi\VisitPzbz;
use App\Models\Busi\VisitStoreTodo;
use App\Models\Busi\VisitTodoCalendar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Busi\VisitStoreCalendar;
use App\Models\Busi\Employee;
use App\Models\Busi\Department;

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

	/**
	 * @param Request $request
	 * @param array $searchCols
	 * @param array $with
	 * @param null $conditionCall
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function pagination(Request $request, $searchCols = [], $with = [], $conditionCall = null){
		$searchCols = ['fdate', 'forg_id','femp_id','fstore_id','fstatus','fline_calendar_id'];

        $data = $request->all();
        $query = VisitStoreCalendar::query();
        if(!empty($data['nodeid'])){//组织树点击查询
            $emp = Employee::find($data['nodeid']);

            if (empty($emp)){
                $dept = Department::find($data['nodeid']);
                $emp_ids = $dept->getAllEmployeeByDept()->pluck('id')->toArray();

                $request['queryBuilder'] = $query->whereIn('femp_id',$emp_ids);
            }else{
                $request['queryBuilder'] = $query->where('femp_id',$data['nodeid']);
            }
        }
        if(!empty($data['fline_calendar_id'])){

        }
		return parent::pagination($request, $searchCols);
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
            }
        }


        return view('admin.visit_store_calendar.info',compact('todos','sc'));
    }
}

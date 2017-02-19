<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Swagger\Annotations\Items;
use App\Models\Busi\VisitLineCalendar;
use App\Models\Busi\Employee;
use App\Models\Busi\Department;

class VisitLineCalendarController extends AdminController
{
	public function newEntity(array $attributes = [])
	{
		// TODO: Implement newEntity() method.
		return new VisitLineCalendar($attributes);
	}
	
	public function index()
	{
		return view('admin.visit_line_calendar.index');
	}
	
	/**
	 * @param Request $request
	 * @param array $searchCols
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function pagination(Request $request, $searchCols = [], $with = []){
		$searchCols = ['fline_id', 'femp_id'];

        $data = $request->all();
        if(!empty($data['nodeid'])){//组织树点击查询
            $query = VisitLineCalendar::query();
            $emp = Employee::find($data['nodeid']);

            if (empty($emp)){
                $dept = Department::find($data['nodeid']);
                $emp_ids = $dept->getAllEmployeeByDept()->pluck('id')->toArray();

                $request['queryBuilder'] = $query->whereIn('femp_id',$emp_ids);
            }else{
                $request['queryBuilder'] = $query->where('femp_id',$data['nodeid']);
            }
        }
		return parent::pagination($request, $searchCols);
	}
}

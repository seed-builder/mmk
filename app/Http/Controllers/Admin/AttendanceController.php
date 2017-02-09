<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Busi\Attendance;

class AttendanceController extends AdminController
{

    //
	public function newEntity(array $attributes = [])
	{
		// TODO: Implement newEntity() method.
		return new Attendance($attributes);
	}

	public function index()
	{
		return view('admin.attendance.index');
	}

	/**
	 * @param Request $request
	 * @param array $searchCols
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function pagination(Request $request, $searchCols = []){
		$searchCols = ['femp_id'];
		$data = $request->all();
        if(!empty($data['nodeid'])){//组织树点击查询
            $query = AttendanceStatistic::query();
            $emp1 = Employee::find($data['nodeid']);
            if (empty($emp1)){
                $dept = Department::find($data['nodeid']);
                $emps = $dept->getAllEmployeeByDept();
                $ids = [];
                foreach ($emps as $e){
                    $ids[] = $e->id;
                }
                $request['queryBuilder'] = $query->whereIn('femp_id',$ids);
            }else{
                $request['queryBuilder'] = $query->where('femp_id',$data['nodeid']);
            }
        }
		return parent::pagination($request, $searchCols);
	}

}

<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Busi\AttendanceStatistic;

class AttendanceStatisticController extends AdminController
{

    //
	public function newEntity(array $attributes = [])
	{
		// TODO: Implement newEntity() method.
		return new AttendanceStatistic($attributes);
	}

	public function index()
	{
		return view('admin.attendance_statistic.index');
	}

	/**
	 * @param Request $request
	 * @param array $searchCols
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function pagination(Request $request, $searchCols = []){
		$searchCols = ['femp_id'];
		return parent::pagination($request, $searchCols);
	}

}

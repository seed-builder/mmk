<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Swagger\Annotations\Items;
use App\Models\Busi\VisitLineCalendar;

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
		return parent::pagination($request, $searchCols);
	}
}

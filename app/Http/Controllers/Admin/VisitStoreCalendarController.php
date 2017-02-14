<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Busi\VisitStoreCalendar;

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
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function pagination(Request $request, $searchCols = [], $with = []){
		$searchCols = ['fdate', 'forg_id','femp_id','fstore_id','fstatus'];
		return parent::pagination($request, $searchCols);
	}
}

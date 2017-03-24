<?php

namespace App\Http\Controllers\Admin;

use App\Models\Busi\VisitLine;
use App\Models\Busi\VisitStoreCalendar;
use App\Models\Busi\VisitTodoCalendar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpParser\Node\Scalar\MagicConst\Line;
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
        $lines = VisitLine::all();
        return view('admin.visit_line_calendar.index',compact('lines'));
    }

	/**
	 * @param Request $request
	 * @param array $searchCols
	 * @param array $with
	 * @param null $conditionCall
	 * @param bool $all_columns
	 * @return \Illuminate\Http\JsonResponse
	 */
    public function pagination(Request $request, $searchCols = [], $with = [], $conditionCall = null, $all_columns = false)
    {
        $searchCols = ['fline_id', 'femp_id'];

        $data = $request->all();

        return parent::pagination($request, $searchCols, $with, function ($queryBuilder) use ($data,$request) {

            $ids = $this->getCurUsersEmployeeIds();
            //var_dump($ids);
            if (!empty($ids)) {
                $queryBuilder->whereIn('femp_id', $ids);
            }
        });
    }

}

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
            $tree = $request->input('tree',[]);
            if (!empty($tree)){
                $this->tree($queryBuilder,$tree,false);
            }

            $ids = $this->getCurUsersEmployeeIds();
            //var_dump($ids);
            if (!empty($ids)) {
                $queryBuilder->whereIn('femp_id', $ids);
            }
        });
    }

    /*
     * 生成线路拜访日历
     * 参数 week femp_id
     */
    public function makeVisitLineCalendar(Request $request)
    {
        $data = $request->all();
        $week = $data['week'];

        $model = new VisitLineCalendar();

        $fday = date("w") + 1;

        for ($i = 0; $i <= $week * 7; $i++) {

            $fday = $fday == 8 ? 1 : $fday;

            $fdate = date("Y-m-d", strtotime("+" . ($i + 1) . " day"));

            $line = VisitLine::query()->where('fnumber', $fday)->first();

            $model->makeCalendar($data['femp_id'], $line->id, $fdate);

            $fday++;
        }

        return redirect('admin/visit_line_calendar');
    }
}

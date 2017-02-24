<?php

namespace App\Http\Controllers\Admin;

use App\Models\Busi\VisitLine;
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

    /*
     * 生成线路拜访日历
     * 参数 week femp_id
     */
    public function makeVisitLineCalendar(Request $request){
        $data = $request->all();
        $week = $data['week'];

        $model = new VisitLineCalendar();

        $fday = date("w")+1;
        $line = VisitLine::query()->where('fnumber',date("w"))->first();

        for ($i=0;$i<=$week*7;$i++){

            $fday=$fday==8?1:$fday;
//            dump(date("Y-m-d",strtotime("+".($i+1)." day")));
//            dump($fday);
            $model->makeCalendar($data['femp_id'],$line->id,date("Y-m-d",strtotime("+".($i+1)." day")));

            $fday++;
        }
    }
}

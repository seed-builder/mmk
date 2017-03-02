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
		return view('admin.visit_line_calendar.index');
	}

	/**
	 * @param Request $request
	 * @param array $searchCols
	 * @param array $with
	 * @param null $conditionCall
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function pagination(Request $request, $searchCols = [], $with = [], $conditionCall = null){
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

        for ($i=0;$i<=$week*7;$i++){

            $fday=$fday==8?1:$fday;

            $fdate = date("Y-m-d",strtotime("+".($i+1)." day"))." 00:00:00";

            //删除原有数据
            VisitLineCalendar::query()
                ->where('femp_id',$data['femp_id'])
                ->where('fdate',$fdate)
                ->delete();
            VisitStoreCalendar::query()
                ->where('femp_id',$data['femp_id'])
                ->where('fdate',$fdate)
                ->delete();
            VisitTodoCalendar::query()
                ->where('femp_id',$data['femp_id'])
                ->where('fdate',$fdate)
                ->delete();
            $line = VisitLine::query()->where('fnumber',$fday)->first();

            $model->makeCalendar($data['femp_id'],$line->id,$fdate);

            $fday++;
        }

        return redirect('admin/visit_line_calendar');
    }
}

<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Busi\VisitLineCalendar;

class VisitLineCalendarController extends ApiController
{
    //
    public function newEntity(array $attributes = [])
    {
        // TODO: Implement newEntity() method.
        return new VisitLineCalendar($attributes);
    }


    public function getList(Request $request){
        $begin = $request->input('begin', date('Y-m-d'));
        $end = $request->input('end', date('Y-m-d'));
        $empId = $request->input('femp_id', 0);
        //VisitLineCalendar::where('femp_id', $emp_id)->where('fdate')
        $results = DB::select('select * from visit_line_calendar WHERE femp_id=? and date_format(fdate, \'%Y-%m-%d\') BETWEEN  ? and ?', [$empId, $begin, $end]);
        response(['list' => $results], 200);
    }

    public function getStores(Request $request){
        $fline_calendar_id = $request->input('fline_calendar_id', 0);
        //VisitLineCalendar::where('femp_id', $emp_id)->where('fdate')
        $results =
        response(['list' => $results], 200);
    }
}

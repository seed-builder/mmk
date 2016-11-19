<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Busi\Attendance as Entity;
use DB;

class AttendanceController extends ApiController
{
    public function newEntity(array $attributes = [])
    {
        return new Entity($attributes);
    }

    public function month(Request $request){
        $empId = $request->input('emp_id', 0);
        $year = $request->input('year', date('Y'));
        $month = $request->input('month', date('m'));

        $results = DB::select('select DISTINCT date_format(ftime, \'%Y-%m-%d\') as `day` from ms_attendances WHERE femp_id=? and date_format(ftime, \'%Y-%m\') = ?',
            [$empId, $year.'-'.$month]);
        $data = [];
        foreach ($results as $obj){
            $data[] = $obj->day;
        }
        return response(['list' => $data], 200);
    }

    public function day(Request $request){
        $empId = $request->input('emp_id', 0);
        $date = $request->input('date', date('Y-m-d'));

        $results = DB::select('select * from ms_attendances WHERE femp_id=? and date_format(ftime, \'%Y-%m-%d\') = ?',
            [$empId, $date]);
//        $results = Entity::where('femp_id', $empId)->where('date_format(ftime, \'%Y-%m-%d\')', $date)->get();

        return response(['list' => $results], 200);
    }
}

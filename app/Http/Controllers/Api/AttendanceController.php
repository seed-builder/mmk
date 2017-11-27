<?php

namespace App\Http\Controllers\Api;

use App\Models\Busi\Employee;
use App\Models\Busi\VisitStoreCalendar;
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

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		//
		$data = $request->all();
		unset($data['_sign']);
		$data['ftime'] = date('Y-m-d H:i:s');
		$employee = Employee::find($data['femp_id']);
		if(!empty($employee)){
			$data['fdept_id'] = $employee->fdept_id;
		}
		if(empty($data['ftype'])){
		    $data['ftype'] = 0;
        }
        if($data['ftype'] == 1){
		    //检查是否有日开始
            $c = Entity::where(DB::raw("date_format(ftime, '%Y-%m-%d')"), date('Y-m-d'))
                ->where('ftype', 0)
                ->where('femp_id', $data['femp_id'])
                ->count();
            if($c == 0){
//                return $this->fail('未日开始, 不能日完成');
                return response('未日开始, 不能日完成', 400);
            }
//            $s = VisitStoreCalendar::where('fdate', date('Y-m-d'))->where('femp_id', $data['femp_id'])->where('fstatus', '=', 2)->count();
//            if($s > 0){
////                return $this->fail('存在未拜访完成门店, 不能日完成');
//                return response('存在未拜访完成门店, 不能日完成', 400);
//            }
        }
		$entity = $this->newEntity($data);
		//$entity = Entity::create($data);
		$re = $entity->save();
		//LogSvr::Sync()->info('ModelCreated : '.json_encode($entity));
		$status = $re ? 200 : 400;
		return  response($entity, $status);//$re ? $this->success($entity, '成功') : $this->fail('失败'); //response($entity, $status);
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

	public function exists(Request $request){
		$empId = $request->input('emp_id', 0);
		$type = $request->input('type', 0);
		$date = $request->input('date', date('Y-m-d'));

//		$results = DB::select('select count(1) c from ms_attendances WHERE ftype=? and femp_id=? and date_format(ftime, \'%Y-%m-%d\') = ?',
//			[$type, $empId, $date]);
//        $results = Entity::where('femp_id', $empId)->where('date_format(ftime, \'%Y-%m-%d\')', $date)->get();
		$c = Entity::where(DB::raw("date_format(ftime, '%Y-%m-%d')"), $date)
			->where('ftype', $type)
			->where('femp_id', $empId)
			->count();
		return response(['count' => $c], 200);
	}

    /**
     * 是否日完成
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function completed(Request $request){
        $empId = $request->input('emp_id', 0);
        $date = $request->input('date', date('Y-m-d'));

        $results = DB::selectOne('select count(*) as count from ms_attendances WHERE femp_id=? and date_format(ftime, \'%Y-%m-%d\') = ? and ftype=1',
            [$empId, $date]);
//        $results = Entity::where('femp_id', $empId)->where('date_format(ftime, \'%Y-%m-%d\')', $date)->get();

        return response(['completed' => $results->count], 200);
    }

}

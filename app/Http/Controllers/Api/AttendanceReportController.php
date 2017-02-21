<?php

namespace App\Http\Controllers\Api;

use Illuminate\Database\Eloquent\Builder;
use App\Models\Busi\AttendanceReport;
use App\Models\Busi\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class AttendanceReportController extends ApiController
{
    //
	public function newEntity(array $attributes = [])
	{
		// TODO: Implement newEntity() method.
		return new AttendanceReport($attributes);
	}

	public function fillQueryForIndex(Request $request, Builder &$query){
		$search = $request->input('search', '{}');
		$conditions = json_decode($search, true);
		if(!empty($conditions)) {
			//dump($conditions);
			foreach ($conditions as $k => $v) {
				$tmp = explode(' ', $k);
				if($tmp[0] == 'femp_id'){
					$fempId = $v;
					$employee = Employee::find($fempId);
					$subs = $employee->getSubordinates();
					if(!empty($subs)){
						$ids = [];
						array_map(function ($item)use($ids){
							$ids[] = $item->id;
						}, $subs);
						$query->whereIn('femp_id', $ids);
					}

//					if(!empty($employee->position)){
//						$fnumber = $employee->position->fnumber;
//						$sql = "select e.id from bd_employees e, bd_positions p where e.fpost_id = p.id and p.fnumber like '$fnumber%'";
//						$ids = DB::select($sql);
//						if(!empty($ids)){
//							$arr = [];
//							foreach ($ids as $item){
//								$arr[] = $item->id;
//							}
//							$query->whereIn('femp_id', $arr);
//						}
//					}
				}else {
					$query->where($tmp[0], isset($tmp[1]) ? $tmp[1] : '=', $v);
				}
			}
		}
		//return $query;
	}

}

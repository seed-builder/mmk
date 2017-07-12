<?php

namespace App\Http\Controllers\Api;

use App\Repositories\ISysConfigRepo;
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
				//var_dump($v);
				if($tmp[0] == 'femp_id'){
					if(is_array($v) && $tmp[1] == 'in'){
						$query->whereIn('femp_id', $v);
					}else {
						$fempId = $v;
						$repo = app(ISysConfigRepo::class);
						if ($repo->isAppDataIsolate()) {
							$employee = Employee::find($fempId);
							if ($employee->isDataIsolate()) {
								$subs = $employee->getSubordinates();
								$ids = [];
								if (!empty($subs)) {
									$ids = array_map(function ($item) {
										return $item->id;
									}, $subs);
								}
								$ids[] = $fempId;
								$query->whereIn('femp_id', $ids);
							}
						}
					}
				}else {
					$query->where($tmp[0], isset($tmp[1]) ? $tmp[1] : '=', $v);
				}
			}
		}
		$query->with(['employee.position']);
		//return $query;
	}

}

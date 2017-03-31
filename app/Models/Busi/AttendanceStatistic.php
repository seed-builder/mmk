<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AttendanceStatistic
 * @package App\Models\Busi
 * @author xrs
 * @SWG\Model(id="AttendanceStatistic")
 * @SWG\Property(name="forg_id", type="integer", description="")
 * @SWG\Property(name="femp_id", type="integer", description="")
 * @SWG\Property(name="fyear", type="integer", description="年份")
 * @SWG\Property(name="fmonth", type="integer", description="月份")
 * @SWG\Property(name="fday", type="string", description="日期")
 * @SWG\Property(name="fbegin", type="string", description="上班时间")
 * @SWG\Property(name="fbegin_id", type="integer", description="上班考勤表id")
 * @SWG\Property(name="fbegin_status", type="integer", description="上班考勤状态(0-未完成, 1-正常, 2-迟到)")
 * @SWG\Property(name="begin_attendance", type="Attendance", description="上班考勤信息")
 * @SWG\Property(name="fcomplete", type="string", description="下班时间")
 * @SWG\Property(name="fcomplete_id", type="integer", description="下班考勤表id")
 * @SWG\Property(name="fcomplete_status", type="integer", description="下班考勤状态(0-未完成, 1-正常, 2-早退)")
 * @SWG\Property(name="complete_attendance", type="Attendance", description="下班考勤信息")
 * @SWG\Property(name="fstatus", type="integer", description="考勤状态(0-未完成, 1-正常, 2-异常, 3-请假)")
 * @SWG\Property(name="fcreate_date", type="string", description="创建时间")
 * @SWG\Property(name="fcreator_id", type="integer", description="创建人")
 * @SWG\Property(name="fdocument_status", type="string", description="数据状态")
 * @SWG\Property(name="fmodify_date", type="string", description="修改时间")
 * @SWG\Property(name="fmodify_id", type="integer", description="修改人")
 * @SWG\Property(name="id", type="integer", description="")
 */
class AttendanceStatistic extends BaseModel
{
    //
	protected $table = 'attendance_statistics';
	protected $with = ['beginAttendance', 'completeAttendance','employee'];

	public function beginAttendance(){
		return $this->belongsTo(Attendance::class, 'fbegin_id');
	}

	public function completeAttendance(){
		return $this->belongsTo(Attendance::class, 'fcomplete_id');
	}
	
	public function employee(){
		return $this->belongsTo(Employee::class, 'femp_id');
	}

	public function begin_status(){
	    switch ($this->fbegin_status){
            case 0:
                return '未完成';
            case 1:
                return '正常';
            case 2:
                return '迟到';
        }
    }
    public function complete_status(){
	    switch ($this->fcomplete_status){
            case 0:
                return '未完成';
            case 1:
                return '正常';
            case 2:
                return '迟到';
        }
    }

    public function status(){
        switch ($this->fstatus){
            case 0:
                return '未完成';
            case 1:
                return '正常';
            case 2:
                return '异常';
            case 3:
                return '请假';
        }
    }

    public static function createOrUpdate($attendance){
    	if(empty($attendance))
    		return false;

	    $day = date('Y-m-d', strtotime($attendance->ftime));
	    $date = strtotime($day);
	    $entity = AttendanceStatistic::where('femp_id', $attendance->femp_id)->where('fday', $day)->first();
	    if (empty($entity)) {
		    $entity = new AttendanceStatistic([
			    'forg_id' => $attendance->forg_id,
			    'femp_id' => $attendance->femp_id,
			    'fyear' => date('Y', $date),
			    'fmonth' => date('m', $date),
			    'fday' => $day,
			    'fbegin_status' => 0,
			    'fcomplete_status' => 0,
		    ]);
	    }

	    if ($attendance->ftype == 0) {
		    $workTimeBegin = env('WORK_TIME_BEGIN');
		    $begin = $attendance->ftime;
		    $workBegin = str_replace('00:00:00', $workTimeBegin, $day);
		    if (strtotime($workBegin) > strtotime($begin)) {
			    $beginStatus = 1;
		    } else {
			    $beginStatus = 2;
		    }
		    $entity->fbegin = $begin;
		    $entity->fbegin_id = $attendance->id;
		    $entity->fbegin_status = $beginStatus;
	    }else if ($attendance->ftype == 1) {
		    $workTimeEnd = env('WORK_TIME_END');
		    $complete = $attendance->ftime;
		    $workEnd = str_replace('00:00:00', $workTimeEnd, $day);
		    if (strtotime($complete) >= strtotime($workEnd)) {
			    $completeStatus = 1;
		    } else {
			    $completeStatus = 2;
		    }
		    $entity->fcomplete = $complete;
		    $entity->fcomplete_id = $attendance->id;
		    $entity->fcomplete_status = $completeStatus;
	    }

	    if ($entity->fbegin_status == 0 || $entity->fcomplete_status == 0) {
		    $entity->fstatus = 0;
	    } elseif ($entity->fbegin_status == 1 && $entity->fcomplete_status == 1) {
		    $entity->fstatus = 1;
	    } elseif ($entity->fbegin_status == 2 || $entity->fcomplete_status == 2) {
		    $entity->fstatus = 2;
	    }
	    $entity->save();
	    return $entity;
    }

}

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
}

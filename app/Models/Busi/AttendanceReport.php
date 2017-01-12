<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * 考勤报表
 * Class AttendanceReport
 * @package App\Models\Busi
 * @author xrs
 * @SWG\Model(id="AttendanceReport")
 * @SWG\Property(name="fcreate_date", type="string", description="创建时间")
 * @SWG\Property(name="fcreator_id", type="integer", description="创建人")
 * @SWG\Property(name="fdocument_status", type="string", description="数据状态")
 * @SWG\Property(name="fmodify_date", type="string", description="修改时间")
 * @SWG\Property(name="fmodify_id", type="integer", description="修改人")
 * @SWG\Property(name="femp_id", type="integer", description="")
 * @SWG\Property(name="forg_id", type="integer", description="")
 * @SWG\Property(name="fabnormal_days", type="integer", description="异常天数")
 * @SWG\Property(name="fnormal_days", type="integer", description="正常天数")
 * @SWG\Property(name="fwork_days", type="integer", description="应打卡天数")
 * @SWG\Property(name="fyear", type="integer", description="年份")
 * @SWG\Property(name="fmonth", type="integer", description="月份")
 * @SWG\Property(name="id", type="integer", description="")
 */
class AttendanceReport extends BaseModel
{
    //
	protected $table = 'rp_attendances';
	protected $with = ['employee'];

	public function employee(){
		return $this->belongsTo(Employee::class, 'femp_id');
	}
}

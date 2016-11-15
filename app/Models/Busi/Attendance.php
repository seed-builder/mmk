<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * 考勤签到
 * Class Attendance
 * @package App\Models\Busi
 * @author xrs
 * @SWG\Model(id="Attendance")
 * @SWG\Property(name="faddress", type="string", description="faddress")
 * @SWG\Property(name="fauditor_id", type="string", description="fauditor_id")
 * @SWG\Property(name="faudit_date", type="string", description="faudit_date")
 * @SWG\Property(name="fbillno", type="string", description="单据编号")
 * @SWG\Property(name="fcreate_date", type="string", description="fcreate_date")
 * @SWG\Property(name="fcreator_id", type="string", description="fcreator_id")
 * @SWG\Property(name="fdocument_status", type="string", description="fdocument_status")
 * @SWG\Property(name="femp_id", type="string", description="员工id")
 * @SWG\Property(name="fforbidder_id", type="string", description="fforbidder_id")
 * @SWG\Property(name="fforbid_date", type="string", description="fforbid_date")
 * @SWG\Property(name="fforbid_status", type="string", description="fforbid_status")
 * @SWG\Property(name="flatitude", type="string", description="纬度")
 * @SWG\Property(name="flongitude", type="string", description="经度")
 * @SWG\Property(name="fmodify_date", type="string", description="fmodify_date")
 * @SWG\Property(name="fmodify_id", type="string", description="fmodify_id")
 * @SWG\Property(name="forg_id", type="string", description="组织id")
 * @SWG\Property(name="fphoto", type="string", description="拍照-资源id")
 * @SWG\Property(name="fremark", type="string", description="备注")
 * @SWG\Property(name="ftime", type="string", description="签到时间")
 * @SWG\Property(name="ftype", type="string", description="签到类型")
 * @SWG\Property(name="fmode", type="string", description="签到模式")
 * @SWG\Property(name="id", type="string", description="id")
 */
class Attendance extends BaseModel
{
    //
    protected $table = 'ms_attendance';
}

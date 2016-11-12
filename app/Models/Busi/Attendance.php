<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * 考勤签到
 * @package App\Models
 *
 * @author xrs
 * @SWG\Model(id="Attendance")
 * @SWG\Property(name="id", type="string", description="pk")
 * @SWG\Property(name="fbillno", type="string", description="单据编号")
 * @SWG\Property(name="forg_id", type="string", description="组织id")
 * @SWG\Property(name="femp_id", type="string", description="员工id")
 * @SWG\Property(name="fremark", type="string", description="备注")
 * @SWG\Property(name="faddress", type="string", description="上班签到地点")
 * @SWG\Property(name="fphoto", type="string", description="拍照-资源id")
 * @SWG\Property(name="ftype", type="integer", description="签到类型")
 * @SWG\Property(name="flongitude", type="string", description="经度")
 * @SWG\Property(name="flatitude", type="string", description="纬度")
 * @SWG\Property(name="ftime", type="string",format="date", description="签到时间")
 */
class Attendance extends UuidModel
{
    //
    protected $table = 'ms_attendance';
}

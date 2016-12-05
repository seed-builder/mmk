<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * 线路日历
 * Class VisitLineCalendar
 * @package App\Models\Busi
 * @author xrs
 * @SWG\Model(id="VisitLineCalendar")
 * @SWG\Property(name="fcreate_date", type="string", description="创建时间")
 * @SWG\Property(name="fcreator_id", type="integer", description="创建人")
 * @SWG\Property(name="fdate", type="string", description="日期")
 * @SWG\Property(name="fdocument_status", type="string", description="审核状态")
 * @SWG\Property(name="femp_id", type="integer", description="员工id")
 * @SWG\Property(name="fline_id", type="integer", description="线路id")
 * @SWG\Property(name="fmodify_date", type="string", description="修改时间")
 * @SWG\Property(name="fmodify_id", type="integer", description="修改人")
 * @SWG\Property(name="forg_id", type="integer", description="组织id")
 * @SWG\Property(name="fstatus", type="string", description="线路巡访状态")
 * @SWG\Property(name="id", type="integer", description="")
 */
class VisitLineCalendar extends BaseModel
{
    //
    protected $table = 'visit_line_calendar';
}

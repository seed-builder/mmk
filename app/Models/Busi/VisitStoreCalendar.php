<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * 线路门店巡访日历
 * Class VisitStoreCalendar
 * @package App\Models\Busi
 * @author xrs
 * @SWG\Model(id="VisitStoreCalendar")
 * @SWG\Property(name="fleader_id", type="integer", description="员工上级id")
 * @SWG\Property(name="femp_id", type="integer", description="员工id")
 * @SWG\Property(name="fline_calendar_id", type="integer", description="线路巡防日历id")
 * @SWG\Property(name="forg_id", type="integer", description="组织id")
 * @SWG\Property(name="fstatus", type="integer", description="巡访状态（1-未开始， 2-进行中， 3-已完成）")
 * @SWG\Property(name="fstore_id", type="integer", description="门店id")
 * @SWG\Property(name="id", type="integer", description="")
 * @SWG\Property(name="fcreate_date", type="string", description="创建时间")
 * @SWG\Property(name="fcreator_id", type="integer", description="创建人")
 * @SWG\Property(name="fdate", type="string", description="日期")
 * @SWG\Property(name="fdocument_status", type="string", description="审核状态")
 * @SWG\Property(name="fmodify_date", type="string", description="修改时间")
 * @SWG\Property(name="fmodify_id", type="integer", description="修改人")
 */
class VisitStoreCalendar extends BaseModel
{
    //
    protected $table = 'visit_store_calendar';

    public function store(){
        return $this->belongsTo(Store::class, 'fstore_id');
    }

    public function employee(){
        return $this->belongsTo(Employee::class, 'femp_id');
    }
}

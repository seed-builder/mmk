<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * model description
 * Class ViewRevisit
 * @package  App\Models
 *
 * @author  xrs
 * @SWG\Model(id="ViewRevisit")
 * @SWG\Property(name="fbegin", type="string", description="开始时间")
 * @SWG\Property(name="fcreate_date", type="string", description="创建时间")
 * @SWG\Property(name="fcreator_id", type="integer", description="创建人")
 * @SWG\Property(name="fdate", type="string", description="日期")
 * @SWG\Property(name="fdocument_status", type="string", description="审核状态")
 * @SWG\Property(name="femp_id", type="integer", description="员工id")
 * @SWG\Property(name="fend", type="string", description="结束时间")
 * @SWG\Property(name="fleader_id", type="integer", description="员工上级id")
 * @SWG\Property(name="fline_calendar_id", type="integer", description="线路巡防日历id")
 * @SWG\Property(name="fmodify_date", type="string", description="修改时间")
 * @SWG\Property(name="fmodify_id", type="integer", description="修改人")
 * @SWG\Property(name="forg_id", type="integer", description="组织id")
 * @SWG\Property(name="frevisit_date", type="string", description="复巡日期")
 * @SWG\Property(name="frevisit_status", type="integer", description="复巡状态（1-未开始， 2-进行中， 3-已完成）")
 * @SWG\Property(name="fstatus", type="integer", description="巡访状态（1-未开始， 2-进行中， 3-已完成）")
 * @SWG\Property(name="fstore_id", type="integer", description="门店id")
 * @SWG\Property(name="id", type="integer", description="")
 * @SWG\Property(name="senior_id", type="integer", description="员工id")
 * @SWG\Property(name="senior_name", type="string", description="")
 * @SWG\Property(name="store_name", type="string", description="全名")
 * @SWG\Property(name="store_number", type="string", description="编号")
  */
class ViewRevisit extends BaseModel
{
	//
	protected $table = 'view_revisit';
	protected $guarded = ['id'];
}

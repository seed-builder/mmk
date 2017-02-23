<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * 签约门店陈列费用巡访日历
 * Class DisplayPolicyLog
 * @package  App\Models
 *
 * @author  xrs
 * @SWG\Model(id="DisplayPolicyLog")
 * @SWG\Property(name="fcreate_date", type="string", description="创建时间")
 * @SWG\Property(name="fcreator_id", type="integer", description="创建人")
 * @SWG\Property(name="fdate", type="string", description="拜访日期")
 * @SWG\Property(name="fdocument_status", type="string", description="审核状态")
 * @SWG\Property(name="femp_id", type="integer", description="业务员id")
 * @SWG\Property(name="flog_id", type="integer", description="visit_todo_calendar id")
 * @SWG\Property(name="fmodify_date", type="string", description="修改时间")
 * @SWG\Property(name="fmodify_id", type="integer", description="修改人")
 * @SWG\Property(name="forg_id", type="integer", description="组织id")
 * @SWG\Property(name="fphotos", type="string", description="图片id 集合， 逗号隔开")
 * @SWG\Property(name="fpolicy_id", type="integer", description="方案id")
 * @SWG\Property(name="fpolicy_store_id", type="integer", description="签约门店id")
 * @SWG\Property(name="fremark", type="string", description="备注")
 * @SWG\Property(name="id", type="integer", description="")
  */
class DisplayPolicyLog extends BaseModel
{
	//
	protected $table = 'exp_display_policy_log';
	protected $guarded = ['id'];
}

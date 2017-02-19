<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * model description
 * Class DisplayPolicy
 * @package  App\Models
 *
 * @author  xrs
 * @SWG\Model(id="DisplayPolicy")
 * @SWG\Property(name="fbill_no", type="string", description="bill no")
 * @SWG\Property(name="fcaption", type="string", description="陈列主题")
 * @SWG\Property(name="fcreate_date", type="string", description="创建时间")
 * @SWG\Property(name="fcreator_id", type="integer", description="创建人")
 * @SWG\Property(name="fcust_id", type="integer", description="客户 id")
 * @SWG\Property(name="fdays", type="integer", description="天数")
 * @SWG\Property(name="fdocument_status", type="string", description="数据状态")
 * @SWG\Property(name="ffinish_date", type="string", description="执行结束日期 ")
 * @SWG\Property(name="flog_id", type="integer", description="visit_todo_calendar id")
 * @SWG\Property(name="fmodify_date", type="string", description="修改时间")
 * @SWG\Property(name="fmodify_id", type="integer", description="修改人")
 * @SWG\Property(name="forg_id", type="integer", description="组织id")
 * @SWG\Property(name="frequire", type="string", description="陈列要求")
 * @SWG\Property(name="freward_amount", type="number", description="奖励金额")
 * @SWG\Property(name="freward_method", type="string", description="奖励方式")
 * @SWG\Property(name="fstart_date", type="string", description="执行开始日期")
 * @SWG\Property(name="fstatus", type="integer", description="执行状态：0 未执行，1执行中 2已执行")
 * @SWG\Property(name="fstore_id", type="integer", description="门店 id")
 * @SWG\Property(name="fvalid_begin", type="string", description="有效期起")
 * @SWG\Property(name="fvalid_end", type="string", description="有效期止")
 * @SWG\Property(name="id", type="integer", description="")
  */
class DisplayPolicy extends BaseModel
{
	//
	protected $table = 'exp_display_policy';
	protected $guarded = ['id'];
}

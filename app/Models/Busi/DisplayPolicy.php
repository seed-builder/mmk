<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * 陈列费用政策
 * Class DisplayPolicy
 * @package  App\Models
 *
 * @author  xrs
 * @SWG\Model(id="DisplayPolicy")
 * @SWG\Property(name="fbill_no", type="string", description="bill no")
 * @SWG\Property(name="forg_id", type="integer", description="组织id")
 * @SWG\Property(name="fexp_type", type="string", description="费用类别")
 * @SWG\Property(name="fsketch", type="string", description="项目简述")
 * @SWG\Property(name="fact_store_num", type="integer", description="执行门店总数")
 * @SWG\Property(name="famount", type="number", description="总金额")
 * @SWG\Property(name="fstore_cost_limit", type="number", description="单个门店费用上限")
 * @SWG\Property(name="fcost_dept_id", type="integer", description="应用区域(部门 id)")
 * @SWG\Property(name="fend_date", type="string", description="执行结束日期 ")
 * @SWG\Property(name="fstart_date", type="string", description="执行开始日期")
 * @SWG\Property(name="fsign_amount", type="integer", description="已签约总金额")
 * @SWG\Property(name="fsign_store_num", type="integer", description="已签约门店总数")
 * @SWG\Property(name="fcreate_date", type="string", description="创建时间")
 * @SWG\Property(name="fcreator_id", type="integer", description="创建人")
 * @SWG\Property(name="fmodify_date", type="string", description="修改时间")
 * @SWG\Property(name="fmodify_id", type="integer", description="修改人")
 * @SWG\Property(name="fdocument_status", type="string", description="数据状态")
 * @SWG\Property(name="id", type="integer", description="")
  */
class DisplayPolicy extends BaseModel
{
	//
	protected $table = 'exp_display_policy';
	protected $guarded = ['id'];
}

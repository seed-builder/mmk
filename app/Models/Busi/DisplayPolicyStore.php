<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * 陈列费用签约门店
 * Class DisplayPolicyStore
 * @package  App\Models
 *
 * @author  xrs
 * @SWG\Model(id="DisplayPolicyStore")
 * @SWG\Property(name="famount", type="number", description="费用总金额")
 * @SWG\Property(name="fbill_no", type="string", description="bill no")
 * @SWG\Property(name="fcheck_amount", type="number", description="核定签约金额")
 * @SWG\Property(name="fcheck_status", type="integer", description="验证状态")
 * @SWG\Property(name="fcost_dept_id", type="integer", description="应用区域(部门 id)")
 * @SWG\Property(name="fcreate_date", type="string", description="创建时间")
 * @SWG\Property(name="fcreator_id", type="integer", description="创建人")
 * @SWG\Property(name="fdate", type="string", description="签约日期")
 * @SWG\Property(name="fdocument_status", type="string", description="数据状态(A 是创建 B是审核中 C是已审核 D是重新审核)")
 * @SWG\Property(name="femp_id", type="integer", description="业务员id")
 * @SWG\Property(name="fend_date", type="string", description="门店方案执行结束日期 ")
 * @SWG\Property(name="fmodify_date", type="string", description="修改时间")
 * @SWG\Property(name="fmodify_id", type="integer", description="修改人")
 * @SWG\Property(name="forg_id", type="integer", description="组织id")
 * @SWG\Property(name="fpolicy_id", type="integer", description="方案id")
 * @SWG\Property(name="fsign_amount", type="number", description="签约金额")
 * @SWG\Property(name="fsketch", type="string", description="项目简述")
 * @SWG\Property(name="fstart_date", type="string", description="门店方案执行开始日期")
 * @SWG\Property(name="fstatus", type="integer", description="签约状态")
 * @SWG\Property(name="fstore_id", type="integer", description="门店id")
 * @SWG\Property(name="id", type="integer", description="")
  */
class DisplayPolicyStore extends BaseModel
{
	//
	protected $table = 'exp_display_policy_store';
	protected $guarded = ['id'];

	public function policy(){
        return $this->hasOne(DisplayPolicy::class, 'id', 'fpolicy_id');
    }

    public function employee(){
        return $this->hasOne(Employee::class, 'id', 'femp_id');
    }

    public function department(){
        return $this->hasOne(Department::class, 'id', 'fcost_dept_id');
    }

    public function store(){
    	return $this->belongsTo(Store::class, 'fstore_id');
    }
}

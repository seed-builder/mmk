<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * 工作流 变更单
 * Class WfChangeList
 * @package  App\Models
 *
 * @author  xrs
 * @SWG\Model(id="WfChangeList")
 * @SWG\Property(name="data", type="string", description="数据json")
 * @SWG\Property(name="fcreate_date", type="string", description="创建时间")
 * @SWG\Property(name="fcreator_id", type="integer", description="创建人")
 * @SWG\Property(name="fdocument_status", type="string", description="数据状态")
 * @SWG\Property(name="fmodify_date", type="string", description="修改时间")
 * @SWG\Property(name="fmodify_id", type="integer", description="修改人")
 * @SWG\Property(name="id", type="integer", description="")
 * @SWG\Property(name="type", type="string", description="变更类型（0-新增， 1-更新， 2-删除）")
  */
class WfChangeList extends BaseModel
{
	//
	protected $table = 'wf_change_lists';
	protected $guarded = ['id'];

	public function workflow_instance(){
		return $this->morphOne(WorkFlowInstance::class, 'data');
	}
}

<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * model description
 * 工作流实例
 * @package  App\Models
 *
 * @author  xrs
 * @SWG\Model(id="WorkFlowInstance")
 * @SWG\Property(name="title", type="string", description="标题")
 * @SWG\Property(name="sponsor", type="string", description="发起人")
 * @SWG\Property(name="approver_id", type="integer", description="审批人id（user id）")
 * @SWG\Property(name="table", type="string", description="数据表")
 * @SWG\Property(name="data_id", type="integer", description="数据 id")
 * @SWG\Property(name="node_id", type="string", description="当前所处审批节点")
 * @SWG\Property(name="status", type="integer", description="状态(0-审批中,1-结束)")
 * @SWG\Property(name="updated_at", type="string", description="")
 * @SWG\Property(name="created_at", type="string", description="")
 * @SWG\Property(name="work_flow_id", type="integer", description="")
 * @SWG\Property(name="id", type="integer", description="")
  */
class WorkFlowInstance extends BaseModel
{
	//
	protected $table = 'work_flow_instances';
	protected $guarded = ['id'];
}

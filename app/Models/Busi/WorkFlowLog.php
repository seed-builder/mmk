<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * model description
 * 实例审批日志
 * @package  App\Models
 *
 * @author  xrs
 * @SWG\Model(id="WorkFlowLog")
 * @SWG\Property(name="action", type="string", description="审批动作")
 * @SWG\Property(name="approver_id", type="integer", description="审批人id（user id）")
 * @SWG\Property(name="node_id", type="string", description="审批节点")
 * @SWG\Property(name="remark", type="string", description="备注")
 * @SWG\Property(name="work_flow_id", type="integer", description="")
 * @SWG\Property(name="work_flow_instance_id", type="integer", description="")
 * @SWG\Property(name="created_at", type="string", description="")
 * @SWG\Property(name="updated_at", type="string", description="")
 * @SWG\Property(name="id", type="integer", description="")
  */
class WorkFlowLog extends BaseModel
{
	//
	protected $table = 'work_flow_logs';
	protected $guarded = ['id'];
}

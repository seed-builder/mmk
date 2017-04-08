<?php

namespace App\Models\Busi;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * 工作流实例审批日志
 * Class WorkFlowLog
 * @package  App\Models
 *
 * @author  xrs
 * @SWG\Model(id="WorkFlowLog")
 * @SWG\Property(name="action", type="string", description="审批动作")
 * @SWG\Property(name="approver_id", type="integer", description="审批人id（user id）")
 * @SWG\Property(name="created_at", type="string", description="")
 * @SWG\Property(name="id", type="integer", description="")
 * @SWG\Property(name="node_id", type="string", description="审批节点")
 * @SWG\Property(name="remark", type="string", description="备注")
 * @SWG\Property(name="status", type="integer", description="处理状态（0-未处理，1-已经处理）")
 * @SWG\Property(name="updated_at", type="string", description="")
 * @SWG\Property(name="work_flow_id", type="integer", description="")
 * @SWG\Property(name="work_flow_instance_id", type="integer", description="")
  */
class WorkFlowLog extends BaseModel
{
	//
	protected $table = 'work_flow_logs';
	protected $guarded = ['id'];

	public function work_flow(){
		return $this->belongsTo(WorkFlow::class, 'work_flow_id');
	}

	public function work_flow_instance(){
		return $this->belongsTo(WorkFlowInstance::class, 'work_flow_instance_id');
	}

	public function work_flow_node(){
		return $this->belongsTo(WorkFlowNode::class, 'node_id');
	}

	/**
	 * 当前审批人
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function approver(){
		return $this->belongsTo(User::class, 'approver_id');
	}
}

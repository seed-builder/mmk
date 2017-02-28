<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * model description
 * 工作流定义-审批节点
 * @package  App\Models
 *
 * @author  xrs
 * @SWG\Model(id="WorkFlowNode")
 * @SWG\Property(name="approver", type="string", description="审批人")
 * @SWG\Property(name="approver_type", type="integer", description="审批人类型(0-按角色，1-特定人)")
 * @SWG\Property(name="created_at", type="string", description="")
 * @SWG\Property(name="id", type="integer", description="")
 * @SWG\Property(name="type", type="string", description="节点类型(F-first, C-common, L-last)")
 * @SWG\Property(name="updated_at", type="string", description="")
 * @SWG\Property(name="work_flow_id", type="integer", description="")
  */
class WorkFlowNode extends Model
{
	//
	protected $table = 'work_flow_nodes';
	protected $guarded = ['id'];
}

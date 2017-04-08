<?php

namespace App\Models\Busi;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * model description
 * 工作流实例
 * @package  App\Models
 *
 * @author  xrs
 * @SWG\Model(id="WorkFlowInstance")
 * @SWG\Property(name="title", type="string", description="标题")
 * @SWG\Property(name="desc", type="string", description="描述")
 * @SWG\Property(name="sponsor_id", type="string", description="发起人id（user id）")
 * @SWG\Property(name="approver_id", type="integer", description="审批人id（user id）")
 * @SWG\Property(name="data_id", type="integer", description="数据 id")
 * @SWG\Property(name="data_type", type="string", description="数据类型")
 * @SWG\Property(name="node_id", type="string", description="当前所处审批节点")
 * @SWG\Property(name="status", type="integer", description="状态(0-审批中,1-结束)")
 * @SWG\Property(name="updated_at", type="string", description="")
 * @SWG\Property(name="created_at", type="string", description="")
 * @SWG\Property(name="work_flow_id", type="integer", description="")
 * @SWG\Property(name="id", type="integer", description="")
  */
class WorkFlowInstance extends Model
{
	//
	protected $table = 'work_flow_instances';
	protected $guarded = ['id'];

	public function workflow(){
		return $this->belongsTo(WorkFlow::class, 'work_flow_id');
	}

	/**
	 * 当前审批节点
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function node(){
		return $this->belongsTo(WorkFlowNode::class, 'node_id');
	}

	/**
	 * 当前发起人
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function sponsor(){
		return $this->belongsTo(User::class, 'sponsor_id');
	}

	/**
	 * 当前审批人
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function approver(){
		return $this->belongsTo(User::class, 'approver_id');
	}

	/**
	 * 数据
	 * @return \Illuminate\Database\Eloquent\Relations\MorphTo
	 */
	public function data(){
		return $this->morphTo();
	}

}

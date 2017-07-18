<?php

namespace App\Models\Busi;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * 待办事项
 * Class WorkFlowTask
 * @package  App\Models
 *
 * @author  xrs
 * @SWG\Model(id="WorkFlowTask")
 * @SWG\Property(name="action", type="string", description="审批动作")
 * @SWG\Property(name="approver_id", type="integer", description="审批人id（user id）")
 * @SWG\Property(name="created_at", type="string", description="")
 * @SWG\Property(name="id", type="integer", description="")
 * @SWG\Property(name="link_id", type="integer", description="work flow link id")
 * @SWG\Property(name="node_id", type="integer", description="work flow node id")
 * @SWG\Property(name="pre_log_id", type="integer", description="pre log id")
 * @SWG\Property(name="remark", type="string", description="备注")
 * @SWG\Property(name="status", type="integer", description="处理状态（0-未处理，1-已经处理， 2-被撤销, 3-非正常结束, 4-挂起）")
 * @SWG\Property(name="uid", type="string", description="guid")
 * @SWG\Property(name="updated_at", type="string", description="")
 * @SWG\Property(name="work_flow_id", type="integer", description="")
 * @SWG\Property(name="work_flow_instance_id", type="integer", description="")
  */
class WorkFlowTask extends Model
{
	//
	protected $table = 'work_flow_tasks';
	protected $guarded = ['id'];

	public function workflow(){
		return $this->belongsTo(WorkFlow::class, 'work_flow_id');
	}

	public function instance(){
		return $this->belongsTo(WorkFlowInstance::class, 'work_flow_instance_id');
	}

	public function link(){
		return $this->belongsTo(WorkFlowLink::class, 'link_id');
	}

	public function node(){
		return $this->belongsTo(WorkFlowNode::class, 'node_id');
	}

	/**
	 * 当前审批人
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function approver(){
		return $this->belongsTo(User::class, 'approver_id');
	}

	protected static function boot()
	{
		parent::boot(); // TODO: Change the autogenerated stub
		static::creating(function ($model){
			$model->uid = uuid();
		});
	}

}

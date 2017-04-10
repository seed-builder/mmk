<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * 节点表单
 * Class WorkFlowNodeForm
 * @package  App\Models
 *
 * @author  xrs
 * @SWG\Model(id="WorkFlowNodeForm")
 * @SWG\Property(name="content", type="string", description="form content")
 * @SWG\Property(name="created_at", type="string", description="")
 * @SWG\Property(name="id", type="integer", description="")
 * @SWG\Property(name="node_id", type="integer", description="")
 * @SWG\Property(name="updated_at", type="string", description="")
  */
class WorkFlowNodeForm extends Model
{
	//
	protected $table = 'work_flow_node_forms';
	protected $guarded = ['id'];
}

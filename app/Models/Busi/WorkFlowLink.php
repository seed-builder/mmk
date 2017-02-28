<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * model description
 * 工作流定义-连接
 * @package  App\Models
 *
 * @author  xrs
 * @SWG\Model(id="WorkFlowLink")
 * @SWG\Property(name="source_node_id", type="integer", description="上一步节点")
 * @SWG\Property(name="target_node_id", type="integer", description="下一步节点")
 * @SWG\Property(name="condition", type="string", description="条件")
 * @SWG\Property(name="id", type="integer", description="")
 * @SWG\Property(name="created_at", type="string", description="")
 * @SWG\Property(name="updated_at", type="string", description="")
 * @SWG\Property(name="work_flow_id", type="integer", description="")
  */
class WorkFlowLink extends Model
{
	//
	protected $table = 'work_flow_links';
	protected $guarded = ['id'];
}

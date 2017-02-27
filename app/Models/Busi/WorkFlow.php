<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * model description
 * 工作流定义
 * @package  App\Models
 *
 * @author  xrs
 * @SWG\Model(id="WorkFlow")
 * @SWG\Property(name="name", type="string", description="名称")
 * @SWG\Property(name="status", type="integer", description="状态（0-未启用, 1-启用）")
 * @SWG\Property(name="table", type="string", description="关联表名")
 * @SWG\Property(name="created_at", type="string", description="")
 * @SWG\Property(name="updated_at", type="string", description="")
 * @SWG\Property(name="id", type="integer", description="")
  */
class WorkFlow extends BaseModel
{
	//
	protected $table = 'work_flows';
	protected $guarded = ['id'];
}

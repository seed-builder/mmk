<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * 工作流程变量
 * Class WorkFlowVariable
 * @package  App\Models
 *
 * @author  xrs
 * @SWG\Model(id="WorkFlowVariable")
 * @SWG\Property(name="categroy", type="integer", description="所属类型(0-公共变量, 1-私有变量)")
 * @SWG\Property(name="created_at", type="string", description="")
 * @SWG\Property(name="data_type", type="string", description="数据类型")
 * @SWG\Property(name="display_name", type="string", description="显示名(中文)")
 * @SWG\Property(name="id", type="integer", description="")
 * @SWG\Property(name="name", type="string", description="变量名（英文）")
 * @SWG\Property(name="updated_at", type="string", description="")
 * @SWG\Property(name="value", type="string", description="默认变量值")
 * @SWG\Property(name="work_flow_id", type="integer", description="")
  */
class WorkFlowVariable extends Model
{
	//
	protected $table = 'work_flow_variables';
	protected $guarded = ['id'];
}

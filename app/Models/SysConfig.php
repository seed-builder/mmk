<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * model description
 * Class SysConfig
 * @package  App\Models
 *
 * @author  xrs
 * @SWG\Model(id="SysConfig")
 * @SWG\Property(name="created_at", type="string", description="")
 * @SWG\Property(name="desc", type="string", description="描述")
 * @SWG\Property(name="id", type="integer", description="")
 * @SWG\Property(name="name", type="string", description="配置项目名称")
 * @SWG\Property(name="status", type="integer", description="状态（0-未启用, 1-启用）")
 * @SWG\Property(name="updated_at", type="string", description="")
 * @SWG\Property(name="value", type="string", description="值")
  */
class SysConfig extends Model
{
	//
	protected $table = 'sys_configs';
	protected $guarded = ['id'];
}

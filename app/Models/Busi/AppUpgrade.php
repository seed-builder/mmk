<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * model description
 * Class AppUpgrade
 * @package  App\Models
 *
 * @author  xrs
 * @SWG\Model(id="AppUpgrade")
 * @SWG\Property(name="content", type="string", description="")
 * @SWG\Property(name="created_at", type="string", description="")
 * @SWG\Property(name="enforce", type="integer", description="")
 * @SWG\Property(name="id", type="integer", description="")
 * @SWG\Property(name="updated_at", type="string", description="")
 * @SWG\Property(name="upgrade_date", type="string", description="")
 * @SWG\Property(name="url", type="string", description="")
 * @SWG\Property(name="version_code", type="string", description="")
 * @SWG\Property(name="version_name", type="string", description="")
  */
class AppUpgrade extends Model
{
	//
	protected $table = 'sys_upgrades';
	protected $guarded = ['id'];
}

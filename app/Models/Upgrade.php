<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * apk 升级包
 * Class Upgrade
 * @package App\Models\Busi
 * @author xrs
 * @SWG\Model(id="Upgrade")
 * @SWG\Property(name="upgrade_date", type="string", description="更新日期")
 * @SWG\Property(name="content", type="string", description="更新内容")
 * @SWG\Property(name="created_at", type="string", description="created_at")
 * @SWG\Property(name="enforce", type="integer", description="是否强制（0-否，1-是）")
 * @SWG\Property(name="id", type="integer", description="id")
 * @SWG\Property(name="updated_at", type="string", description="updated_at")
 * @SWG\Property(name="url", type="string", description="下载地址")
 * @SWG\Property(name="version_code", type="string", description="version_code")
 * @SWG\Property(name="version_name", type="string", description="version_name")
 * @SWG\Property(name="type", type="string", description="类型（android, iphone）")
 */
class Upgrade extends Model
{
    //
    protected $table='sys_upgrades';
    protected $guarded = ['id'];
    protected $filter = "false";
}

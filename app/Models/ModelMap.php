<?php

namespace App\Models;

use App\Models\Busi\BaseModel;
use Illuminate\Database\Eloquent\Model;

/**
 * 系统模型-数据库表对照表
 * Class ModelMap
 * @package App\Models
 */
class ModelMap extends BaseModel
{
    //
    protected $table = 'sys_model_maps';
    public $timestamps = false;
    protected $guarded = ['id'];

    protected $filter = "false";
}

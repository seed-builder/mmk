<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 字典表
 * Class Dic
 * @package App
 *
 * @author xrs
 * @SWG\Model(id="Dic")
 * @SWG\Property(name="id", type="integer", description="pk")
 * @SWG\Property(name="type", type="string", description="类型")
 * @SWG\Property(name="key", type="string", description="key")
 * @SWG\Property(name="value", type="string", description="value")
 */
class Dic extends Model
{
    //
    protected $table = 'sys_dics';
    protected $guarded = ['id'];

    public $filter = "false";
}

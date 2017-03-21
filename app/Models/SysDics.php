<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Busi\BaseModel;

class SysDics extends BaseModel
{
    //
    protected $table = 'sys_dics';
    protected $guarded = ['id'];
    protected $filter = "false";
    
    public $validateRules=['type' => 'required', 'key' => 'required','value' => 'required'];
}

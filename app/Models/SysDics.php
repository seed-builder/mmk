<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Busi\BaseModel;

class SysDics extends Model
{
    //
    protected $table = 'sys_dics';
    protected $guarded = ['id'];

    public $validateRules=['type' => 'required', 'key' => 'required','value' => 'required'];
}

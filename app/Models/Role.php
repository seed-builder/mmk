<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    //
    protected $table = 'sys_roles';
    protected $guarded = ['id'];

    public $validateRules=['name' => 'required', 'display_name' => 'required'];

}

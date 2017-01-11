<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    //
    protected $table = 'sys_permissions';
	protected $guarded = ['id'];
}

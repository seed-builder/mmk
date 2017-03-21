<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\EntrustPermission;

/**
 * model description
 * Class Permission
 * @package  App\Models
 *
 * @author  xrs
 * @SWG\Model(id="Permission")
 * @SWG\Property(name="created_at", type="string", description="")
 * @SWG\Property(name="description", type="string", description="")
 * @SWG\Property(name="display_name", type="string", description="")
 * @SWG\Property(name="id", type="integer", description="")
 * @SWG\Property(name="name", type="string", description="")
 * @SWG\Property(name="updated_at", type="string", description="")
 */
class Permission extends EntrustPermission
{
    //
    protected $table = 'sys_permissions';
	protected $guarded = ['id'];
    public $filter = "false";

}

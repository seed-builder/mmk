<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\EntrustRole;

/**
 * model description
 * Class Role
 * @package  App\Models
 *
 * @author  xrs
 * @SWG\Model(id="Role")
 * @SWG\Property(name="created_at", type="string", description="")
 * @SWG\Property(name="description", type="string", description="")
 * @SWG\Property(name="display_name", type="string", description="")
 * @SWG\Property(name="id", type="integer", description="")
 * @SWG\Property(name="name", type="string", description="")
 * @SWG\Property(name="updated_at", type="string", description="")
 */
class Role extends EntrustRole
{
    //
    protected $table = 'sys_roles';
    protected $guarded = ['id'];

    public $validateRules=['name' => 'required', 'display_name' => 'required'];

    protected $filter = "false";

}

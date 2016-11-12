<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * @package App
 *
 * @author xrs
 * @SWG\Model(id="Employee")
 * @SWG\Property(name="id", type="integer", description="pk")
 * @SWG\Property(name="name", type="string", description="name")
 * @SWG\Property(name="email", type="string", description="email")
 * @SWG\Property(name="password", type="string", description="password")
 */
class Employee extends UuidModel
{
    //
}

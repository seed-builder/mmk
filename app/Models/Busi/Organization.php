<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * 机构
 * Class Organization
 * @package App\Models\Busi
 * @author xrs
 * @SWG\Model(id="Organization")
 * @SWG\Property(name="faddress", type="string", description="faddress")
 * @SWG\Property(name="fauditor_id", type="integer", description="fauditor_id")
 * @SWG\Property(name="faudit_date", type="string", description="faudit_date")
 * @SWG\Property(name="fcontacts", type="string", description="fcontacts")
 * @SWG\Property(name="fcreate_date", type="string", description="fcreate_date")
 * @SWG\Property(name="fcreator_id", type="integer", description="fcreator_id")
 * @SWG\Property(name="fdocument_status", type="integer", description="fdocument_status")
 * @SWG\Property(name="fforbidder_id", type="integer", description="fforbidder_id")
 * @SWG\Property(name="fforbid_date", type="string", description="fforbid_date")
 * @SWG\Property(name="fforbid_status", type="integer", description="fforbid_status")
 * @SWG\Property(name="ffullname", type="string", description="ffullname")
 * @SWG\Property(name="fmodify_date", type="string", description="fmodify_date")
 * @SWG\Property(name="fmodify_id", type="integer", description="fmodify_id")
 * @SWG\Property(name="fname", type="string", description="fname")
 * @SWG\Property(name="fnumber", type="string", description="fnumber")
 * @SWG\Property(name="fowner", type="string", description="fowner")
 * @SWG\Property(name="fphone", type="string", description="fphone")
 * @SWG\Property(name="id", type="integer", description="id")
 */
class Organization extends BaseModel
{
    //
    protected $table = 'bd_organizations';
}

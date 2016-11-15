<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * 请假
 * Class Leave
 * @package App\Models\Busi
 * @author xrs
 * @SWG\Model(id="Leave")
 * @SWG\Property(name="fask_type", type="integer", description="fask_type")
 * @SWG\Property(name="fauditor_id", type="integer", description="fauditor_id")
 * @SWG\Property(name="faudit_date", type="string", description="faudit_date")
 * @SWG\Property(name="fbillno", type="string", description="fbillno")
 * @SWG\Property(name="fcreate_date", type="string", description="fcreate_date")
 * @SWG\Property(name="fcreator_id", type="integer", description="fcreator_id")
 * @SWG\Property(name="fdept_id", type="integer", description="fdept_id")
 * @SWG\Property(name="fdocument_status", type="integer", description="fdocument_status")
 * @SWG\Property(name="femp_id", type="integer", description="femp_id")
 * @SWG\Property(name="fend_time", type="string", description="fend_time")
 * @SWG\Property(name="fforbidder_id", type="integer", description="fforbidder_id")
 * @SWG\Property(name="fforbid_date", type="string", description="fforbid_date")
 * @SWG\Property(name="fforbid_status", type="integer", description="fforbid_status")
 * @SWG\Property(name="flentime", type="integer", description="flentime")
 * @SWG\Property(name="fmodify_date", type="string", description="fmodify_date")
 * @SWG\Property(name="fmodify_id", type="integer", description="fmodify_id")
 * @SWG\Property(name="forg_id", type="integer", description="forg_id")
 * @SWG\Property(name="freason", type="string", description="freason")
 * @SWG\Property(name="fremarks", type="string", description="fremarks")
 * @SWG\Property(name="fstart_time", type="string", description="fstart_time")
 * @SWG\Property(name="id", type="integer", description="id")
 */
class Leave extends BaseModel
{
    //
    protected $table = 'ms_leaves';
}

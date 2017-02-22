<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * model description
 * Class Leave
 * @package  App\Models
 *
 * @author  xrs
 * @SWG\Model(id="Leave")
 * @SWG\Property(name="fask_type", type="integer", description="")
 * @SWG\Property(name="fauditor_id", type="integer", description="")
 * @SWG\Property(name="faudit_date", type="string", description="")
 * @SWG\Property(name="fbillno", type="string", description="")
 * @SWG\Property(name="fcreate_date", type="string", description="")
 * @SWG\Property(name="fcreator_id", type="integer", description="")
 * @SWG\Property(name="fdept_id", type="integer", description="")
 * @SWG\Property(name="fdocument_status", type="string", description="")
 * @SWG\Property(name="femp_id", type="integer", description="")
 * @SWG\Property(name="fend_time", type="string", description="")
 * @SWG\Property(name="fforbidder_id", type="integer", description="")
 * @SWG\Property(name="fforbid_date", type="string", description="")
 * @SWG\Property(name="fforbid_status", type="string", description="")
 * @SWG\Property(name="flentime", type="integer", description="")
 * @SWG\Property(name="fmodify_date", type="string", description="")
 * @SWG\Property(name="fmodify_id", type="integer", description="")
 * @SWG\Property(name="forg_id", type="integer", description="")
 * @SWG\Property(name="freason", type="string", description="")
 * @SWG\Property(name="fremarks", type="string", description="")
 * @SWG\Property(name="fstart_time", type="string", description="")
 * @SWG\Property(name="id", type="integer", description="")
  */
class Leave extends BaseModel
{
	//
	protected $table = 'ms_leaves';
	protected $guarded = ['id'];

    protected $with = ['employee'];

    public function employee(){
        return $this->hasOne(Employee::class, 'id', 'femp_id');
    }
}

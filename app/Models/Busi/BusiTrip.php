<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;


/**
 * 出差明细
 * Class BusiTrip
 * @package App\Models\Busi
 * @author xrs
 * @SWG\Model(id="BusiTrip")
 * @SWG\Property(name="farrive_image", type="integer", description="farrive_image")
 * @SWG\Property(name="farrive_time", type="string", description="farrive_time")
 * @SWG\Property(name="fauditor_id", type="integer", description="fauditor_id")
 * @SWG\Property(name="faudit_date", type="string", description="faudit_date")
 * @SWG\Property(name="fbillno", type="string", description="fbillno")
 * @SWG\Property(name="fcreate_date", type="string", description="fcreate_date")
 * @SWG\Property(name="fcreator_id", type="integer", description="fcreator_id")
 * @SWG\Property(name="fdocument_status", type="integer", description="fdocument_status")
 * @SWG\Property(name="femp_id", type="integer", description="femp_id")
 * @SWG\Property(name="ffile_name", type="string", description="ffile_name")
 * @SWG\Property(name="ffile_path", type="string", description="ffile_path")
 * @SWG\Property(name="fforbidder_id", type="integer", description="fforbidder_id")
 * @SWG\Property(name="fforbid_date", type="string", description="fforbid_date")
 * @SWG\Property(name="fforbid_status", type="integer", description="fforbid_status")
 * @SWG\Property(name="flatitude", type="string", description="flatitude")
 * @SWG\Property(name="flongitude", type="string", description="flongitude")
 * @SWG\Property(name="fmodify_date", type="string", description="fmodify_date")
 * @SWG\Property(name="fmodify_id", type="integer", description="fmodify_id")
 * @SWG\Property(name="forg_id", type="integer", description="forg_id")
 * @SWG\Property(name="fout_time", type="string", description="fout_time")
 * @SWG\Property(name="fremark", type="string", description="fremark")
 * @SWG\Property(name="id", type="integer", description="id")
 */
class BusiTrip extends BaseModel
{
    //
    protected $table = 'ms_busi_trips';
}

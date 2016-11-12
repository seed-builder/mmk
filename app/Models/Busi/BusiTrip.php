<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * 出差明细
 * @package App\Models\Busi
 *
 * @author xrs
 * @SWG\Model(id="BusiTrip")
 * @SWG\Property(name="id", type="integer", description="pk")
 * @SWG\Property(name="fbillno", type="string", description="单据编号")
 * @SWG\Property(name="forg_id", type="string", description="机构id")
 * @SWG\Property(name="femp_id", type="string", description="员工id")
 * @SWG\Property(name="farrive_image", type="string", format="date", description="password")
 * @SWG\Property(name="farrive_time", type="string", format="date" , description="password")
 * @SWG\Property(name="fout_time", type="string", format="date", description="出发签到时间")
 * @SWG\Property(name="fremark", type="string", description="password")
 * @SWG\Property(name="ffile_path", type="string", description="password")
 * @SWG\Property(name="ffile_name", type="string", description="password")
 * @SWG\Property(name="flongitude", type="string", description="经度")
 * @SWG\Property(name="flatitude", type="string", description="纬度")
 */
class BusiTrip extends BaseModel
{
    //
}

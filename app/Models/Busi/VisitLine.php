<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * 巡访线路
 * Class VisitLine
 * @package App\Models\Busi
 * @author xrs
 * @SWG\Model(id="VisitLine")
 * @SWG\Property(name="fcreate_date", type="string", description="创建时间")
 * @SWG\Property(name="fcreator_id", type="integer", description="创建人")
 * @SWG\Property(name="fdocument_status", type="string", description="审核状态")
 * @SWG\Property(name="femp_id", type="integer", description="员工id")
 * @SWG\Property(name="fmodify_date", type="string", description="修改时间")
 * @SWG\Property(name="fmodify_id", type="integer", description="修改人")
 * @SWG\Property(name="fname", type="string", description="名称")
 * @SWG\Property(name="fnumber", type="string", description="编号")
 * @SWG\Property(name="forg_id", type="integer", description="组织id")
 * @SWG\Property(name="id", type="integer", description="")
 */
class VisitLine extends BaseModel
{
    //
    protected $table = 'visit_line';
}

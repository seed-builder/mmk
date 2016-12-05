<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * 定制功能
 * Class VisitFunction
 * @package App\Models\Busi
 * @author xrs
 * @SWG\Model(id="VisitFunction")
 * @SWG\Property(name="fcreate_date", type="string", description="创建时间")
 * @SWG\Property(name="fcreator_id", type="integer", description="创建人")
 * @SWG\Property(name="fdocument_status", type="string", description="审核状态")
 * @SWG\Property(name="fmodify_date", type="string", description="修改时间")
 * @SWG\Property(name="fmodify_id", type="integer", description="修改人")
 * @SWG\Property(name="fname", type="string", description="名称")
 * @SWG\Property(name="fnumber", type="string", description="编号")
 * @SWG\Property(name="forg_id", type="integer", description="组织id")
 * @SWG\Property(name="id", type="integer", description="")
 */
class VisitFunction extends BaseModel
{
    //
    protected $table = 'visit_function';
}

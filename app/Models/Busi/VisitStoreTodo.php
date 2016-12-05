<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * 门店巡访项目
 * Class VisitStoreTodo
 * @package App\Models\Busi
 * @author xrs
 * @SWG\Model(id="VisitStoreTodo")
 * @SWG\Property(name="fcreate_date", type="string", description="创建时间")
 * @SWG\Property(name="fcreator_id", type="integer", description="创建人")
 * @SWG\Property(name="fdocument_status", type="string", description="审核状态")
 * @SWG\Property(name="ffunction_number", type="string", description="定制功能编号")
 * @SWG\Property(name="fgroup_id", type="string", description="分组标识")
 * @SWG\Property(name="fis_must_visit", type="integer", description="是否必巡")
 * @SWG\Property(name="flag", type="string", description="标识符")
 * @SWG\Property(name="fmodify_date", type="string", description="修改时间")
 * @SWG\Property(name="fmodify_id", type="integer", description="修改人")
 * @SWG\Property(name="fname", type="string", description="名称")
 * @SWG\Property(name="fnumber", type="string", description="编号")
 * @SWG\Property(name="forg_id", type="integer", description="组织id")
 * @SWG\Property(name="fparent_id", type="integer", description="父级id")
 * @SWG\Property(name="id", type="integer", description="")
 */
class VisitStoreTodo extends BaseModel
{
    //
    protected $table = 'visit_store_todo';
}

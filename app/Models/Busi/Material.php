<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Material
 * @package App\Models\Busi
 * @author xrs
 * @SWG\Model(id="Material")
 * @SWG\Property(name="fcreate_date", type="string", description="创建时间")
 * @SWG\Property(name="fcreator_id", type="integer", description="创建人")
 * @SWG\Property(name="fdocument_status", type="string", description="数据状态")
 * @SWG\Property(name="fmodify_date", type="string", description="修改时间")
 * @SWG\Property(name="fmodify_id", type="integer", description="修改人")
 * @SWG\Property(name="fname", type="string", description="物料名称")
 * @SWG\Property(name="fnumber", type="string", description="物料编码")
 * @SWG\Property(name="funit", type="string", description="单位")
 * @SWG\Property(name="id", type="integer", description="")
 */
class Material extends BaseModel
{
    //
	protected $table = 'bd_material';
}

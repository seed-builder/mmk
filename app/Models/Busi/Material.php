<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * model description
 * Class Material
 * @package  App\Models
 *
 * @author  xrs
 * @SWG\Model(id="Material")
 *
 * @SWG\Property(name="fname", type="string", description="物料名称")
 * @SWG\Property(name="fnumber", type="string", description="物料编码")
 * @SWG\Property(name="fsale_unit", type="string", description="销售单位")
 * @SWG\Property(name="fbase_unit", type="string", description="基本单位")
 * @SWG\Property(name="fratio", type="integer", description="换算成销售单位乘数")
 * @SWG\Property(name="fspecification", type="string", description="规格")
 * @SWG\Property(name="fcreate_date", type="string", description="创建时间")
 * @SWG\Property(name="fcreator_id", type="integer", description="创建人")
 * @SWG\Property(name="fdocument_status", type="string", description="数据状态")
 * @SWG\Property(name="fmodify_date", type="string", description="修改时间")
 * @SWG\Property(name="fmodify_id", type="integer", description="修改人")
 * @SWG\Property(name="id", type="integer", description="")
  */
class Material extends BaseModel
{
	//
	protected $table = 'bd_materials';
	protected $guarded = ['id'];
}

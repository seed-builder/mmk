<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * model description
 * Class ViewStoreOut
 * @package  App\Models
 *
 * @author  xrs
 * @SWG\Model(id="ViewStoreOut")
 * @SWG\Property(name="fbase_qty", type="number", description="")
 * @SWG\Property(name="fbase_unit", type="string", description="基本单位")
 * @SWG\Property(name="fmaterial_id", type="integer", description="")
 * @SWG\Property(name="fsale_qty", type="number", description="")
 * @SWG\Property(name="fsale_unit", type="string", description="销售单位")
 * @SWG\Property(name="fsend_base_qty", type="number", description="")
 * @SWG\Property(name="fsend_qty", type="number", description="")
 * @SWG\Property(name="fspecification", type="string", description="规格")
 * @SWG\Property(name="fstore_id", type="integer", description="门店id")
 * @SWG\Property(name="material_name", type="string", description="物料名称")
 * @SWG\Property(name="material_number", type="string", description="物料编码")
 * @SWG\Property(name="out_base_qty", type="number", description="")
 * @SWG\Property(name="out_qty", type="number", description="")
 * @SWG\Property(name="store_name", type="string", description="全名")
 * @SWG\Property(name="store_number", type="string", description="编号")
  */
class ViewStoreOut extends BaseModel
{
	//
	protected $table = 'view_store_outs';
	protected $guarded = ['id'];
}

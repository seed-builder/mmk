<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * 商品价格（视图）
 * Class ViewMaterialPrice
 * @package  App\Models
 *
 * @author  xrs
 * @SWG\Model(id="ViewMaterialPrice")
 * @SWG\Property(name="customer_id", type="integer", description="")
 * @SWG\Property(name="customer_name", type="string", description="客户名称")
 * @SWG\Property(name="fbegin", type="string", description="起始时间")
 * @SWG\Property(name="fcheck_date", type="string", description="审核日期")
 * @SWG\Property(name="fend", type="string", description="截止时间")
 * @SWG\Property(name="fis_all", type="integer", description="是否适用全部")
 * @SWG\Property(name="flevel", type="integer", description="优先级（数字越大优先级越低）")
 * @SWG\Property(name="fmaterial_id", type="integer", description="")
 * @SWG\Property(name="fmax_qty", type="integer", description="数量止")
 * @SWG\Property(name="fmin_qty", type="integer", description="数量起")
 * @SWG\Property(name="fprice", type="number", description="价格")
 * @SWG\Property(name="fsuit_object", type="string", description="适用范围:(store-门店, customer-经销商)")
 * @SWG\Property(name="fsuit_order", type="integer", description="")
 * @SWG\Property(name="id", type="integer", description="")
 * @SWG\Property(name="store_id", type="integer", description="")
 * @SWG\Property(name="store_name", type="string", description="全名")
  */
class ViewMaterialPrice extends BaseModel
{
	//
	protected $table = 'view_material_prices';
	protected $guarded = ['*'];
}

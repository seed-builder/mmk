<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * model description
 * Class SaleOrderItem
 * @package  App\Models
 *
 * @author  xrs
 * @SWG\Model(id="SaleOrderItem")
 * @SWG\Property(name="fbase_qty", type="number", description="销售基本单位数量（瓶）(订单数量*商品表FRotio)")
 * @SWG\Property(name="fbase_unit", type="string", description="基本单位")
 * @SWG\Property(name="fcreate_date", type="string", description="创建时间")
 * @SWG\Property(name="fcreator_id", type="integer", description="创建人")
 * @SWG\Property(name="fdocument_status", type="string", description="审核状态")
 * @SWG\Property(name="fmaterial_id", type="integer", description="物料内码id")
 * @SWG\Property(name="fmodify_date", type="string", description="修改时间")
 * @SWG\Property(name="fmodify_id", type="integer", description="修改人")
 * @SWG\Property(name="fqty", type="number", description="订单数量")
 * @SWG\Property(name="fsale_order_id", type="integer", description="")
 * @SWG\Property(name="fsale_unit", type="string", description="销售单位")
 * @SWG\Property(name="fsend_base_qty", type="number", description="发货基本单位数量")
 * @SWG\Property(name="fsend_qty", type="number", description="发货数量")
 * @SWG\Property(name="id", type="integer", description="")
  */
class SaleOrderItem extends BaseModel
{
	//
	protected $table = 'st_sale_order_items';
	protected $guarded = ['id'];

	public function order(){
        return $this->hasOne(SaleOrder::class,'id','fsale_order_id');
    }
    public function meterial(){
        return $this->hasOne(Material::class,'id','fmaterial_id');
    }
}

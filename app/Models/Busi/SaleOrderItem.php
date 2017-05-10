<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;
use App\Services\LogSvr;

/**
 * model description
 * Class SaleOrderItem
 * @package  App\Models
 *
 * @author  xrs
 * @SWG\Model(id="SaleOrderItem")
 * @SWG\Property(name="id", type="integer", description="")
 * @SWG\Property(name="fsale_order_id", type="integer", description="")
 * @SWG\Property(name="fstock_id", type="integer", description="库存内码id")
 * @SWG\Property(name="fmaterial_id", type="integer", description="物料内码id")
 * @SWG\Property(name="box_qty", type="number", description="箱数量")
 * @SWG\Property(name="bottle_qty", type="number", description="瓶数量")
 * @SWG\Property(name="present_box_qty", type="number", description="赠送的箱数量")
 * @SWG\Property(name="present_bottle_qty", type="number", description="赠送的瓶数量")
 * @SWG\Property(name="fqty", type="number", description="订单数量")
 * @SWG\Property(name="fsale_unit", type="string", description="销售单位")
 * @SWG\Property(name="fbase_unit", type="string", description="基本单位")
 * @SWG\Property(name="fbase_qty", type="number", description="销售基本单位数量（瓶）(订单数量*商品表FRotio)")
 * @SWG\Property(name="fsend_base_qty", type="number", description="发货基本单位数量")
 * @SWG\Property(name="fsend_qty", type="number", description="发货数量")
 * @SWG\Property(name="fcreate_date", type="string", description="创建时间")
 * @SWG\Property(name="fcreator_id", type="integer", description="创建人")
 * @SWG\Property(name="fdocument_status", type="string", description="审核状态")
 * @SWG\Property(name="fmodify_date", type="string", description="修改时间")
 * @SWG\Property(name="fmodify_id", type="integer", description="修改人")
 */
class SaleOrderItem extends BaseModel
{
	//
	protected $table = 'st_sale_order_items';
	protected $guarded = ['id'];
	protected $appends = ['box_qty', 'bottle_qty','present_box_qty','present_bottle_qty'];

	public function __construct(array $attributes = [])
	{
		if (!empty($attributes) && $attributes['fmaterial_id'] > 0) {
			$material = Material::find($attributes['fmaterial_id']);
			$attributes['fsale_unit'] = $material->fsale_unit;
			$attributes['fbase_unit'] = $material->fbase_unit;
			//
			$attributes['fqty'] = $attributes['box_qty'] + round($attributes['bottle_qty'] / $material->fratio, 2);
			$attributes['fbase_qty'] = $attributes['box_qty'] * $material->fratio + $attributes['bottle_qty'];
			//赠送数量
			$attributes['fpresent_qty'] = $attributes['present_box_qty'] + round($attributes['present_bottle_qty'] / $material->fratio, 2);
			$attributes['fpresent_base_qty'] = $attributes['present_box_qty'] * $material->fratio + $attributes['present_bottle_qty'];

			unset($attributes['box_qty']);
			unset($attributes['bottle_qty']);
			unset($attributes['present_box_qty']);
			unset($attributes['present_bottle_qty']);
		}
		parent::__construct($attributes);
	}

	public function order(){
        return $this->hasOne(SaleOrder::class,'id','fsale_order_id');
    }

    public function material(){
        return $this->hasOne(Material::class,'id','fmaterial_id');
    }

    public function getBoxQtyAttribute(){
	    return floor($this->fqty);
    }

	public function getBottleQtyAttribute(){
		if($this->material){
			return $this->fbase_qty - floor($this->fqty) * $this->material->fratio;
		}
		return $this->fbase_qty ;
	}

	public function getPresentBoxQtyAttribute(){
		return floor($this->fpresent_qty);
	}

	public function getPresentBottleQtyAttribute(){
		if($this->material){
			return $this->fpresent_qty - floor($this->fpresent_qty) * $this->material->fratio;
		}
		return $this->fpresent_base_qty ;
	}

}

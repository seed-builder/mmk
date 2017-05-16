<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * 价格
 * Class Price
 * @package  App\Models
 *
 * @author  xrs
 * @SWG\Model(id="Price")
 * @SWG\Property(name="fchecker", type="string", description="审核人id")
 * @SWG\Property(name="fcheck_date", type="string", description="审核日期")
 * @SWG\Property(name="fcreate_date", type="string", description="")
 * @SWG\Property(name="fdocument_status", type="string", description="审核状态（A-未审核, B-审核中, C-审核通过)")
 * @SWG\Property(name="fgroup_id", type="integer", description="")
 * @SWG\Property(name="fmaterial_id", type="integer", description="")
 * @SWG\Property(name="fmax_qty", type="integer", description="数量止")
 * @SWG\Property(name="fmin_qty", type="integer", description="数量起")
 * @SWG\Property(name="fmodify_date", type="string", description="")
 * @SWG\Property(name="fprice", type="number", description="价格")
 * @SWG\Property(name="fsale_unit", type="string", description="销售单位")
 * @SWG\Property(name="fspecification", type="string", description="规格")
 * @SWG\Property(name="id", type="integer", description="")
  */
class Price extends BaseModel
{
	//
	protected $table = 'bd_prices';
	protected $guarded = ['id'];

	public function group(){
		return $this->belongsTo(PriceGroup::class, 'fgroup_id');
	}

	public function material(){
		return $this->belongsTo(Material::class, 'fmaterial_id');
	}

}

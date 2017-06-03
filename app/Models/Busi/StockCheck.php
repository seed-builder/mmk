<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * 经销商库存盘点单
 * Class StockCheck
 * @package  App\Models
 *
 * @author  xrs
 * @SWG\Model(id="StockCheck")
 * @SWG\Property(name="fchecker_id", type="string", description="盘点人id(user id)")
 * @SWG\Property(name="fcheck_date", type="string", description="盘点日期")
 * @SWG\Property(name="fcheck_status", type="integer", description="0-盘点中,1-盘点完成，2-取消盘点")
 * @SWG\Property(name="fcreate_date", type="string", description="")
 * @SWG\Property(name="fcust_id", type="integer", description="")
 * @SWG\Property(name="fcust_user_id", type="integer", description="")
 * @SWG\Property(name="fmodify_date", type="string", description="")
 * @SWG\Property(name="id", type="integer", description="")
  */
class StockCheck extends BaseModel
{
	//
	protected $table = 'st_stock_checks';
	protected $guarded = ['id'];

	public function items(){
		return $this->hasMany(StockCheckItem::class, 'fstock_check_id');
	}
}

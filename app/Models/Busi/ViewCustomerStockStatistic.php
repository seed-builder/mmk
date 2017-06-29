<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * 经销商实时库存视图
 * Class ViewCustomerStockStatistic
 * @package  App\Models
 *
 * @author  xrs
 * @SWG\Model(id="ViewCustomerStockStatistic")
 * @SWG\Property(name="cust_id", type="integer", description="")
 * @SWG\Property(name="cust_name", type="string", description="")
 * @SWG\Property(name="fbase_qty", type="number", description="")
 * @SWG\Property(name="fbase_unit", type="string", description="")
 * @SWG\Property(name="fqty", type="number", description="")
 * @SWG\Property(name="fsale_unit", type="string", description="")
 * @SWG\Property(name="material_id", type="integer", description="")
 * @SWG\Property(name="material_name", type="string", description="")
 * @SWG\Property(name="material_specification", type="string", description="")
  */
class ViewCustomerStockStatistic extends BaseModel
{
	//
	protected $table = 'view_customer_stock_statistic';
	protected $guarded = ['id'];
	protected $appends = ['box_qty', 'bottle_qty'];

	public function getBoxQtyAttribute(){
		return floor($this->fqty);
	}

	public function getBottleQtyAttribute(){
		return $this->fbase_qty - floor($this->fqty) * $this->fratio;
	}

}

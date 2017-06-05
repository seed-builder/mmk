<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * 经销商库存盘点单
 * Class StockCheck
 * @package  App\Models\Busi
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

	/**
	 * 查询或者新建盘点单
	 * @param $cust_id
	 * @param $checker_id
	 * @return mixed
	 */
	public static function findOrInit($cust_id, $checker_id)
	{
		$count = static::where('fcust_id', $cust_id)
			->where('fcheck_status', 0)
			->count();
		if($count == 0){
			$customer = Customer::find($cust_id);
			if(!empty($customer)) {
				$check = static::create([
					'fcust_id' => $cust_id,
					'fcust_user_id' => $customer->user->id,
					'fcheck_status' => 0,
					'fcheck_date' => date('Y-m-d H:i:s'),
					'fchecker_id' => $checker_id
				]);
				//create items
				$stocks = ViewCustomerStockStatistic::where('cust_id', $cust_id)->whereNotNull('material_name')->get();
				if(!empty($stocks)){
					foreach ($stocks as $stock) {
						$boxes = floor($stock->fqty);
						$bottles = $stock->fbase_qty - floor($stock->fqty) * $stock->fratio;
						StockCheckItem::create([
							'fstock_check_id' => $check->id,
							'fmaterial_id' => $stock->material_id,
							'finv_hqty' => $stock->fqty,
							'finv_eqty' => $stock->fbase_qty,
							'fcheck_hqty' => 0, //$stock->fqty,
							'fcheck_eqty' => 0, //$stock->fbase_qty,
							'fdiff_hqty' => 0,
							'fdiff_eqty' => 0,
							'box_qty' => $boxes,
							'bottle_qty' => $bottles,
						]);
					}
				}
			}
		}
		$check = static::with(['items.material'])
			->where('fcust_id', $cust_id)
			->where('fcheck_status', 0)
			->first();
		return $check;
	}
}

<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017-05-19
 * Time: 14:00
 */

namespace App\Repositories;


use App\Models\Busi\ViewMaterialPrice;
use Illuminate\Support\Facades\DB;

class PriceRepo extends Repo
{
	/**
	 * 获取商品的价格
	 * @param $material_id
	 * @param int $qty
	 * @param string $date
	 */
	public static function getPrice($material_id, $qty = 0, $date = ''){
		if($date == '') $date = date('Y-m-d');
		$price = ViewMaterialPrice::where('fbegin', '<=', $date)
			->where('fend', '>=', $date)
			->where('fmaterial_id', $material_id)
			->where('fmin_qty', '<=', $qty)
			->where('fmax_qty', '>=', $qty)
			->first();
		return $price;
	}

	public static function getStorePrice($store_id, $material_id, $qty = 0, $date = ''){
		$price = ViewMaterialPrice::where('fbegin', '<=', $date)
			->where(function ($query)use($store_id){
				$query->where('store_id', $store_id)
					->orWhere('fis_all', 1);
			})
			->where('fbegin', '<=', $date)
			->where('fend', '>=', $date)
			->where('fmaterial_id', $material_id)
			->where('fmin_qty', '<=', $qty)
			->where('fmax_qty', '>=', $qty)
			->first();
		return $price;
	}

	public static function getCustomerPrice($customer_id, $material_id, $qty = 0, $date = ''){
		$price = ViewMaterialPrice::where('fbegin', '<=', $date)
			->where(function ($query)use($customer_id){
				$query->where('customer_id', $customer_id)
					->orWhere('fis_all', 1);
			})
			->where('fbegin', '<=', $date)
			->where('fend', '>=', $date)
			->where('fmaterial_id', $material_id)
			->where('fmin_qty', '<=', $qty)
			->where('fmax_qty', '>=', $qty)
			->first();
		return $price;
	}
}
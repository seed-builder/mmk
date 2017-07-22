<?php

namespace App\Http\Controllers\Api;

use App\Models\Busi\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Models\Busi\CustomerPrice;

class CustomerPriceController extends ApiController
{
	//
	public function newEntity(array $attributes = [])
	{
		// TODO: Implement newEntity() method.
		return new CustomerPrice($attributes);
	}

	public function getByStore(Request $request)
	{
		$store_id = $request->input('store_id', 0);
		$material_id = $request->input('material_id', 0);
		$store = Store::find($store_id);
		$price = null;
		if(!empty($store)){
			$price = CustomerPrice::getPrice($store->fcust_id, $material_id, 100);
		}
		return $this->success($price);
	}
}
<?php

namespace App\Http\Controllers\Api;

use App\Models\Busi\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Models\Busi\StockCheck;

class StockCheckController extends ApiController
{
	//
	public function newEntity(array $attributes = [])
	{
		// TODO: Implement newEntity() method.
		return new StockCheck($attributes);
	}

	public function findOrCreate(Request $request, $cust_id){
		$fchecker_id = $request->input('checker_id');
		$check = StockCheck::where('fcust_id', $cust_id)->where('fcheck_status', 0)->first();
		if(empty($check)){
			$customer = Customer::find($cust_id);
			if(!empty($customer)) {
				$check = StockCheck::create([
					'fcust_id' => $cust_id,
					'fcust_user_id' => $customer->user->id,
					'fcheck_status' => 0,
					'fcheck_date' => date('Y-m-d H:i:s'),
					'fchecker_id' => $fchecker_id
				]);
			}
		}
		return $this->success($check);
	}
}
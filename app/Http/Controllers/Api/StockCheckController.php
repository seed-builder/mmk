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
		$check = StockCheck::findOrInit($cust_id, $fchecker_id);
		return $this->success($check);
	}
}
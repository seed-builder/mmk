<?php

namespace App\Http\Controllers\Api;

use App\Models\Busi\Customer;
use App\Models\Busi\Stock;
use App\Models\Busi\StockCheckItem;
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
		return $check ? $this->success($check) : $this->fail('用户不存在!');
	}

	/**
	 * 统计盘点： 品项、箱 （合计）
	 * @param Request $request
	 * @param $stock_check_id
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 */
	public function statistic(Request $request, $id){
		$boxes = StockCheckItem::where('fstock_check_id', $id)->sum('fcheck_hqty');
		$total = StockCheckItem::where('fstock_check_id', $id)->count('fmaterial_id');
		return $this->success(['total' => $total, 'boxes' => $boxes]);
	}
}
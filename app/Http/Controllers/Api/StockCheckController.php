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
		$d = strtotime("-1 month");
		$year = date('Y', $d);
		$month = date('n', $d);

		$fchecker_id = $request->input('checker_id');
		$check = StockCheck::findOrInit($cust_id, $fchecker_id, $year, $month);
		return $check ? $this->success($check) : $this->fail('该经销商用户不存在!');
	}

	/**
	 * 统计盘点： 品项、箱 （合计）
	 * @param Request $request
	 * @param $id
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 */
	public function statistic(Request $request, $id){
		$boxes = StockCheckItem::where('fstock_check_id', $id)->sum('fcheck_hqty');
		$total = StockCheckItem::where('fstock_check_id', $id)->count('fmaterial_id');
		return $this->success(['total' => $total, 'boxes' => $boxes]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		//
		$entity = $this->newEntity()->newQuery()->find($id);
		$data = $request->all();
		unset($data['_sign']);
		if(!empty($data['fcheck_status'])) {
			if ($data['fcheck_status'] == 1 && $entity->fcheck_status == 0) {
				$entity->fcomplete_date = date('Y-m-d H:i:s');
			}
		}
		$entity->fill($data);
		$re = $entity->save();
		$status = $re ? 200 : 401;
		return response(['success' => $re], $status);
	}

}
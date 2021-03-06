<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017-06-15
 * Time: 14:29
 */

namespace App\Services;


use App\Services\DataSync\KingdeeWorker;

class Utility
{
	/**
	 * 获取经销商账款余额接口
	 * @param $custId
	 * @return mixed
	 */
	public static function getCustomerBalance($custId){
		$worker = new KingdeeWorker();
		$url = env('KINGDEE_HOST') . '/k3cloud/CYD.ApiService.ServicesStub.CustomBusinessService.CustBalAmountGet.common.kdsvc';
		$amount = $worker->post($url, ['parameters' => [$custId]]);
		return $amount;
	}

	/**
	 * 获取经销商代垫返还数据
	 * @param $custId
	 * @param $begin_year
	 * @param $begin_month
	 * @param $end_year
	 * @param $end_month
	 * @return mixed
	 */
	public static function getCustomerDDReturn($custId, $begin_year, $begin_month, $end_year, $end_month){
		$worker = new KingdeeWorker();
		$url = env('KINGDEE_HOST') . '/k3cloud/CYD.ApiService.ServicesStub.CustomBusinessService.CustDDDetailGet.common.kdsvc';
//		var_dump($url);
		$data = $worker->post($url, ['parameters' => [$custId, $begin_year, $begin_month, $end_year, $end_month]]);
//		var_dump($data);
		return $data;
	}


}
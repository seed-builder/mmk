<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017-01-14
 * Time: 16:03
 */

namespace App\Services\DataSync;

use App\Services\LogSvr;


/**
 * 金蝶数据同步处理
 * Class KingdeeWorker
 * @package App\Services\DataSync
 */
class KingdeeWorker extends DbWorker
{
	protected $loginUrl = '/k3cloud/Kingdee.BOS.WebApi.ServicesStub.AuthService.ValidateUser.common.kdsvc';
	protected $dataUrl = '/k3cloud/CYD.ApiService.ServicesStub.CustomBusinessService.Syncdb.common.kdsvc';
	//protected $cookie_jar;

	public function __construct()
	{
		$this->loginUrl = env('KINGDEE_HOST') . $this->loginUrl;
		$this->dataUrl = env('KINGDEE_HOST') . $this->dataUrl;
	}

	/**
	 * 发送数据
	 * @param $name - 表名
	 * @param $op - 0-新增， 1-修改， 2-删除
	 * @param array $data - 数据行
	 */
	public function send($name, $op, array $data)
	{
		$table = $name;

		LOGIN:
		$cookie_jar = tempnam('./tmp', 'CloudSession');
		$re = $this->login($cookie_jar);
		LogSvr::KingdeeSync()->info('login result : ' . $re);
			//if(!empty($re))

		$result = $this->sendData($table, $op, $data, $cookie_jar);
		LogSvr::KingdeeSync()->info('$result  : ' . $result);
		$resArr = json_decode($result, true);
		if($resArr['Result'] == 0 && $resArr['Msg'] == '请先登录'){
			LogSvr::KingdeeSync()->info('跳转到登录');
			goto LOGIN;
		}
		//return json_decode($result, true);
	}

	protected function login(&$cookie_jar){
		//{ "parameters": "[\"5826e02fe123a9\",\"Administrator\",\"888888\",2052]" }
		//5826e02fe123a9,Administrator,888888
		$str = env('KINGDEE_HOST_LOGIN_DATA');
		$arr = explode(',', $str);
		$arr[] = 2052;
		$loginData = ['parameters' => json_encode($arr)];
		LogSvr::KingdeeSync()->info('login Url : ' . $this->dataUrl);
		LogSvr::KingdeeSync()->info('login Data : ' . json_encode($loginData));
		return $this->httpPost($this->loginUrl, json_encode($loginData), 1, $cookie_jar);
	}

	protected function sendData($table, $op, $data, $cookie_jar = null){
		$arr = ['parameters' => [$table, $op, json_encode($data)]];
		//var_dump(json_encode($arr));
//		LogSvr::KingdeeSync()->info('data Url : ' . $this->dataUrl);
//		LogSvr::KingdeeSync()->info('data : ' . json_encode($arr));
		return $this->httpPost($this->dataUrl, $arr, 0, $cookie_jar);
	}

	public function post($url, $data){
		$login_times = 0;
		LOGIN:
		$cookie_jar = tempnam('./tmp', 'CloudSession');
		$re = $this->login($cookie_jar);
		LogSvr::KingdeeSync()->info('login result : ' . $re);
		//if(!empty($re))
		$login_times++;
		$result = $this->httpPost($url, $data, 0, $cookie_jar);
		LogSvr::KingdeeSync()->info('$result  : ' . $result);
		$resArr = json_decode($result, true);
		if($resArr['Result'] == 0 && $resArr['Msg'] == '请先登录'){
			LogSvr::KingdeeSync()->info('跳转到登录');
			if($login_times < 10)
				goto LOGIN;
		}
		return $resArr;
	}

//	public function sync($table, $op, $data){
//		$cookie_jar = tempnam('./tmp','CloudSession');
//		$re = $this->login($cookie_jar);
//		LogSvr::KingdeeSync()->info('login result : ' . $re);
//		//if(!empty($re))
//		$result = $this->sendData($table, $op, $data, $cookie_jar);
//		LogSvr::KingdeeSync()->info('$result  : ' . $result);
//		return json_decode($result, true);
//	}
//
//	public static function add($table, $data){
//		$sync = new static();
//		return $sync->send($table, 0, $data);
//	}
//
//	public static function update($table, $data){
//		$sync = new static();
//		return $sync->send($table, 1, $data);
//	}
//
//	public static function delete($table, $data){
//		$sync = new static();
//		return $sync->send($table, 2, $data);
//	}
}
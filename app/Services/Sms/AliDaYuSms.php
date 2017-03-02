<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017-03-02
 * Time: 15:32
 */

namespace App\Services\Sms;


use App\Services\Ali\AlibabaAliqinFcSmsNumSendRequest;
use App\Services\Ali\TopClient;

class AliDaYuSms extends SmsSvr
{
	private $appKey;
	private $secretKey;

	public function __construct()
	{
		$this->appKey = env('ALIDAYU_APP_KEY');
		$this->secretKey = env('ALIDAYU_APP_SECRET');
	}

	/**
	 * 验证码
	 * @param $phone
	 */
	public function verify($phone){

	}

	/**
	 * 通知
	 * @param $phones
	 * @param $data
	 */
	public function notify($phones, $data){

	}

	/**
	 * 发送短信
	 * @param $templateCode
	 * @param array $data
	 * @param array $phones
	 * @return \App\Services\Ali\ResultSet|mixed|\SimpleXMLElement
	 */
	public function send($templateCode, array $data, array $phones){
		$c = new TopClient;
		$c->appkey = $this->appKey;
		$c->secretKey = $this->secretKey;
		$req = new AlibabaAliqinFcSmsNumSendRequest;
		$req->setExtend("123456");
		$req->setSmsType("normal");
		$req->setSmsFreeSignName("光明之子");
		$req->setSmsParam(json_encode($data));
		$req->setRecNum($phones);
		$req->setSmsTemplateCode($templateCode);
		$resp = $c->execute($req);
		return $resp;
	}

	public function verifyCode($len = 6){
		return sprintf('%0'.$len.'d', mt_rand(0, 999999));
	}
}
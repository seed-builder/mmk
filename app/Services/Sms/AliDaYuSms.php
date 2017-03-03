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
use Cache;
use Carbon\Carbon;

class AliDaYuSms implements ISmsSvr
{
	private $appKey;
	private $secretKey;
	const CACHE_PREFIX = 'sms_verify_';

	public function __construct()
	{
		$this->appKey = env('ALIDAYU_APP_KEY');
		$this->secretKey = env('ALIDAYU_APP_SECRET');
	}

	/**
	 * 验证码
	 * @param $phone
	 * @return \App\Services\Ali\ResultSet|mixed|\SimpleXMLElement
	 */
	public function verify($phone){
		$code = $this->verifyCode(6);
		$resp = $this->send('SMS_52265167',['code'=> $code], [$phone]);
		$cacheKey = static::CACHE_PREFIX . $phone;
		$expiresAt = Carbon::now()->addMinutes(15);
		Cache::put($cacheKey, $code, $expiresAt);
		return $resp;
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
		$req->setExtend("山图通");
		$req->setSmsType("normal");
		$req->setSmsFreeSignName("山图通");
		$req->setSmsParam(json_encode($data));
		$req->setRecNum(implode(',',$phones));
		$req->setSmsTemplateCode($templateCode);
		$resp = $c->execute($req);
		return $resp;
	}

	/**
	 * 生成验证码
	 * @param int $len
	 * @return string
	 */
	public function verifyCode($len = 6){
		return sprintf('%0'.$len.'d', mt_rand(0, 999999));
	}

	/**
	 * 验证
	 * @param $phone
	 * @param $code
	 * @return bool
	 */
	public function checkVerifyCode($phone, $code){
		$cache = Cache::get(static::CACHE_PREFIX . $phone, '');
		return $code == $cache;
	}
}
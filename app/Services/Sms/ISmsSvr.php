<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017-03-02
 * Time: 15:29
 */

namespace App\Services\Sms;


interface ISmsSvr
{
	/**
	 * 验证码
	 * @param $phone
	 * @return \App\Services\Ali\ResultSet|mixed|\SimpleXMLElement
	 */
	public function verify($phone);

	/**
	 * 通知
	 * @param $phones
	 * @param $data
	 */
	public function notify($phones, $data);

	/**
	 * 发送短信
	 * @param $templateCode
	 * @param array $data
	 * @param array $phones
	 * @return \App\Services\Ali\ResultSet|mixed|\SimpleXMLElement
	 */
	public function send($templateCode, array $data, array $phones);

	/**
	 * 生成验证码
	 * @param int $len
	 * @return string
	 */
	public function verifyCode($len = 6);

	/**
	 * 验证
	 * @param $phone
	 * @param $code
	 * @return bool
	 */
	public function checkVerifyCode($phone, $code);
}
<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017-01-14
 * Time: 16:20
 */

namespace App\Services\DataSync;


abstract class Worker implements IWorker
{

	public function httpGet($url, $data){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		$output = curl_exec($ch);
		curl_close($ch);
		return $output;
	}

	public function httpPost($url, $data, $isLogin, $cookie_jar = null){
		$post_content =  is_array($data) ? json_encode($data) : $data;

		$ch = curl_init($url);
		$this_header = array(
			'Content-Type: application/json',
			'Content-Length: '.strlen($post_content)
		);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this_header);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_content);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		if($isLogin){
			curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_jar);
		}
		else{
			curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_jar);
		}
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);

		$result = curl_exec($ch);
		curl_close($ch);

		return $result;

	}

}
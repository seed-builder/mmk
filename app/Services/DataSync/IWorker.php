<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017-01-14
 * Time: 15:49
 */

namespace App\Services\DataSync;


interface IWorker
{
	/**
	 * 接收数据
	 */
	public function accept($name, $op, array $data);

	/**
	 * 发送数据
	 */
	public function send($name, $op, array $data);

}
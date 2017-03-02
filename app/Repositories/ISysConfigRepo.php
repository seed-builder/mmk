<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017-03-02
 * Time: 10:12
 */
namespace App\Repositories;

interface ISysConfigRepo
{
	/**
	 * app端是否启动了数据隔离
	 * @return bool
	 */
	public function isAppDataIsolate();

	/**
	 * 后端是否启动了数据隔离
	 * @return bool
	 */
	public function isMgtDataIsolate();

	/**
	 * 不受数据隔离限制的员工 id 字符串
	 * @return string
	 */
	public function noDataIsolateEmployees();
}
<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017-01-14
 * Time: 15:36
 */

namespace App\Services\DataSync;

/**
 * 数据同步服务
 * 1.接收数据
 * 2.发送数据
 * Class DataSyncSvr
 * @package App\Services
 */
class DataSyncSvr
{
	/**
	 * 数据过滤器
	 * @var array
	 */
	protected $filters = [];

	/**
	 * 数据处理器集合
	 * @var array
	 */
	protected $workers = ['default' => DbWorker::class];

	/**
	 * 接收数据
	 * @param string $name
	 * @param string $op
	 * @param array $data
	 */
	public function accept($name, $op, array $data){

	}

	/**
	 * 发送数据
	 * @param string $name
	 * @param string $op
	 * @param array $data
	 */
	public function send($name, $op, array $data){

	}

	public function addWorker($name, IWorker $worker){
		if(!array_key_exists($name, $this->workers)){
			$this->workers[$name] = $worker;
		}
	}

	public function addFilter($name, IFilter $filter){
		if(!array_key_exists($name, $this->filters)){
			$this->filters[$name] = $filter;
		}
	}
}
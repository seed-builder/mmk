<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017-01-14
 * Time: 15:36
 */

namespace App\Services\DataSync;

use ReflectionClass;

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
	protected $filters = ['default' => []];

	/**
	 * 数据处理器集合
	 * @var array
	 */
	protected $workers = ['default' => []];

	/**
	 * 接收数据
	 * @param string $name
	 * @param string $op
	 * @param array $data
	 */
	public function accept($name, $op, array $data)
	{
		$filters = $this->getFilters($name);
		$workers = $this->getWorkers($name);
		foreach ($filters as $filter) {
			$filter->beforeAccept($data);
		}
		foreach ($workers as $worker) {
			$worker->accept($name, $op, $data);
		}
		foreach ($filters as $filter) {
			$filter->afterAccept($data);
		}
	}

	/**
	 * 发送数据
	 * @param string $name
	 * @param string $op
	 * @param array $data
	 */
	public function send($name, $op, array $data){
		$filters = $this->getFilters($name);
		$workers = $this->getWorkers($name);
		foreach ($filters as $filter) {
			$filter->beforeSend($data);
		}
		foreach ($workers as $worker) {
			$worker->send($name, $op, $data);
		}
		foreach ($filters as $filter) {
			$filter->afterSend($data);
		}
	}

	public function addWorker($name, $workerClass){
		if(!array_key_exists($name, $this->workers)){
			$this->workers[$name][] = [];
		}
		if(!in_array($workerClass, $this->workers[$name])){
			$this->workers[$name][] = $workerClass;
		}
	}

	public function addFilter($name, $filterClass){
		if(!array_key_exists($name, $this->filters)){
			$this->filters[$name] = [];
		}
		if(!in_array($filterClass, $this->filters[$name])){
			$this->filters[$name][] = $filterClass;
		}
	}

	public function getWorkers($name){
		if(array_key_exists($name, $this->workers)){
			$workers = $this->workers[$name];
		}else{
			$workers = $this->workers['default'];
		}
		$instances = [];
		if(!empty($workers)){
			foreach ($workers as $worker){
				$reflect = new ReflectionClass($worker);
				$instances[] = $reflect->newInstance();
			}
		}
		return $instances;
	}

	public function getFilters($name){
		if(array_key_exists($name, $this->filters)){
			$filters = $this->filters[$name];
		}else{
			$filters = $this->filters['default'];
		}
		$instances = [];
		if(!empty($filters)){
			foreach ($filters as $filter){
				$reflect = new ReflectionClass($filter);
				$instances[] = $reflect->newInstance();
			}
		}
		return $instances;
	}
}
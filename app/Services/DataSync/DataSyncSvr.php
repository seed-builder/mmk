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
	 * @param string $op | 0-add, 1-update , 2-delete
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

	public function registerWorker($workerClass, $group='default'){
		if(!array_key_exists($group, $this->workers)){
			$this->workers[$group][] = [];
		}
		if(!in_array($workerClass, $this->workers[$group])){
			$this->workers[$group][] = $workerClass;
		}
	}

	public function registerFilter($filterClass, $group='default'){
		if(!array_key_exists($group, $this->filters)){
			$this->filters[$group] = [];
		}
		if(!in_array($filterClass, $this->filters[$group])){
			$this->filters[$group][] = $filterClass;
		}
	}

	public function getWorkers($group){
		if(array_key_exists($group, $this->workers)){
			$workers = $this->workers[$group];
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

	public function getFilters($group){
		if(array_key_exists($group, $this->filters)){
			$filters = $this->filters[$group];
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
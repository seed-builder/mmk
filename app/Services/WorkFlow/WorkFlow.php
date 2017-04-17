<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017-04-10
 * Time: 15:59
 */

namespace App\Services\WorkFlow;

use App\Models\Busi\WorkFlow as DBWorkFlow;
/**
 * 工作流定义
 * Class WorkFlow
 * @package App\Services\WorkFlow
 */
class WorkFlow
{
	protected $workflow;

	public function __construct()
	{
	}

	public function init($name){
		$this->workflow = DBWorkFlow::where('name', $name)->first();
	}

	public function __get($name)
	{
		// TODO: Implement __get() method.
		return $this->workflow->{$name} ?: null;
	}
}
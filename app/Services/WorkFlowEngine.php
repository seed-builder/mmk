<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017-02-20
 * Time: 17:15
 */

namespace App\Services;

/**
 * 工作流引擎
 * Class WorkFlowEngine
 * @package App\Services
 */
class WorkFlowEngine
{
	public const Action = ['agree', 'disagree', 'back'];

	/**
	 * 开启工作流实例
	 * @param $workFlow
	 * @param $table
	 * @param $id
	 */
	public function start($workFlow, $table, $id){

	}

	/**
	 * 同意
	 * @param $instance
	 */
	public function agree($instance){

	}

	/**
	 * 不同意
	 * @param $instance
	 */
	public function disagree($instance){

	}

	/**
	 * 驳回
	 */
	public function back($instance){

	}

	/**
	 * 结束工作流
	 * @param $instance
	 */
	public function end($instance){

	}

	/**
	 * 执行动作
	 * @param $workflow
	 * @param $condition
	 */
	public function action($workflow, $condition){

	}

}
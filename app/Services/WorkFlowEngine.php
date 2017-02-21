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
	 * 同意
	 * @param $workflow
	 */
	public function agree($workflow){

	}

	/**
	 * 不同意
	 */
	public function disagree($workflow){

	}

	/**
	 * 驳回
	 */
	public function back($workflow){

	}

	/**
	 * 执行动作
	 * @param $workflow
	 * @param $condition
	 */
	public function action($workflow, $condition){

	}

}
<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017-04-10
 * Time: 16:20
 */

namespace App\Services\WorkFlow;
use App\Models\Busi\WorkFlowTask;

/**
 * 工作流引擎
 * 1.根据工作流定义， 驱动流程流转， 控制实例状态及待办事项
 * Class Engine
 * @package App\Services\WorkFlow
 */
class Engine
{
	protected $instance;
	protected $task;
	/**
	 * The array of booted.
	 *
	 * @var array
	 */
	protected static $booted = false;

	public function __construct()
	{
		$this->instance = new Instance();
		$this->task = new Task();

		$this->bootIfNotBooted();
	}

	public function bootIfNotBooted(){
		if(!static::$booted){
			static::boot();
			static::$booted = true;
		}
	}

	public static function boot(){
		$dispatcher = app('events');
		Instance::setEventDispatcher($dispatcher);
		Task::setEventDispatcher($dispatcher);

		Task::dataReceived(function (Task $task){
			$instance = new Instance();
			$instance->init($task->work_flow_instance_id);
			$instance->saveVariables($task->variables);
		});

		/**
		 * 流程正常流转
		 */
		Task::processed(function (Task $task){
			$nextTasks = $task->getNextTasks();
			if(count($nextTasks) == 1 && $nextTasks[0]->node->type == 'L'){
				$instance = new Instance();
				$instance->init($task->work_flow_instance_id);
				$instance->terminate(1);
				$lastTask = $nextTasks[0];
				$lastTask->update(['status' => 1]);
			}
			//如果当前节点不是会签节点， 其他任务自动完成审核
			if($task->node->type == 'C'){
				WorkFlowTask::where('work_flow_instance_id', $task->work_flow_instance_id)
					->where('node_id', $task->node_id)
					->update(['status' => $task->status]);
			}
		});

		/**
		 * 非正常结束
		 */
		Task::terminated(function (Task $task){
			$instance = new Instance();
			$instance->init($task->work_flow_instance_id);
			$instance->terminate(3);
		});

	}

	/**
	 * 启动新实例
	 * @param $name
	 * @param $sponsor
	 * @param $variables
	 */
	public function startInstance(string $name, Sponsor $sponsor, array $variables){
		$workflow = new WorkFlow();
		$workflow->init($name);
		$this->instance->start($workflow, $sponsor, $variables);
		$this->task->start($this->instance, $variables);
	}

	/**
	 * 同意
	 * @param $taskId
	 * @param $remark
	 * @param array $variables
	 * @return array
	 */
	public function agree($taskId, $remark, $variables=[]){
		$this->task->init($taskId);
		$this->task->forward($variables + ['remark' => $remark]);
		return true;
	}

	/**
	 * 不同意
	 * 非正常结束
	 * @param $taskId
	 * @param $remark
	 * @return bool
	 */
	public function against($taskId, $remark){
		$this->task->init($taskId);
		$this->task->terminate(['remark' => $remark]);
		return true;
	}


}
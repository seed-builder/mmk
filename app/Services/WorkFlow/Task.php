<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017-04-10
 * Time: 16:04
 */

namespace App\Services\WorkFlow;

use App\Models\Busi\WorkFlowLink;
use App\Models\Busi\WorkFlowNode;
use App\Models\Busi\WorkFlowTask;

/**
 * 待办事项
 * Class Task
 * @package App\Services\WorkFlow
 */
class Task
{
	use HasEvents;

	protected $task;
	protected $variables;

	/**
	 * Get the observable event names.
	 *
	 * @return array
	 */
	public function getObservableEvents()
	{
		return [
			'data_received',
			'task_processed',
			'task_terminated'
		];
	}

	public function init($id){
		$this->task = WorkFlowTask::find($id);
	}

	/**
	 * 依据实例开启新的任务
	 * @param Instance $instance
	 * @param $variables
	 */
	public function start(Instance $instance, $variables){
		$workflowId = $instance->getWorkFlowId();
		$node = WorkFlowNode::where('work_flow_id', $workflowId)
			->where('type', 'F')
			->first();
		$this->task = $this->createTask([
			'work_flow_id' => $workflowId,
			'work_flow_instance_id' => $instance->getId(),
			'node_id' => $node->id,
			'approver_id' => $instance->sponsor->id,
			'action' => 'start',
			'remark' => 'start',
			//'status' => 1,
		]);
		//$this->receive($variables);
		$this->process($variables);
	}

	public function receive($variables){
		$this->variables = $variables;
		if(array_key_exists('remark', $variables)){
			$this->task->update(['remark' => $variables['remark']]);
		}
		$this->fireEvent('data_received', false);
	}

	/**
	 * 处理任务（待办事项）
	 * @param $variables
	 * @return array
	 */
	public function process($variables){
		$nextTasks = [];
		DB::beginTransaction();
		try {
			$this->receive($variables);
			//更新当前执行日志状态数据 为已经执行
			$this->task->update(['status' => 1]);
			$nextLinks = $this->findNextLinks($this->task->node_id);
			$nextTasks = $this->createNextTasks($this->task, $nextLinks);
			DB::commit();
			$this->fireEvent('task_processed', false);
		} catch (Exception $e) {
			DB::rollback();
		}
		return $nextTasks;
	}

	/**
	 * 生成下一步的所有审批任务
	 * @param $preTask
	 * @param $links
	 * @return array
	 */
	protected function createNextTasks($preTask, $links){
		$tasks = [];
		if(!empty($links)){
			foreach ($links as $link)
			{
				$arr = $this->createNextTask($preTask, $link);
				$tasks = array_merge($tasks, $arr);
			}
		}
		return $tasks;
	}

	/**
	 * 根据走向生成某个节点的审批任务
	 * @param $preTask
	 * @param $link
	 * @return array
	 */
	protected function createNextTask($preTask, $link){
		//
		$curNode = $link->target_node;
		$tasks = [];
		switch ($curNode->type){
			case 'L':
				//结束节点
				$tasks[] = $this->createTask([
					'work_flow_id' => $preTask->work_flow_id,
					'work_flow_instance_id' => $preTask->work_flow_instance_id,
					'action' => 'end',
					'remark' => 'end',
					'link_id' => $link->id,
					'pre_task_id' => $preTask->id,
					'node_id' => $preTask->node_id,
				]);
				break;
			default:
				//中间审批节点
				$approvers = Approver::getApprovers($curNode->approver_type, new Approver($preTask->approver_id) );
				if (!empty($approvers)) {
					foreach ($approvers as $approver) {
						$tasks[] = $this->createTask([
							'work_flow_id' => $preTask->work_flow_id,
							'work_flow_instance_id' => $preTask->work_flow_instance_id,
							'link_id' => $link->id,
							'pre_task_id' => $preTask->id,
							'node_id' => $preTask->node_id,
							'approver_id' => $approver->id,
						]);
					}
				}
				break;
		}
		return $tasks;
	}

	/**
	 * 生成节点任务
	 * @param $props
	 * @return mixed
	 */
	protected function createTask($props){
		$query = WorkFlowTask::query();
		foreach ($props as $k => $v){
			$query->where($k, $v);
		}
		$task = $query->first();
		if(empty($task)) {
			$task = WorkFlowTask::create($props);
		}else{
			$task->update(['status' => 0]);
		}
		return $task;
	}


	/**
	 * 下一步
	 * @param $variables
	 */
	public function forward($variables){
		$this->process($variables + ['@@approved' => 1]);
	}

	/**
	 * 退回上一步
	 * @param $variables
	 */
	public function back($variables){
		$this->process($variables + ['@@back' => 1]);
	}

	/**
	 * 终止
	 * @param $variables
	 */
	public function terminate($variables){
		$this->receive($variables);
		$this->task->update(['status' => 3]);
		$this->fireEvent('task_terminated', false);
	}

	/**
	 * 查找下一步符合条件的所有走向
	 * @param $curNodeId
	 * @return array
	 */
	protected function findNextLinks($curNodeId){
		$links = WorkFlowLink::where('source_node_id', $curNodeId)->get();
		return $this->chooseLinks($links, $this->variables);
	}

	protected function chooseLinks($links, $variables){
		$rightLinks = [];
		if(!empty($links)) {
			foreach ($links as $link) {
				if (!empty($link->condition)) {
					$condition = strtolower($link->condition);
					foreach ($variables as $key => $val){
						$condition = str_replace($key, '$variables["'.$key.'"]', $condition);
					}
					//
					$condition = str_replace('and', ' && ', $condition);
					$condition = str_replace('or', ' || ', $condition);
					//var_dump($condition);
					$result = eval('return '. $condition . ';');
					//var_dump($result);
					if($result){
						$rightLinks[] = $link;
					}
				} else {
					$rightLinks[] = $link;
					break;
				}
			}
		}
		return $rightLinks;
	}

	public static function dataReceived($callback){
		static::registerEvent('data_received', $callback);
	}

	public static function terminated($callback){
		static::registerEvent('task_terminated', $callback);
	}

	public static function processed($callback){
		static::registerEvent('task_processed', $callback);
	}

	public function getStatus(){
		return $this->task->status;
	}

	public function getForm(){
		return $this->task->node->form ?: null;
	}

	public function getVariables(){
		return $this->variables;
	}

	public function __get($name)
	{
		// TODO: Implement __get() method.
		return $this->task->{$name} ?: null;
	}

}
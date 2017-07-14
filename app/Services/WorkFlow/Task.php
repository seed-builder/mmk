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
use App\Services\LogSvr;
use Illuminate\Support\Facades\DB;

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
	protected $nextTasks;

	/**
	 * Get the observable event names.
	 *
	 * @return array
	 */
	public function getObservableEvents()
	{
		return [
			'task_data_receiving',
			'task_data_received',
			'task_processed',
			'task_terminating',
			'task_terminated',
			'task_suspended',
			'task_resumed',
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
			'approver_id' => $instance->getSponsor()->id,
			'action' => 'start',
			'remark' => 'start',
			//'status' => 1,
		]);
		//$this->receive($variables);
		$this->process($variables);
		//LogSvr::wf()->info('task start .');
	}

	public function receive($variables){
		$this->variables = $variables;
		if ($this->fireEvent('task_data_receiving', true) === false) {
			return false;
		}
		if(array_key_exists('remark', $variables)){
			$this->task->update(['remark' => $variables['remark']]);
		}
		$this->fireEvent('task_data_received', false);
	}

	/**
	 * 处理任务（待办事项）
	 * @param $variables
	 * @return array
	 */
	public function process($variables){
		//$nextTasks = [];
		if($this->task->status == 1 && $this->task->action != 'start')
			return;
		//LogSvr::wf()->info('task process .');
		$this->receive($variables);
		DB::beginTransaction();
		try {
			//更新当前执行日志状态数据 为已经执行
			$this->task->update(['status' => 1]);
			$nextLinks = $this->findNextLinks($this->task->node);
			//LogSvr::wf()->info('task process $nextLinks !' . json_encode($nextLinks));
			$this->nextTasks = $this->createNextTasks($this->task, $nextLinks);
			//LogSvr::wf()->info('task process createNextTasks !' . json_encode($this->nextTasks));
			DB::commit();
		} catch (Exception $e) {
			LogSvr::wf()->info('task process err: ' . $e->getMessage());
			DB::rollback();
		}
		$this->fireEvent('task_processed', false);
		//return $nextTasks;
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
					'node_id' => $curNode->id,
				]);
				break;
			default:
				//LogSvr::wf()->info('task process 中间审批节点: ');
				//中间审批节点
				$approvers = Approver::getApprovers($curNode, new Approver($preTask->approver_id) );
				if ($approvers->count() > 0) {
					//var_dump($approvers);
					//LogSvr::wf()->info('task process 中间审批人: ' . json_encode($approvers));
					foreach ($approvers as $approver) {
						$tasks[] = $this->createTask([
							'work_flow_id' => $preTask->work_flow_id,
							'work_flow_instance_id' => $preTask->work_flow_instance_id,
							'link_id' => $link->id,
							'pre_task_id' => $preTask->id,
							'node_id' => $curNode->id,
							'approver_id' => $approver->id,
						]);
					}
				}else{
					//检查是否有默认缺省处理人
					if(!empty($this->task->workflow->default_task_approver_id)){
						//LogSvr::wf()->info('task process 检查是否有默认缺省处理人: ' );
						$tasks[] = $this->createTask([
							'work_flow_id' => $preTask->work_flow_id,
							'work_flow_instance_id' => $preTask->work_flow_instance_id,
							'link_id' => $link->id,
							'pre_task_id' => $preTask->id,
							'node_id' => $curNode->id,
							'approver_id' => $this->task->workflow->default_task_approver_id
						]);
					} else {
						//LogSvr::wf()->info('task process 挂起: ' );
						$tasks[] = $this->createTask([
							'work_flow_id' => $preTask->work_flow_id,
							'work_flow_instance_id' => $preTask->work_flow_instance_id,
							'link_id' => $link->id,
							'pre_task_id' => $preTask->id,
							'node_id' => $curNode->id,
							'status' => 4 //挂起
						]);
						$this->fireEvent('task_suspended', false);
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
			if($k == 'pre_task_id')
				continue;
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
	 * @return bool
	 */
	public function terminate($variables){
		if ($this->fireEvent('task_terminating', true) === false) {
			return false;
		}
		$this->receive($variables);
		$this->task->update(['status' => 3]);
		$this->fireEvent('task_terminated', false);
		return true;
	}

	public function resume($approverId){
		$this->task->update(['approver_id' => $approverId, 'status' => 0]);
		$this->fireEvent('task_resumed', false);
	}

	/**
	 * 查找下一步符合条件的所有走向
	 * @param $curNode
	 * @return array
	 */
	protected function findNextLinks($curNode){
		$invalid = false;
		$links=[];
		if($curNode->type == 'D'){
			//汇签节点，则需要所有任务都完成再往下走
			$invalid = WorkFlowTask::where('node_id', $curNode->id)
				->where('work_flow_instance_id', $this->task->work_flow_instance_id)
				->where('status', '<>', 1)
				->count();
		}
		if(!$invalid) {
			$links = WorkFlowLink::where('source_node_id', $curNode->id)->get();
		}
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

	public static function dataReceiving($callback){
		static::registerEvent('task_data_receiving', $callback);
	}

	public static function dataReceived($callback){
		static::registerEvent('task_data_received', $callback);
	}

	public static function terminated($callback){
		static::registerEvent('task_terminated', $callback);
	}

	public static function terminating($callback){
		static::registerEvent('task_terminating', $callback);
	}

	public static function processed($callback){
		static::registerEvent('task_processed', $callback);
	}

	public static function suspended($callback){
		static::registerEvent('task_suspended', $callback);
	}

	public static function resumed($callback){
		static::registerEvent('task_resumed', $callback);
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

	public function getCurrentTask(){
		return $this->task;
	}

	public function getNextTasks(){
		return $this->nextTasks;
	}

	public function __get($name)
	{
		// TODO: Implement __get() method.
		return $this->task->{$name} ?: null;
	}

}
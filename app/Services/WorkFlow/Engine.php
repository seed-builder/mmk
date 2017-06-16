<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017-04-10
 * Time: 16:20
 */

namespace App\Services\WorkFlow;
use App\Models\Busi\WorkFlowInstance;
use App\Models\Busi\WorkFlowTask;
use App\Services\WorkFlow\Handlers\ExpDisplayPolicyStoreHandler;
use App\Services\WorkFlow\Handlers\StoreChangeHandler;
use ReflectionClass;

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
	protected static $handlers = [
		'store-change' => StoreChangeHandler::class,
		'exp_display_policy_store' => ExpDisplayPolicyStoreHandler::class
	];

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
			$variables = $task->getVariables();
			//LogSvr::task()->info(json_encode($variables));
			$instance = new Instance();
			$instance->init($task->work_flow_instance_id);
			$instance->saveVariables($variables);
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
			}else{
				foreach ($nextTasks as $ntask){
					$extraType = 'workflow_' . str_replace('-', '_', $ntask->workflow->name);
					Message::send(
						$ntask->approver_id,
						$ntask->workflow->desc,
						$ntask->instance->title,
						$extraType,
						$ntask->id,
						2
						);
				}
			}
			//如果当前节点不是会签节点， 其他任务自动完成审核
			if($task->node->type == 'C'){
				WorkFlowTask::where('work_flow_instance_id', $task->work_flow_instance_id)
					->where('node_id', $task->node_id)
					->update(['status' => $task->status]);
			}
			//发送消息

		});

		/**
		 * pre 检查是否可以执行非正常结束动作
		 */
		Task::terminating(function(Task $task){
			$instance = WorkFlowInstance::find($task->work_flow_instance_id);
			return $instance->status == 0 || $instance->status == 3;
		});

		/**
		 * 非正常结束
		 */
		Task::terminated(function (Task $task){
			$instance = new Instance();
			$instance->init($task->work_flow_instance_id);
			$instance->terminate(3);

			WorkFlowTask::where('work_flow_instance_id', $task->work_flow_instance_id)
				->where('node_id', $task->node_id)
				->update(['status' => $task->status]);

		});

		//挂起
		Task::suspended(function (Task $task){
			$instance = new Instance();
			$instance->init($task->work_flow_instance_id);
			$instance->suspend();
		});

		Task::resumed(function (Task $task){
			$instance = new Instance();
			$instance->init($task->work_flow_instance_id);
			$instance->resume();
		});

		Instance::variablesSaved(function (Instance $instance){
			//LogSvr::engine()->info('variables-saved');
			$wfInstance = $instance->getWorkFlowInstance();
			$handlerName = $wfInstance->workflow->name;
			if(array_key_exists($handlerName, static::$handlers)){
				$handlerClass = static::$handlers[$handlerName];
				$reflect = new ReflectionClass($handlerClass);
				$handler = $reflect->newInstance();
				$handler->variablesSaved( $instance );
			}
//			if($wfInstance->workflow->name == 'store-change') {
//				//保存变量
//				$store_change_list = $wfInstance->variables()->where('name', 'store_change_list')->first();
//				if (!empty($store_change_list)) {
//					//LogSvr::engine()->info('variables-saved, value: ' . $store_change_list->value);
//					$data = json_decode($store_change_list->value, true);
//					unset($data['customer']);
//					unset($data['employee']);
//					unset($data['line']);
//					$storeChange = StoreChange::find($data['id']);
//					$storeChange->fill($data);
//					$storeChange->save();
//				}
//			}
		});

		/**
		 * 实例结束
		 */
		Instance::terminated(function ($instance){
			//LogSvr::engine()->info('Instance terminated');
			$wfInstance = $instance->getWorkFlowInstance();
			$handlerName = $wfInstance->workflow->name;
			if(array_key_exists($handlerName, static::$handlers)){
				$handlerClass = static::$handlers[$handlerName];
				$reflect = new ReflectionClass($handlerClass);
				$handler = $reflect->newInstance();
				$handler->terminated( $instance );
			}

//			if($wfInstance->workflow->name == 'store-change') {
//				if ($wfInstance->status == 1) {
//					//正常审批结束
//					$store_change_list = $wfInstance->variables()->where('name', 'store_change_list')->first();
//					if (!empty($store_change_list)) {
//						$data = json_decode($store_change_list->value, true);
//						$store = Store::find($data['fstore_id']);
//						unset($data['fstore_id']);
//						unset($data['id']);
//						unset($data['remark']);
//						unset($data['type']);
//						unset($data['change_reason']);
//						unset($data['customer']);
//						unset($data['employee']);
//						unset($data['line']);
//						$data['fdocument_status'] = 'C'; //审核状态通过
////						$data['fforbid_status'] = 'A';
//						$store->fill($data);
//						$store->save();
//						//审批通过，则生成拜访日志
//						$calendar = new VisitCalendarService();
//						$calendar->byStore($store);
//						//LogSvr::engine()->info('save store');
//					}
//				}
//			}
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
		$this->task->start($this->instance, []);
	}

	/**
	 * 同意
	 * @param $taskId
	 * @param array $variables
	 * @return array
	 */
	public function agree($taskId, $variables=[]){
		$this->task->init($taskId);
		$this->task->forward($variables);
		return true;
	}

	/**
	 * 不同意
	 * 非正常结束
	 * @param $taskId
	 * @param $variables
	 * @return bool
	 */
	public function against($taskId, $variables){
		$this->task->init($taskId);
		$this->task->terminate($variables);
		return true;
	}

	/**
	 * 撤销
	 * @param $instanceId
	 * @return bool
	 */
	public function dismiss($instanceId){
		$this->instance->init($instanceId);
		return $this->instance->dismiss();
	}

	/**
	 * 保存变量
	 * @param $instanceId
	 * @param array $variables
	 * @return bool
	 */
	public function saveVariables($instanceId, $variables=[]){
		$this->instance->init($instanceId);
		return $this->instance->saveVariables($variables);
	}

	/**
	 * 恢复任务，流程
	 * @param $taskId
	 * @param $userId
	 */
	public function resume($taskId, $userId){
		$this->task->init($taskId);
		$this->task->resume($userId);
	}

	/**
	 * 转移
	 * @param $taskId
	 * @param $userId
	 */
	public function transfer($taskId, $userId){
		$this->task->init($taskId);
		$this->task->getCurrentTask()->update(['approver_id' => $userId]);
	}


}
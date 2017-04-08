<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017-02-20
 * Time: 17:15
 */

namespace App\Services;

use App\Models\Busi\WorkFlow;
use App\Models\Busi\WorkFlowInstance;
use App\Models\Busi\WorkFlowLink;
use App\Models\Busi\WorkFlowLog;
use App\Models\Busi\WorkFlowNode;
use App\Models\Busi\WorkFlowVariable;
use App\Models\User;

/**
 * 工作流引擎
 * Class WorkFlowEngine
 * @package App\Services
 */
class WorkFlowEngine
{
	protected $instanceId;
	protected $instance;
	protected $data;

	public function __construct($instanceId = 0)
	{
		$this->instanceId = $instanceId;
		$this->init();
	}

	protected function init(){
		if($this->instanceId > 0){
			$this->instance = WorkFlowInstance::find($this->instanceId);
			$this->initData();
		}
	}

	protected function initData(){
		$variables = WorkFlowVariable::where('category', 0)->get();
		if(!empty($variables)){
			foreach ($variables as $variable){
				$this->data[$variable->name] = $variable->value;
			}
		}
		if(!empty($this->instance->data)){
			$arr = $this->instance->data->toArray();
			$this->data = array_merge($this->data, $arr);
		}
	}

	/**
	 * 创建工作流实例
	 * @param $sponsorId
	 * @param $wf_name
	 * @param $dataId
	 * @param $dataType
	 * @throws \Exception
	 * @internal param $data
	 * @internal param $name
	 */
	public function createInstance($sponsorId, $wf_name, $dataId, $dataType){
		$wf = WorkFlow::where('name', $wf_name)->first();
		if(empty($wf)){
			throw new \Exception('no work flow ' . $wf_name);
		}
		$user = User::find($sponsorId);

		$billNo = $this->genBillNo($wf->id);
		$this->instance = WorkFlowInstance::create([
			'work_flow_id' => $wf->id,
			'sponsor_id' => $sponsorId,
			'data_type' => $dataType,
			'data_id' => $dataId,
			'sponsor' => empty($user->reference) ? '': $user->reference->fname,
			'bill_no' => $billNo,
			'title' => $wf->name,
 			//'node_id' => $node->id
		]);
		$this->initData();
	}

	/**
	 * 启动实例
	 * 查找开始节点，生成执行日志，并跳转到下一步
	 * @internal param $data
	 */
	public function start(){
		$node = WorkFlowNode::where('work_flow_id', $this->instance->work_flow_id)
			->where('type', 'F')
			->first();
		//var_dump($node->id);
		$log = WorkFlowLog::create([
			'work_flow_id' => $this->instance->work_flow_id,
			'work_flow_instance_id' => $this->instance->id,
			'node_id' => $node->id,
			'approver_id' => $this->instance->sponsor_id,
			'action' => 'start',
			'remark' => 'start',
			'status' => 1,
		]);
		$links = $this->findNextLinks($node->id);
		//var_dump($links);
		$logs = $this->genNodeLogs($log, $links);
		return $logs;
	}

	/**
	 * 正常结束实例
	 */
	public function end(){
		$this->instance->update(['status' => 1]);
	}

	/**
	 * 同意
	 * @param $logId
	 * @param $formData
	 * @internal param $instance
	 * @return array
	 */
	public function agree($logId, $remark, $formData){
		$this->saveData($formData);
		$logs = $this->execApprove($logId, 'agree', $remark, $formData+['@@approved' => 1]);
		return $logs;
	}

	/**
	 * 打回
	 * @param $logId
	 * @param $formData
	 * @internal param $instance
	 */
	public function back($logId, $formData){
		$this->saveData($formData);
		$this->execApprove($logId, ['@@approved' => 0]);
	}

	/**
	 * 不同意
	 * 非正常结束
	 * @param $logId
	 * @param $formData
	 * @internal param $instance
	 */
	public function against($logId){
		DB::beginTransaction();
		try {
			$log = WorkFlowLog::find($logId);
			$log->wf_instance->update(['status' => 3]);
			//更新当前执行日志状态数据 为已经执行
			$log->update(['action' => 'against', 'remark' => 'against', 'status' => 1]);
			DB::commit();
		} catch (Exception $e) {
			DB::rollback();
		}
	}

	/**
	 * 执行审批
	 * @param $logId
	 * @param $action
	 * @param $remark
	 * @param $data
	 * @return array
	 */
	public function execApprove($logId, $action, $remark, $data){
		 $log = WorkFlowLog::find($logId);
		 if(empty($this->instance)){
		 	$this->instanceId = $log->work_flow_instance_id;
		 	$this->init();
		 }
		 //更新当前执行日志状态数据 为已经执行
		 $log->update(['action' => $action, 'remark' => $remark, 'status' => 1]);
		 //生成下一步审批日志
		 $this->data = array_merge($this->data, $data);
		 $links = $this->findNextLinks($log->node_id);
		if(count($links) == 1 && $links[0]->target_node->type == 'L'){
			//正常结束
			WorkFlowLog::where('work_flow_instance_id', $log->work_flow_instance_id)
				->where('node_id', $log->node_id)
				->where('pre_log_id', $log->pre_log_id)
				->update(['status' => 1]);
		}
		 //$this->instance->update(['node_id' => $node->id]);
		 $nextLogs =  $this->genNodeLogs($log, $links);
		 return $nextLogs;
	}

	public function normalEnd($log){

	}

	/**
	 * 查找下一步符合条件的所有走向
	 * @param $curNodeId
	 * @return array
	 */
	public function findNextLinks($curNodeId){
		$links = WorkFlowLink::where('source_node_id', $curNodeId)->get();
		//var_dump($links);
		return $this->chooseLinks($links, $this->data);
	}

	public function chooseLinks($links, $data){
		$rightLinks = [];
		if(!empty($links)) {
			unset($data['data']);
			foreach ($links as $link) {
				if (!empty($link->condition)) {
					$condition = strtolower($link->condition);
					var_dump($condition);
					var_dump($data);
					foreach ($data as $key => $val){
						$condition = str_replace($key, '$data["'.$key.'"]', $condition);
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

	/**
	 * 生成单号
	 * @param $work_flow_id
	 * @return string
	 */
	protected function genBillNo($work_flow_id){
		$count = WorkFlowInstance::where('work_flow_id', $work_flow_id)->count();
		$count ++;
		return 'WF-'. $work_flow_id .'-'. date('Ymd').'-'. sprintf('%05d', $count);
	}

	/**
	 * 根据走向生成某个节点的所有审批日志
	 * @param $preLog
	 * @param $links
	 * @return array
	 * @internal param $curNode
	 * @internal param $nextNode
	 * @internal param $node
	 */
	protected function genNodeLogs($preLog, $links){
		$logs = [];
		if(!empty($links)){
			foreach ($links as $link)
			{
				$logs[] = $this->genNodeLog($preLog, $link);
			}
		}
		return $logs;
	}

	/**
	 * 根据走向生成某个节点的审批日志
	 * @param $preLog
	 * @param $link
	 * @return array
	 * @internal param $curNode
	 * @internal param $nextNode
	 * @internal param $node
	 */
	protected function genNodeLog($preLog, $link){
		//
		$curNode = $link->target_node;

		switch ($curNode->type){
			case 'F':
				//开始节点操作人是自己
				$log = WorkFlowLog::create([
					'work_flow_id' => $this->instance->work_flow_id,
					'work_flow_instance_id' => $this->instance->id,
					'node_id' => $curNode->id,
					'approver_id' => $this->instance->sponsor_id,
					'action' => 'start',
					'remark' => 'start',
					//'status' => 1,
				]);
				break;
			case 'L':
				//结束节点
				$log = WorkFlowLog::create([
					'work_flow_id' => $this->instance->work_flow_id,
					'work_flow_instance_id' => $this->instance->id,
					'node_id' => $curNode->id,
//					'approver_id' => $this->instance->sponsor_id,
					'action' => 'end',
					'remark' => 'end',
					'status' => 1,
					'pre_log_id' => $preLog->id,
					'link_id' => $link->id,
				]);
				$this->end(); //正常结束实例
				break;
			default:
				//中间审批节点
				//审批人类型(0-特定人，1-按职位角色, 2-直接上级)
				switch ($curNode->approver_type) {
					case 0:
						$log = WorkFlowLog::create([
							'work_flow_id' => $this->instance->work_flow_id,
							'work_flow_instance_id' => $this->instance->id,
							'node_id' => $curNode->id,
							'approver_id' => $curNode->approver,
							'pre_log_id' => $preLog->id,
							'link_id' => $link->id,
						]);
						break;
					case 1:

						break;
					case 2:
						$seniorUsers = $preLog->approver->getSeniors();
						if(!empty($seniorUsers)) {
							foreach ($seniorUsers as $seniorUser) {
								$log = WorkFlowLog::create([
									'work_flow_id' => $this->instance->work_flow_id,
									'work_flow_instance_id' => $this->instance->id,
									'node_id' => $curNode->id,
									'approver_id' => $seniorUser->id,
									'pre_log_id' => $preLog->id,
									'link_id' => $link->id,
								]);
							}
						}
						break;
				}
				break;
		}
		return $log;
	}

	protected function saveData($formData){
		if(!empty($formData)) {
			$entity = $this->instance->data;
			$entity->fill($formData);
			$entity->save();
		}
	}
}
<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017-06-13
 * Time: 14:26
 */

namespace App\Services\WorkFlow\Handlers;


use App\Models\Busi\DisplayPolicyStore;
use App\Services\WorkFlow\IEngineHandler;
use App\Services\WorkFlow\Instance;
use App\Services\WorkFlow\Task;

class ExpDisplayPolicyStoreHandler implements IEngineHandler
{
	public function variablesSaved(Instance $instance)
	{
		// TODO: Implement variablesSaved() method.
	}

	public function terminated(Instance $instance)
	{
		$wfInstance = $instance->getWorkFlowInstance();
		if ($wfInstance->status == 1) {
			//正常审批结束
			$data = $wfInstance->variables()->where('name', 'data')->first();
			if (!empty($data)) {
				$obj = json_decode($data->value, true);
				$store = DisplayPolicyStore::find($obj['id']);
				$store->fdocument_status = 'C'; //审核状态通过
				$store->fcheck_amount = $obj->fcheck_amount;
				$store->save();
			}
		}
	}

	public function terminating(Task $task)
	{
		// TODO: Implement terminating() method.
//		$entity = DisplayPolicyStore::find($data['id']);
//		$entity->fdocument_status="C";
//		$entity->fcheck_amount = $data['fcheck_amount'];
//		$entity->fstatus = 1;
//
//		$policy = DisplayPolicy::find($entity->fpolicy_id);
//
//		if($entity->fsign_store_num<=$entity->fsign_store_num){//执行门店总数小于或者等于签约门店总数 ！防止超签
//			return response()->json([
//				'code' => 500,
//				'result' => '政策执行门店总数已达到上限，审核失败！'
//			]);
//		}
//
//		if($data['fcheck_amount']>$entity->fsign_amount){//核定签约金额大于签约金额
//			return response()->json([
//				'code' => 500,
//				'result' => '核定签约金额不能大于签约金额，审核失败！'
//			]);
//		}
//
//		if($policy->fstore_cost_limit<$entity->fcheck_amount){//核定签约金额大于方案费用上限
//			return response()->json([
//				'code' => 500,
//				'result' => '核定签约金额大于方案费用上限，审核失败！'
//			]);
//		}
//
//		if(($policy->famount-$policy->fsign_amount)<$entity->fcheck_amount){//核定签约金额大于所剩余的能签约的金额
//			return response()->json([
//				'code' => 500,
//				'result' => '核定签约高于所剩余金额，审核失败！'
//			]);
//		}
//
		return true;
	}

}
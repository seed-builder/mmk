<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017-06-13
 * Time: 14:26
 */

namespace App\Services\WorkFlow\Handlers;


use App\Models\Busi\DisplayPolicy;
use App\Models\Busi\DisplayPolicyStore;
use App\Services\WorkFlow\IEngineHandler;
use App\Services\WorkFlow\Instance;
use App\Services\WorkFlow\Task;
use App\Services\WorkFlow\WorkFlowException;

class ExpDisplayPolicyStoreHandler implements IEngineHandler
{
	public function variablesSaving(Instance $instance, $variables)
	{
		$data = $variables['data'];
		$suc = true;
		$err = '';
		$entity = DisplayPolicyStore::find($data['id']);
		$policy = DisplayPolicy::find($entity->fpolicy_id);

		if($suc && $policy->fsign_store_num >= $policy->fact_store_num){//执行门店总数小于或者等于签约门店总数 ！防止超签
			$err = '政策执行门店总数已达到上限，审核失败！';
			$suc = false;
		}

		if($suc && $data['fcheck_amount'] > $entity->fsign_amount){//核定签约金额大于签约金额
			$err = '核定签约金额不能大于签约金额，审核失败！';
		}

		if($suc && $policy->fstore_cost_limit < $data['fcheck_amount']){//核定签约金额大于方案费用上限
			$err =  '核定签约金额大于方案费用上限，审核失败！';
		}

		if($suc && (($policy->famount - $policy->fsign_amount) < $data['fcheck_amount'] )){//核定签约金额大于所剩余的能签约的金额
			$err =  '核定签约高于所剩余金额，审核失败！';
		}
		if(!$suc){
			throw new WorkFlowException($err);
		}
	}

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
				$obj = json_decode($data->value);
				$store = DisplayPolicyStore::find($obj->id);
				$store->fdocument_status = 'C'; //审核状态通过
				$store->fcheck_amount = $obj->fcheck_amount;
				$store->fstatus = 1;
				$store->save();

				$policy = DisplayPolicy::find($obj->fpolicy_id);
				$policy->fsign_amount = $policy->fsign_amount + $obj->fcheck_amount;
				$policy->fsign_store_num = $policy->fsign_store_num + 1;
				$policy->save();
			}
		}
	}

	public function terminating(Task $task)
	{
		return true;
	}


}
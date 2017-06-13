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
				$store->save();
			}
		}
	}
}
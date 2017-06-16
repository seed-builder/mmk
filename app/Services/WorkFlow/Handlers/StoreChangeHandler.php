<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017-06-13
 * Time: 14:23
 */

namespace App\Services\WorkFlow\Handlers;


use App\Models\Busi\Store;
use App\Models\Busi\StoreChange;
use App\Services\VisitCalendarService;
use App\Services\WorkFlow\IEngineHandler;
use App\Services\WorkFlow\Instance;
use App\Services\WorkFlow\Task;

class StoreChangeHandler implements IEngineHandler
{

	public function variablesSaved(Instance $instance)
	{
		// TODO: Implement variablesSaved() method.
		$wfInstance = $instance->getWorkFlowInstance();
		//保存变量
		$store_change_list = $wfInstance->variables()->where('name', 'store_change_list')->first();
		if (!empty($store_change_list)) {
			//LogSvr::engine()->info('variables-saved, value: ' . $store_change_list->value);
			$data = json_decode($store_change_list->value, true);
			unset($data['customer']);
			unset($data['employee']);
			unset($data['line']);
			$storeChange = StoreChange::find($data['id']);
			$storeChange->fill($data);
			$storeChange->save();
		}
	}

	public function terminated(Instance $instance)
	{
		$wfInstance = $instance->getWorkFlowInstance();
		if ($wfInstance->status == 1) {
			//正常审批结束
			$store_change_list = $wfInstance->variables()->where('name', 'store_change_list')->first();
			if (!empty($store_change_list)) {
				$data = json_decode($store_change_list->value, true);
				$store = Store::find($data['fstore_id']);
				unset($data['fstore_id']);
				unset($data['id']);
				unset($data['remark']);
				unset($data['type']);
				unset($data['change_reason']);
				unset($data['customer']);
				unset($data['employee']);
				unset($data['line']);
				$data['fdocument_status'] = 'C'; //审核状态通过
//						$data['fforbid_status'] = 'A';
				$store->fill($data);
				$store->save();
				//审批通过，则生成拜访日志
				$calendar = new VisitCalendarService();
				$calendar->byStore($store);
				//LogSvr::engine()->info('save store');
			}
		}

	}

	public function terminating(Task $task)
	{
		// TODO: Implement terminating() method.
		return true;
	}

	public function variablesSaving(Instance $instance, $variables)
	{
		// TODO: Implement variablesSaving() method.
	}
}
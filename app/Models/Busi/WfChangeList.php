<?php

namespace App\Models\Busi;

use App\Services\WorkFlow\Engine;
use App\Services\WorkFlow\Instance;
use App\Services\WorkFlow\Sponsor;
use App\Services\WorkFlowEngine;
use Illuminate\Database\Eloquent\Model;

/**
 * 工作流 变更单
 * Class WfChangeList
 * @package  App\Models
 *
 * @author  xrs
 * @SWG\Model(id="WfChangeList")
 * @SWG\Property(name="data", type="string", description="数据json")
 * @SWG\Property(name="data_id", type="integer", description="数据 id")
 * @SWG\Property(name="data_type", type="string", description="数据类型")
 * @SWG\Property(name="fcreate_date", type="string", description="创建时间")
 * @SWG\Property(name="fcreator_id", type="integer", description="创建人")
 * @SWG\Property(name="fdocument_status", type="string", description="数据状态")
 * @SWG\Property(name="fmodify_date", type="string", description="修改时间")
 * @SWG\Property(name="fmodify_id", type="integer", description="修改人")
 * @SWG\Property(name="id", type="integer", description="")
 * @SWG\Property(name="type", type="string", description="变更类型（0-新增， 1-更新， 2-删除）")
  */
class WfChangeList extends BaseModel
{
	//
	protected $table = 'wf_change_lists';
	protected $guarded = ['id'];

	public function data(){
		return $this->morphTo();
	}

	protected static function boot()
	{
		Engine::boot();

		parent::boot(); // TODO: Change the autogenerated stub
		static::created(function($model){
			if($model->data_type == 'store'){
//				$engine = new WorkFlowEngine();
//				$engine->createInstance($model->fcreator_id,'store-change', $model->id, 'wf_change_list');
//				$engine->start();
				$data = json_decode($model->data, true);
				$sponsor = new Sponsor($model->fcreator_id);
				$engine = new Engine();
				$engine->startInstance('store-change', $sponsor,
					[
						'store_change_list' => $model,
						'creator' => $sponsor->nick_name,
						'action' => $model->type == 0 ? '新增': $model->type == 1 ? '修改':'删除',
						'store_name' => $data['ffullname'],
						'store_address' => $data['faddress'],
						'created' => $model->fcreate_date
					]);
			}
		});

		Instance::variablesSaved(function (Instance $instance){
			if($instance->workflow->name == 'store-change'){
				if(array_key_exists('store_change_list', $instance->variables)){
					$instance->variables['store_change_list']->save();
				}
			}
		});

	}
}
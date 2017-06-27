<?php

namespace App\Models\Busi;

use App\Services\WorkFlow\Engine;
use App\Services\WorkFlow\Instance;
use App\Services\WorkFlow\Sponsor;
use Illuminate\Database\Eloquent\Model;

/**
 * model description
 * Class StoreChange
 * @package  App\Models
 *
 * @author  xrs
 * @SWG\Model(id="StoreChange")
   */
class StoreChange extends BaseModel
{
	//
	protected $table = 'st_store_changes';
	protected $guarded = ['id'];
	protected $with = ['customer', 'employee'];
	//protected $appends = ['customer', 'employee'];

	public function customer()
	{
		return $this->belongsTo(Customer::class, 'fcust_id');
	}

	public function employee(){
		return $this->belongsTo(Employee::class, 'femp_id');
	}

	public function line(){
		return $this->hasOne(VisitLine::class, 'id', 'fline_id');
	}

	/**
	 * 从门店数据新增变更数据
	 * @param array $store
	 * @param int $type | 0-新增，1-修改，2-删除, 3-禁用
	 * @param string $remark
	 * @return
	 */
	public static function addFromStore(array $store, $type = 0, $remark='')
	{
		$props = $store;
		$props['fstore_id'] = $store['id'];
		$props['type'] = $type;
		if(!empty($remark))
			$props['remark'] = $remark;
		unset($props['id']);
		unset($props['customer']);
		return StoreChange::create($props);
	}

	protected static function boot()
	{
		parent::boot(); // TODO: Change the autogenerated stub
		static::created(function (StoreChange $model) {
			$customer = $model->customer;
			$employee = $model->employee;
			$sponsor = new Sponsor($model->type == 0 ? $model->fcreator_id : $model->fmodify_id );
			$engine = new Engine();
			switch($model->type){
				default:
				case 0:
					$action = '新增';
					break;
				case 1:
					$action = '修改';
					break;
				case 2:
					$action = '删除';
					break;
				case 3:
					$action = '禁用';
					break;
			}
			if(empty($model->change_reason)){
				$model->change_reason = $action;
			}

			$engine->startInstance('store-change', $sponsor,
				[
					'store_change_list' => $model,
					'store_id' => $model->fstore_id,
					'creator' => $sponsor->nick_name,
					'action' =>  $action,
					'store_name' => $model->ffullname,
					'store_address' => $model->faddress,
					'created' => date('Y-m-d H:i:s'),
					'reason' => $model->change_reason,
					'lineName' => $model->line->fname
				]);
		});
	}
}

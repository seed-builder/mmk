<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * model description
 * Class Stock
 * @package  App\Models
 *
 * @author  xrs
 * @SWG\Model(id="Stock")
 * @SWG\Property(name="fbase_eqty", type="number", description="库存基本单位数量（瓶）")
 * @SWG\Property(name="fcreate_date", type="string", description="创建时间")
 * @SWG\Property(name="fcreator_id", type="integer", description="创建人")
 * @SWG\Property(name="fdocument_status", type="string", description="审核状态")
 * @SWG\Property(name="feqty", type="number", description="瓶数量")
 * @SWG\Property(name="fhqty", type="number", description="箱数量")
 * @SWG\Property(name="flog_id", type="integer", description="拜访执行明细visit_todo_calendar id")
 * @SWG\Property(name="fmaterial_id", type="integer", description="物料内码id")
 * @SWG\Property(name="fmodify_date", type="string", description="修改时间")
 * @SWG\Property(name="fmodify_id", type="integer", description="修改人")
 * @SWG\Property(name="fold_eqty", type="number", description="上次盘点库存基本单位数量(瓶)")
 * @SWG\Property(name="fsale_hqty", type="number", description="建议销售数量(箱)")
 * @SWG\Property(name="fstore_id", type="integer", description="门店id")
 * @SWG\Property(name="ftime", type="string", description="盘点时间")
 * @SWG\Property(name="id", type="integer", description="")
  */
class Stock extends BaseModel
{
	//
	protected $table = 'st_stocks';
	protected $guarded = ['id'];

	public function store(){
	    return $this->hasOne(Store::class,'id','fstore_id');
    }

    public function material(){
        return $this->hasOne(Material::class,'id','fmaterial_id');
    }

	protected static function boot()
	{
		parent::boot(); // TODO: Change the autogenerated stub
		static::created(function ($model){
			event(new \App\Events\ModelCreatedEvent($model));
		});
		static::deleted(function ($model){
			event(new \App\Events\ModelDeletedEvent($model));
		});
		static::updated(function ($model){
			event(new \App\Events\ModelUpdatedEvent($model));
		});
	}
}

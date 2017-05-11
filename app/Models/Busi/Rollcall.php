<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * 实时点名表
 * Class Rollcall
 * @package  App\Models
 *
 * @author  xrs
 * @SWG\Model(id="Rollcall")
 * @SWG\Property(name="address", type="string", description="地址")
 * @SWG\Property(name="fcreate_date", type="string", description="")
 * @SWG\Property(name="femp_id", type="integer", description="employee id")
 * @SWG\Property(name="flatitude", type="string", description="百度地图纬度")
 * @SWG\Property(name="flongitude", type="string", description="百度地图经度")
 * @SWG\Property(name="fmode", type="string", description="模式")
 * @SWG\Property(name="fmodify_date", type="string", description="")
 * @SWG\Property(name="fphotos", type="string", description="图片id 集合， 逗号隔开")
 * @SWG\Property(name="id", type="integer", description="")
  */
class Rollcall extends BaseModel
{
	//
	protected $table = 'bd_rollcalls';
	protected $guarded = ['id'];

	public static function createOrUpdate($data){
		$entity = static::where('femp_id', $data['femp_id'])->first();
		if(empty($entity)){
			$entity = static::create($data);
		}else{
			$entity->fill($data);
			$entity->save();
		}
	}
}

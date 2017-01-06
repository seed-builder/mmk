<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * Class DisplayPolicyEntry
 * @package App\Models\Busi
 * @author xrs
 * @SWG\Model(id="DisplayPolicyEntry")
 * @SWG\Property(name="fcreate_date", type="string", description="创建时间")
 * @SWG\Property(name="fcreator_id", type="integer", description="创建人")
 * @SWG\Property(name="fdisplay_policy_id", type="integer", description="exp_display_policy id")
 * @SWG\Property(name="fdocument_status", type="string", description="数据状态")
 * @SWG\Property(name="fmaterail_id", type="integer", description="exp_display_policy id")
 * @SWG\Property(name="fmaterail_type", type="integer", description="类型  0 正常产品 1 奖励产品 ")
 * @SWG\Property(name="fmodify_date", type="string", description="修改时间")
 * @SWG\Property(name="fmodify_id", type="integer", description="修改人")
 * @SWG\Property(name="id", type="integer", description="")
 */
class DisplayPolicyEntry extends BaseModel
{
    //
	protected $table = 'exp_display_policy_entry';
	protected $with = ['material'];

	public function material(){
		$this->belongsTo(Material::class, 'fmaterail_id');
	}
}

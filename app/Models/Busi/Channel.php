<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * model description
 * Class Channel
 * @package  App\Models
 *
 * @author  xrs
 * @SWG\Model(id="Channel")
 * @SWG\Property(name="fcreate_date", type="datetime", description="创建时间")
 * @SWG\Property(name="fcreator_id", type="integer", description="创建人")
 * @SWG\Property(name="fdocument_status", type="string", description="数据状态")
 * @SWG\Property(name="fgroup_id", type="integer", description="渠道所属分组id")
 * @SWG\Property(name="fmodify_date", type="datetime", description="修改时间")
 * @SWG\Property(name="fmodify_id", type="integer", description="修改人")
 * @SWG\Property(name="fname", type="string", description="渠道名称")
 * @SWG\Property(name="fnumber", type="string", description="渠道编码")
 * @SWG\Property(name="fremark", type="string", description="渠道定义")
 * @SWG\Property(name="fsort", type="integer", description="排序")
 * @SWG\Property(name="id", type="integer", description="")
  */
class Channel extends Model
{
	//
	protected $table = 'bd_channels';
	protected $guarded = ['id'];
}

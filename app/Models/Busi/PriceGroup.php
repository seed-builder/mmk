<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * 价格组
 * Class PriceGroup
 * @package  App\Models
 *
 * @author  xrs
 * @SWG\Model(id="PriceGroup")
 * @SWG\Property(name="fbegin", type="string", description="起始时间")
 * @SWG\Property(name="fchecker", type="string", description="审核人id")
 * @SWG\Property(name="fcheck_date", type="string", description="审核日期")
 * @SWG\Property(name="fcreate_date", type="string", description="")
 * @SWG\Property(name="fcreator", type="integer", description="")
 * @SWG\Property(name="fdocument_status", type="string", description="审核状态（A-未审核, B-审核中, C-审核通过)")
 * @SWG\Property(name="fend", type="string", description="截止时间")
 * @SWG\Property(name="flevel", type="integer", description="优先级（数字越大优先级越低）")
 * @SWG\Property(name="fmodifier", type="integer", description="")
 * @SWG\Property(name="fmodify_date", type="string", description="")
 * @SWG\Property(name="fname", type="string", description="名称")
 * @SWG\Property(name="fnumber", type="string", description="1")
 * @SWG\Property(name="fsuit_object", type="string", description="适用范围:(all-全部, store-门店, customer-经销商)")
 * @SWG\Property(name="id", type="integer", description="")
  */
class PriceGroup extends BaseModel
{
	//
	protected $table = 'bd_price_groups';
	protected $guarded = ['id'];
}

<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * model description
 * Class CustomerOrder
 * @package  App\Models
 *
 * @author  xrs
 * @SWG\Model(id="CustomerOrder")
 * @SWG\Property(name="fbill_no", type="string", description="订单单号")
 * @SWG\Property(name="fcreate_date", type="string", description="创建时间")
 * @SWG\Property(name="fcreator_id", type="integer", description="创建人")
 * @SWG\Property(name="fcust_id", type="integer", description="经销商ID")
 * @SWG\Property(name="fdate", type="string", description="下单日期")
 * @SWG\Property(name="fdocument_status", type="string", description="审核状态")
 * @SWG\Property(name="femp_id", type="integer", description="业务员id")
 * @SWG\Property(name="fmodify_date", type="string", description="修改时间")
 * @SWG\Property(name="fmodify_id", type="integer", description="修改人")
 * @SWG\Property(name="fsend_status", type="string", description="发货状态(A-未发货，B-发货中，C-已到货)")
 * @SWG\Property(name="id", type="integer", description="")
  */
class CustomerOrder extends BaseModel
{
	//
	protected $table = 'st_cust_orders';
	protected $guarded = ['id'];
}

<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * model description
 * Class ViewSaleOrderItem
 * @package  App\Models
 *
 * @author  xrs
 * @SWG\Model(id="ViewSaleOrderItem")
 * @SWG\Property(name="bottle_qty", type="integer", description="瓶数量")
 * @SWG\Property(name="box_qty", type="integer", description="箱数量")
 * @SWG\Property(name="customer_name", type="string", description="客户名称")
 * @SWG\Property(name="employee_name", type="string", description="")
 * @SWG\Property(name="famount", type="number", description="金额")
 * @SWG\Property(name="fcreate_date", type="string", description="创建时间")
 * @SWG\Property(name="fdate", type="string", description="下单日期")
 * @SWG\Property(name="fsend_date", type="string", description="发货时间")
 * @SWG\Property(name="fsend_status", type="string", description="发货状态（A-未配送,C-已配送）")
 * @SWG\Property(name="material_name", type="string", description="物料名称")
 * @SWG\Property(name="position_name", type="string", description="")
 * @SWG\Property(name="present_bottle_qty", type="integer", description="赠送的瓶数量")
 * @SWG\Property(name="present_box_qty", type="integer", description="赠送的箱数量")
 * @SWG\Property(name="store_channel", type="string", description="")
 * @SWG\Property(name="store_name", type="string", description="全名")
 * @SWG\Property(name="store_number", type="string", description="编号")
  */
class ViewSaleOrderItem extends BaseModel
{
	//
	protected $table = 'view_sale_order_items';
	protected $guarded = ['id'];
}

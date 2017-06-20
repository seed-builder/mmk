<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * model description
 * Class FinStatement
 * @package  App\Models
 *
 * @author  xrs
 * @SWG\Model(id="FinStatement")
 * @SWG\Property(name="abstract", type="string", description="摘要")
 * @SWG\Property(name="bal_amount", type="number", description="余额")
 * @SWG\Property(name="bill_date", type="string", description="业务日期")
 * @SWG\Property(name="bill_no", type="string", description="单据编码")
 * @SWG\Property(name="bill_type", type="string", description="单据类型")
 * @SWG\Property(name="cur_amount", type="number", description="本期发生额")
 * @SWG\Property(name="cust_id", type="integer", description="经销商id")
 * @SWG\Property(name="cust_name", type="string", description="经销商名称")
 * @SWG\Property(name="cust_num", type="string", description="经销商编号")
 * @SWG\Property(name="fcreate_date", type="string", description="")
 * @SWG\Property(name="fmodify_date", type="string", description="")
 * @SWG\Property(name="id", type="integer", description="")
 * @SWG\Property(name="month", type="integer", description="月份")
 * @SWG\Property(name="print_status", type="integer", description="0-未打印，1-已打印 ")
 * @SWG\Property(name="project_no", type="string", description="方案编号 ")
 * @SWG\Property(name="remarks", type="string", description="备注")
 * @SWG\Property(name="seq", type="integer", description="打印排序使用")
 * @SWG\Property(name="srcbill_no", type="string", description="源单编号")
 * @SWG\Property(name="status", type="integer", description="0-未对账，1-已对账 ")
 * @SWG\Property(name="year", type="integer", description="年份")
  */
class FinStatement extends BaseModel
{
	//
	protected $table = 'fin_statements';
	protected $guarded = ['id'];
}

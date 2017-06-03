<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * 经销商库存盘点单 详情
 * Class StockCheckItem
 * @package  App\Models
 *
 * @author  xrs
 * @SWG\Model(id="StockCheckItem")
 * @SWG\Property(name="fcheck_eqty", type="number", description="盘点瓶数量")
 * @SWG\Property(name="fcheck_hqty", type="number", description="盘点箱数量")
 * @SWG\Property(name="fcreate_date", type="string", description="")
 * @SWG\Property(name="fdiff_eqty", type="number", description="盘点差异瓶数量(库存减盘点)")
 * @SWG\Property(name="fdiff_hqty", type="number", description="盘点差异箱数量(库存减盘点)")
 * @SWG\Property(name="finv_eqty", type="number", description="期初库存余额瓶数量（余额表取值）")
 * @SWG\Property(name="finv_hqty", type="number", description="期初库存余额箱数量（余额表取值）")
 * @SWG\Property(name="fmaterial_id", type="integer", description="")
 * @SWG\Property(name="fmodify_date", type="string", description="")
 * @SWG\Property(name="fstock_check_id", type="integer", description="")
 * @SWG\Property(name="id", type="integer", description="")
  */
class StockCheckItem extends BaseModel
{
	//
	protected $table = 'st_stock_check_items';
	protected $guarded = ['id'];
}

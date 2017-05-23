<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * 经销商入库详情
 * Class CustStockInItem
 * @package  App\Models\Busi
 *
 * @author  xrs
 * @SWG\Model(id="CustStockInItem")
 * @SWG\Property(name="fbase_qty", type="number", description="销售基本单位数量（瓶）(订单数量*商品表FRotio)")
 * @SWG\Property(name="fbase_unit", type="string", description="基本单位")
 * @SWG\Property(name="fcreate_date", type="string", description="创建时间")
 * @SWG\Property(name="fcreator_id", type="integer", description="创建人")
 * @SWG\Property(name="fdocument_status", type="string", description="审核状态")
 * @SWG\Property(name="fmaterial_id", type="integer", description="物料内码id")
 * @SWG\Property(name="fmodify_date", type="string", description="修改时间")
 * @SWG\Property(name="fmodify_id", type="integer", description="修改人")
 * @SWG\Property(name="fqty", type="number", description="订单数量")
 * @SWG\Property(name="fsale_unit", type="string", description="销售单位")
 * @SWG\Property(name="fstock_in_id", type="integer", description="入库ID")
 * @SWG\Property(name="id", type="integer", description="")
 */
class CustStockInItem extends BaseModel
{
    //
    protected $table = 'cust_stock_in_items';
    protected $guarded = ['id'];


    public function stockin()
    {
        return $this->hasOne(CustStockIn::class, 'id', 'fstock_in_id');
    }

    public function material()
    {
        return $this->hasOne(Material::class, 'id', 'fmaterial_id');
    }
}

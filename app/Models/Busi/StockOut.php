<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * model description
 * Class StockOut
 * @package  App\Models
 *
 * @author  xrs
 * @SWG\Model(id="StockOut")
 * @SWG\Property(name="fbill_no", type="string", description="出库单号(门店编码+日期)")
 * @SWG\Property(name="fcreate_date", type="string", description="创建时间")
 * @SWG\Property(name="fcreator_id", type="integer", description="创建人")
 * @SWG\Property(name="fcust_id", type="integer", description="经销商ID")
 * @SWG\Property(name="fdate", type="string", description="出库日期")
 * @SWG\Property(name="fdocument_status", type="string", description="审核状态")
 * @SWG\Property(name="fmodify_date", type="string", description="修改时间")
 * @SWG\Property(name="fmodify_id", type="integer", description="修改人")
 * @SWG\Property(name="fneed_rec_date", type="string", description="预计到货日期")
 * @SWG\Property(name="frec_date", type="string", description="到货确认日期")
 * @SWG\Property(name="frec_status", type="integer", description="到货状态(0未到货 1已到货)")
 * @SWG\Property(name="fsbill_no", type="string", description="来源单号")
 * @SWG\Property(name="fstore_id", type="integer", description="门店id")
 * @SWG\Property(name="fuser_id", type="integer", description="到货确认人id")
 * @SWG\Property(name="id", type="integer", description="")
  */
class StockOut extends BaseModel
{
	//
	protected $table = 'st_stock_outs';
	protected $guarded = ['id'];

    public function store(){
        return $this->hasOne(Store::class,'id','fstore_id');
    }

    public function customer(){
        return $this->hasOne(Customer::class,'id','fcust_id');
    }
}

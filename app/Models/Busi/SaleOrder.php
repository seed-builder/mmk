<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;
use DB;

/**
 * model description
 * Class SaleOrder
 * @package  App\Models
 *
 * @author  xrs
 * @SWG\Model(id="SaleOrder")
 * @SWG\Property(name="fstore_id", type="integer", description="门店id")
 * @SWG\Property(name="fbill_no", type="string", description="订单单号(门店编码+日期)")
 * @SWG\Property(name="fcust_id", type="integer", description="经销商ID")
 * @SWG\Property(name="fdate", type="string", description="下单日期")
 * @SWG\Property(name="femp_id", type="integer", description="业务员id")
 * @SWG\Property(name="fmodify_date", type="string", description="修改时间")
 * @SWG\Property(name="fmodify_id", type="integer", description="修改人")
 * @SWG\Property(name="fcreate_date", type="string", description="创建时间")
 * @SWG\Property(name="fcreator_id", type="integer", description="创建人")
 * @SWG\Property(name="fdocument_status", type="string", description="审核状态")
 * @SWG\Property(name="fsend_status", type="string", description="发货状态(A-未发货，B-发货中，C-已到货)")
 * @SWG\Property(name="id", type="integer", description="")
  */
class SaleOrder extends BaseModel
{
	//
	protected $table = 'st_sale_orders';
	protected $guarded = ['id'];
	protected $appends = ['total_qty'];

    public function store(){
        return $this->hasOne(Store::class,'id','fstore_id');
    }

	public function employee(){
        return $this->hasOne(Employee::class,'id','femp_id');
    }

    public function customer(){
        return $this->hasOne(Customer::class,'id','fcust_id');
    }

    public function items(){
    	return $this->hasMany(SaleOrderItem::class, 'fsale_order_id');
    }

	/**
	 * 总的订单数量(箱)
	 */
    public function getTotalQtyAttribute(){
		$total = DB::table('st_sale_order_items')->where('fsale_order_id', $this->id)->sum('fqty');
		return $total;
    }

	/**
	 *
	 */
	protected static function boot()
	{
		parent::boot(); // TODO: Change the autogenerated stub
		static::creating(function ($model){
			//event(new \App\Events\ModelCreatedEvent($model));
			if(empty($model->fbill_no)){
				$store = Store::find($model->fstore_id);
				$model->fbill_no = $store->fnumber . date('Ymd');
				$model->fcust_id = $store->fcust_id;
			}
		});

	}

}

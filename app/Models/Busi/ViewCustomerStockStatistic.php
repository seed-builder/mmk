<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * model description
 * Class ViewCustomerStockStatistic
 * @package  App\Models
 *
 * @author  xrs
 * @SWG\Model(id="ViewCustomerStockStatistic")
 * @SWG\Property(name="cust_id", type="integer", description="")
 * @SWG\Property(name="cust_name", type="string", description="")
 * @SWG\Property(name="fbase_qty", type="number", description="")
 * @SWG\Property(name="fbase_unit", type="string", description="")
 * @SWG\Property(name="fqty", type="number", description="")
 * @SWG\Property(name="fsale_unit", type="string", description="")
 * @SWG\Property(name="material_id", type="integer", description="")
 * @SWG\Property(name="material_name", type="string", description="")
 * @SWG\Property(name="material_specification", type="string", description="")
  */
class ViewCustomerStockStatistic extends BaseModel
{
	//
	protected $table = 'view_customer_stock_statistic';
	protected $guarded = ['id'];

    public function adminFilter($queryBuilder, $request)
    {
        $data = $request->all();
        if (!empty($data['filter'])){
            foreach ($data['filter'] as $f){
                $filter_name = $f['name'];
                if ($filter_name=="material_fnumber"&&!empty($f['value'])){
                    $ids = Store::query()->where('fnumber','like','%'.$f['value'].'%')->pluck('id');
                    $queryBuilder->whereIn('fmaterial_id', $ids);
                }elseif ($filter_name=="material_fname"&&!empty($f['value'])){
                    $ids = Store::query()->where('fname','like','%'.$f['value'].'%')->pluck('id');
                    $queryBuilder->whereIn('fmaterial_id', $ids);
                }else{
                    $queryBuilder=$this->adminFilterQuery($queryBuilder,$f);
                }
            }
        }

        return $queryBuilder;
    }
}

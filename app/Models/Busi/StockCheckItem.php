<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * 经销商库存盘点单 详情
 * Class StockCheckItem
 * @package  App\Models\Busi
 *
 * @author  xrs
 * @SWG\Model(id="StockCheckItem")
 * @SWG\Property(name="fcheck_eqty", type="number", description="（合计）盘点瓶数量")
 * @SWG\Property(name="fcheck_hqty", type="number", description="（合计）盘点箱数量")
 * @SWG\Property(name="fdiff_eqty", type="number", description="（合计）盘点差异瓶数量(库存减盘点)")
 * @SWG\Property(name="fdiff_hqty", type="number", description="（合计）盘点差异箱数量(库存减盘点)")
 * @SWG\Property(name="finv_eqty", type="number", description="（合计）期初库存余额瓶数量（余额表取值）")
 * @SWG\Property(name="finv_hqty", type="number", description="（合计）期初库存余额箱数量（余额表取值）")
 * @SWG\Property(name="box_qty", type="number", description="（拆分）盘点箱数量")
 * @SWG\Property(name="bottle_qty", type="number", description="（拆分）盘点瓶数量")
 * @SWG\Property(name="fmaterial_id", type="integer", description="")
 * @SWG\Property(name="fcreate_date", type="string", description="")
 * @SWG\Property(name="fmodify_date", type="string", description="")
 * @SWG\Property(name="fstock_check_id", type="integer", description="")
 * @SWG\Property(name="id", type="integer", description="")
  */
class StockCheckItem extends BaseModel
{
	//
	protected $table = 'st_stock_check_items';
	protected $guarded = ['id'];
	protected $appends = ['inv_box_qty', 'inv_bottle_qty','diff_box_qty', 'diff_bottle_qty'];

	public function __construct(array $attributes = [])
	{
		//$attributes = $this->calculate($attributes);
		parent::__construct($attributes);
	}

	public function calculate($attributes){
		if(empty($attributes))
			return $attributes;
//		var_dump($attributes);
		if($this->id > 0){
			$material = $this->material;
		}else if(!empty($attributes['fmaterial_id'])){
			$material = Material::find($attributes['fmaterial_id']);
		}
		if(!empty($material)) {
			$attributes['fcheck_hqty'] = $attributes['box_qty'] + round($attributes['bottle_qty'] / $material->fratio, 2);
			$attributes['fcheck_eqty'] = $attributes['box_qty'] * $material->fratio + $attributes['bottle_qty'];
			//差值
			$attributes['fdiff_hqty'] = $attributes['fcheck_hqty'] - ($this->finv_hqty ?: 0);
			$attributes['fdiff_eqty'] = $attributes['fcheck_eqty'] - ($this->finv_eqty ?: 0);
		}
		return $attributes;
	}

	public function fill(array $attributes)
	{
//		var_dump($attributes);
		$attributes = $this->calculate($attributes);
		return parent::fill($attributes); // TODO: Change the autogenerated stub
	}


	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function material(){
		return $this->belongsTo(Material::class, 'fmaterial_id');
	}

	public function getInvBoxQtyAttribute(){
		return intval(floor($this->finv_hqty));
	}

	public function getInvBottleQtyAttribute(){
		if($this->material){
			$val = $this->finv_eqty - floor($this->finv_hqty) * $this->material->fratio;
		}else {
			$val = $this->finv_eqty;
		}
		return intval($val);
	}

	public function getDiffBoxQtyAttribute(){
		return intval(floor($this->fdiff_hqty));
	}

	public function getDiffBottleQtyAttribute(){
		if($this->material){
			$val = $this->fdiff_eqty - floor($this->fdiff_hqty) * $this->material->fratio;
		}else {
			$val = $this->fdiff_eqty;
		}
		return intval($val);
	}

}

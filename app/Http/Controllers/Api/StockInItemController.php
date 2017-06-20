<?php

namespace App\Http\Controllers\Api;

use App\Models\Busi\Material;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Models\Busi\StockInItem;

class StockInItemController extends ApiController
{
	//
	public function newEntity(array $attributes = [])
	{
		// TODO: Implement newEntity() method.
		return new StockInItem($attributes);
	}

	public function store(Request $request)
	{
		//return parent::store($request); // TODO: Change the autogenerated stub
		$data = $request->all();
		unset($data['_sign']);
		$entity = $this->newEntity($data);
		$fieldErrors = $this->validateFields($data);
		if (!empty($fieldErrors)) {
			$msg = $this->formatFieldErrors($fieldErrors, $entity->fieldNames);
			return $this->fail($msg);
		}
		$exists = StockInItem::where('fstock_check_id', $data['fstock_check_id'])
			->where('fmaterial_id', $data['fmaterial_id'])
			->count();
		if($exists > 0){
			return $this->fail('该物料已经存在不能新增');
		}
		$material = Material::find($data['fmaterial_id']);
		$entity->finv_hqty = 0;
		$entity->finv_eqty = 0;
		$entity->fcheck_hqty = $data['box_qty'] + round($data['bottle_qty'] / $material->fratio, 2);
		$entity->fcheck_eqty = $data['box_qty'] * $material->fratio + $data['bottle_qty'];
		$entity->fdiff_hqty = $entity->finv_hqty - $entity->fcheck_hqty ;
		$entity->fdiff_eqty = $entity->finv_eqty - $entity->fcheck_eqty ;
		//$entity = Entity::create($data);
		$re = $entity->save();
		return $this->success($re);
	}

	public function update(Request $request, $id)
	{
		//return parent::update($request, $id); // TODO: Change the autogenerated stub
		//
		$entity = $this->newEntity()->newQuery()->find($id);
		//$entity = Entity::find($id);
		//var_dump($entity);

		$data = $request->all();
		//var_dump($data);
		unset($data['_sign']);
		$entity->fill($data);
		$material = $entity->material;
		$entity->fcheck_hqty = $data['box_qty'] + round($data['bottle_qty'] / $material->fratio, 2);
		$entity->fcheck_eqty = $data['box_qty'] * $material->fratio + $data['bottle_qty'];
		$entity->fdiff_hqty = $entity->finv_hqty - $entity->fcheck_hqty ;
		$entity->fdiff_eqty = $entity->finv_eqty - $entity->fcheck_eqty ;
		$re = $entity->save();
		//LogSvr::update()->info(json_encode($re));
		return  $this->success($re);
	}

	public function destroy($id)
	{
		//return parent::destroy($id); // TODO: Change the autogenerated stub
		$entity = $this->newEntity()->newQuery()->find($id);
		if($entity->fcheck_hqty > 0 || $entity->fcheck_eqty > 0){
			return $this->fail('存在库存, 不能删除!');
		}
		$re = $entity->delete();
		return $this->success($re, '删除成功!');
	}
}
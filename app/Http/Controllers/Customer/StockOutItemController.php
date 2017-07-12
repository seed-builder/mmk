<?php
namespace App\Http\Controllers\Customer;

use App\Models\Busi\Material;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Busi\StockOutItem;

class StockOutItemController extends BaseController
{
	public function newEntity(array $attributes = [])
	{
		// TODO: Implement newEntity() method.
		return new StockOutItem($attributes);
	}

	/**
	* Display a listing of the resource.
	*
	* @return  \Illuminate\Http\Response
	*/
	public function index()
	{
		//
		return view('customer.stock-out-item.index');
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return  \Illuminate\Http\Response
	*/
	public function create()
	{
		return view('customer.stock-out-item.create');
	}

	/**
	* Display the specified resource.
	*
	* @param    int  $id
	* @return  \Illuminate\Http\Response
	*/
	public function edit($id)
	{
		$entity = StockOutItem::find($id);
		return view('customer.stock-out-item.edit', ['entity' => $entity]);
	}

	/**
	* Display the specified resource.
	*
	* @param    int  $id
	* @return  \Illuminate\Http\Response
	*/
	public function show($id)
	{
		//
	}

	public function store(Request $request, $extraFields = [])
    {
	    $data = $request->input('data', []);
	    $props = current($data);
	    $material = Material::find($props['fmaterial_id']);
	    $extraFields = [
		    'fsale_unit' => $material->fsale_unit,
		    'fbase_unit' => $material->fbase_unit,
		    'fqty' => $props['box_qty'] + $props['present_box_qty'],
		    'fbase_qty' => $props['bottle_qty'] + $props['present_bottle_qty'],
		    'famount' => $props['box_qty']* $props['fprice_box'] + $props['bottle_qty']* $props['fprice_bottle'],
	    ];
	    return parent::store($request, $extraFields);

//		$id = $request->input('id', 0);
//		if($id > 0){
//			$entity = StockOutItem::find($id);
//		}else {
//			$entity = $this->newEntity();
//		}
//		$entity->fmaterial_id = $request->input('fmaterial_id');
//		$entity->fstock_out_id = $request->input('fstock_out_id');
//		$material = Material::find($entity->fmaterial_id);
//		$entity->fsale_unit = $material->fsale_unit;
//		$entity->fbase_unit = $material->fbase_unit;
//
//		$unit = $request->input('unit');
//		$qty = $request->input('qty');
//		if($unit == 'sale_unit'){
//			$entity->fqty = $qty;
//			$entity->fbase_qty = $qty * $material->fratio;
//		}else{
//			$entity->fbase_qty = $qty;
//			$entity->fqty =  round($qty / $material->fratio, 2);
//		}
//		$entity->save();
//		return $this->success($entity);
    }

    public function update(Request $request, $id, $extraFields=[])
    {
        $data = $request->input('data', []);
        $props = current($data);
        $extraFields = [
	        'fqty' => $props['box_qty'] + $props['present_box_qty'],
	        'fbase_qty' => $props['bottle_qty'] + $props['present_bottle_qty'],
        ];
        return parent::update($request, $id,$extraFields); // TODO: Change the autogenerated stub
    }

	/**
	 * @param  Request $request
	 * @param  array $searchCols
	 * @param  array $with
	 * @param  null $conditionCall
	 * @param bool $all_columns
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function pagination(Request $request, $searchCols = [], $with=[], $conditionCall = null, $all_columns = false){
		$searchCols = ["fbase_unit","fdocument_status","fsale_unit"];
        $with=['stockout','material'];
		return parent::pagination($request, $searchCols, $with);
	}

}

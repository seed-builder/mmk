<?php
namespace App\Http\Controllers\Admin;

use App\Models\Busi\Channel;
use App\Models\Busi\Customer;
use App\Models\Busi\Employee;
use App\Models\Busi\Material;
use App\Models\Busi\VisitLine;
use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Busi\PriceGroup;
use Illuminate\Support\Facades\Auth;

class PriceGroupController extends AdminController
{
	public function newEntity(array $attributes = [])
	{
		// TODO: Implement newEntity() method.
		return new PriceGroup($attributes);
	}

	/**
	* Display a listing of the resource.
	*
	* @return  \Illuminate\Http\Response
	*/
	public function index()
	{
		//
		$materials = Material::all();
		$options = $materials->map(function($material){
			return ['label' => $material->fname, 'value' => $material->id ];
		});
		return view('admin.price-group.index', ['materials' => $options]);
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return  \Illuminate\Http\Response
	*/
	public function create()
	{
		return view('admin.price-group.create', ['entity' => new PriceGroup(['id' => 0])]);
	}

	/**
	* Display the specified resource.
	*
	* @param    int  $id
	* @return  \Illuminate\Http\Response
	*/
	public function edit($id)
	{
		$entity = PriceGroup::find($id);
		$materials = Material::all();
		$options = $materials->map(function($material){
			return ['label' => $material->fname, 'value' => $material->id ];
		});

		return view('admin.price-group.edit', ['entity' => $entity, 'materials' => $options]);
	}

	public function store(Request $request, $extraFields = [])
	{
		$data = $request->except('_token');
		if (empty($data))
			return $this->fail('data is empty');
		//$props = current($data);
		$props = $this->beforeSave($data);
		$fieldErrors = $this->validateFields($props);
		if (!empty($fieldErrors)) {
			return $this->fail('validate error', $fieldErrors);
		} else {
			if (!empty($extraFields)) {
				$props += $extraFields;
			}
			$entity = $this->newEntity($props);
			$entity->save();
			return $this->success($entity);
		}
	}

	public function update(Request $request, $id, $extraFields = [])
	{
		//$data = $request->input('data', []);
		$data = $request->except('_token');
		if (empty($data))
			return $this->fail('data is empty');

		//$props = current($data);
		$props = $this->beforeSave($data);
		$fieldErrors = $this->validateFields($props);
		if (!empty($fieldErrors)) {
			return $this->fail('validate error', $fieldErrors);
		} else {
			if (!empty($extraFields)) {
				$props += $extraFields;
			}
			$entity = $this->newEntity()->newQuery()->find($id);
			$entity->fill($props);
			$entity->save();
			$this->afterSave($entity);
			return $this->success($entity);
		}
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
		$entity = PriceGroup::find($id);
		return view('admin.price-group.detail', ['entity' => $entity]);
	}

	/**
	* @param  Request $request
	* @param  array $searchCols
	* @param  array $with
	* @param  null $conditionCall
	* @param  bool $all_columns
	* @return  \Illuminate\Http\JsonResponse
	*/
	public function pagination(Request $request, $searchCols = [], $with=[], $conditionCall = null, $all_columns = false){
		$searchCols = ["fname","fnumber"];
		return parent::pagination($request, $searchCols);
	}

	public function storePagination(Request $request, $id){
		$searchCols = ["ffullname"];
		$pg = PriceGroup::find($id);
		return parent::pagination($request, $searchCols, [], function (&$query) use($pg) {
			$query = $pg->stores()->getQuery();
		});
	}

	public function customerPagination(Request $request, $id){
		$searchCols = ["fname"];
		$pg = PriceGroup::find($id);
		return parent::pagination($request, $searchCols, [], function (&$query) use($pg) {
			$query = $pg->customers()->getQuery();
		});
	}

	/*
     * 审核
     */
	public function check(Request $request)
	{
		$data = $request->all();
		$ids = explode(",", $data['ids']);
		$entitys = $this->newEntity()->newQuery()->whereIn('id', $ids)->get();

		foreach ($entitys as $entity) {
			$entity->fdocument_status = "C";
			$entity->fcheck_date = date('Y-m-d H:i:s');
			$entity->fchecker = Auth::user()->id;
			$entity->save();
		}

		return response()->json([
			'code' => 200,
			'result' => '审核成功！',
			'data' => $entitys
		]);
	}

	public function chooseStore(Request $request, $id){
		$citys = City::query()->where('LevelType', 1)->get();
		$channels = Channel::all();
		$cus = Customer::all();
		$lines = VisitLine::all();
		//$employees = Employee::query()->whereIn('id',$this->getCurUsersEmployeeIds())->get();
		$entity = PriceGroup::find($id);

		return  view('admin.price-group.store',  compact('citys', 'channels', 'cus','lines', 'entity'));
	}

	public function chooseCustomer(Request $request, $id){
		$entity = PriceGroup::find($id);
		return  view('admin.price-group.customer', ['entity' => $entity]);
	}

	public function attachStore(Request $request, $id){
		$ids = $request->input('ids',[]);
		$entity = PriceGroup::find($id);
		$entity->stores()->detach($ids);
		$entity->stores()->attach($ids);
		return $this->success(1);
	}

	public function detachStore(Request $request, $id){
		$ids = $request->input('ids',[]);
		$entity = PriceGroup::find($id);
		$entity->stores()->detach($ids);
		return $this->success(1);
	}

	public function attachCustomer(Request $request, $id){
		$ids = $request->input('ids',[]);
		$entity = PriceGroup::find($id);
		$entity->customers()->detach($ids);
		$entity->customers()->attach($ids);
		return $this->success(1);
	}

	public function detachCustomer(Request $request, $id){
		$ids = $request->input('ids',[]);
		$entity = PriceGroup::find($id);
		$entity->customers()->detach($ids);
		return $this->success(1);
	}
}

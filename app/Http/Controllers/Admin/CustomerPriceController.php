<?php
namespace App\Http\Controllers\Admin;

use App\Models\Busi\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Busi\CustomerPrice;

class CustomerPriceController extends AdminController
{
	public function newEntity(array $attributes = [])
	{

		return new CustomerPrice($attributes);
	}

	/**
	* Display a listing of the resource.
	*
	* @return  \Illuminate\Http\Response
	*/
	public function index()
	{
		// TODO: Implement newEntity() method.
		$customers = Customer::where('fdocument_status','A')->where('fforbid_status', 'A')->get();
		$options = $customers->map(function ($item){
			return ['label' => $item->fname, 'value' => $item->id];
		});
		$options->push(['label'=> '--请选择--', 'value' => '']);
		return view('admin.customer-price.index', ['customers' => $options->reverse()]);
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return  \Illuminate\Http\Response
	*/
	public function create()
	{
		return view('admin.customer-price.create');
	}

	/**
	* Display the specified resource.
	*
	* @param    int  $id
	* @return  \Illuminate\Http\Response
	*/
	public function edit($id)
	{
		$entity = CustomerPrice::find($id);
		return view('admin.customer-price.edit', ['entity' => $entity]);
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

	/**
	* @param  Request $request
	* @param  array $searchCols
	* @param  array $with
	* @param  null $conditionCall
	* @param  bool $all_columns
	* @return  \Illuminate\Http\JsonResponse
	*/
	public function pagination(Request $request, $searchCols = [], $with=[], $conditionCall = null, $all_columns = false){
		$searchCols = ["fspecification"];
		return parent::pagination($request, $searchCols);
	}

}

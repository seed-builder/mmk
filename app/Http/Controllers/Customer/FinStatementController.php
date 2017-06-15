<?php
namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Customer\BaseController;
use App\Models\Busi\FinStatement;

class FinStatementController extends BaseController
{
	public function newEntity(array $attributes = [])
	{
		// TODO: Implement newEntity() method.
		return new FinStatement($attributes);
	}

	/**
	* Display a listing of the resource.
	*
	* @return  \Illuminate\Http\Response
	*/
	public function index()
	{
		//
		return view('customer.fin-statement.index');
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return  \Illuminate\Http\Response
	*/
	public function create()
	{
		return view('customer.fin-statement.create');
	}

	/**
	* Display the specified resource.
	*
	* @param    int  $id
	* @return  \Illuminate\Http\Response
	*/
	public function edit($id)
	{
		$entity = FinStatement::find($id);
		return view('customer.fin-statement.edit', ['entity' => $entity]);
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
		$searchCols = ["bill_type","project_no"];
		return parent::pagination($request, $searchCols, $with, function ($queryBuilder){
			$queryBuilder->where('cust_id', Auth::user()->reference_id);
		});
	}

}

<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Busi\Price;
use Illuminate\Support\Facades\Auth;

class PriceController extends AdminController
{
	public function newEntity(array $attributes = [])
	{
		// TODO: Implement newEntity() method.
		return new Price($attributes);
	}

	/**
	* Display a listing of the resource.
	*
	* @return  \Illuminate\Http\Response
	*/
	public function index()
	{
		//
		return view('admin.price.index');
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return  \Illuminate\Http\Response
	*/
	public function create()
	{
		return view('admin.price.create');
	}

	/**
	* Display the specified resource.
	*
	* @param    int  $id
	* @return  \Illuminate\Http\Response
	*/
	public function edit($id)
	{
		$entity = Price::find($id);
		return view('admin.price.edit', ['entity' => $entity]);
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
		return parent::pagination($request, $searchCols, ['material']);
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
}

<?php
namespace App\Http\Controllers\Admin;

use App\Models\Busi\Material;
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
		$materials = Material::all();
		$options = $materials->map(function($material){
			return ['label' => $material->fname, 'value' => $material->id ];
		});

		return view('admin.price-group.detail', ['entity' => new PriceGroup(), 'materials' => $options]);
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

		return view('admin.price-group.detail', ['entity' => $entity, 'materials' => $options]);
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

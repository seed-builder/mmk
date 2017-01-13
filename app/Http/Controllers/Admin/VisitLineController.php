<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Busi\VisitLine;
use App\Models\Busi\Organization;
use Swagger\Annotations\Items;

class VisitLineController extends AdminController
{

    //
	public function newEntity(array $attributes = [])
	{
		// TODO: Implement newEntity() method.
		return new VisitLine($attributes);
	}

	public function index()
	{
		$all = Organization::all();
		$orgs = $all->map(function ($item){
			return ['label' => $item->fname, 'value' => $item->id];
		});
		
		return view('admin.visit_line.index',compact('orgs'));
	}

	/**
	 * @param Request $request
	 * @param array $searchCols
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function pagination(Request $request, $searchCols = []){
		$searchCols = ['fname', 'fnumber'];
		return parent::pagination($request, $searchCols);
	}

}

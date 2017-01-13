<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Busi\Employee;
use App\Models\Busi\Organization;
use Swagger\Annotations\Items;

class EmployeeController extends AdminController
{

    //
	public function newEntity(array $attributes = [])
	{
		// TODO: Implement newEntity() method.
		return new Employee($attributes);
	}

	public function index()
	{
		$all = Organization::all();
		$orgs = $all->map(function ($item){
			return ['label' => $item->fname, 'value' => $item->id];
		});
		return view('admin.employee.index',compact('orgs'));
	}

	/**
	 * @param Request $request
	 * @param array $searchCols
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function pagination(Request $request, $searchCols = []){
		$searchCols = ['fname', 'fnumber', 'fphone'];
		return parent::pagination($request, $searchCols);
	}

}

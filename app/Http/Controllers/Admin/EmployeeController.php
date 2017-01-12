<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Busi\Employee;
use App\Models\Busi\Organization;

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
		$orgs = Organization::all();
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

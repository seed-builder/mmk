<?php
namespace App\Http\Controllers\Admin;

use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Role;

class RoleController extends AdminController
{
	public function newEntity(array $attributes = [])
	{
		// TODO: Implement newEntity() method.
		return new Role($attributes);
	}

	/**
	* Display a listing of the resource.
	*
	* @return  \Illuminate\Http\Response
	*/
	public function index()
	{
		//
		return view('admin.role.index');
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return  \Illuminate\Http\Response
	*/
	public function create()
	{
		return view('admin.role.create');
	}

	/**
	* Display the specified resource.
	*
	* @param    int  $id
	* @return  \Illuminate\Http\Response
	*/
	public function edit($id)
	{
		$entity = Role::find($id);
		return view('admin.role.edit', ['entity' => $entity]);
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
	* @return  \Illuminate\Http\JsonResponse
	*/
	public function pagination(Request $request, $searchCols = [], $with = []){
		$searchCols = ["description","display_name","name"];
		return parent::pagination($request, $searchCols);
	}

	public function setPermission(Request $request, $id){
		$perms = Permission::all();
		$role = Role::find($id);
		if($request->isMethod('post')){
			$ids = $request->input('perms',[]);
			$role->perms()->sync($ids);
		}
		return view('admin.role.permission', ['perms' => $perms, 'role' => $role]);
	}

}

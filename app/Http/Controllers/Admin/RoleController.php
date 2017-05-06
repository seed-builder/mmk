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
	 * @param array $with
	 * @param null $conditionCall
	 * @param bool $all_columns
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function pagination(Request $request, $searchCols = [], $with = [], $conditionCall = null, $all_columns = false){
		$searchCols = ["description","display_name","name"];
		return parent::pagination($request, $searchCols);
	}

	public function setPermission(Request $request, $id){
//		$perms = Permission::all();

		$role = Role::find($id);

		if($request->isMethod('post')){
			$perms = $request->input('perms','');
			$ids = explode(',', $perms);
			$role->perms()->sync($ids);
			$this->flash_success('设置权限成功！');
		}
		$tops = Permission::where('pid', 0)->orderBy('sort')->get();
		$perms =[];// ['text' => 'root', 'selectable' => false, 'state' => [ 'expanded' => true ], 'nodes' => []];
		foreach ($tops as $top)
			$perms[] = $this->toBootstrapTreeViewData($top,  ['text' => 'display_name', 'dataid' => 'id', 'icon' => 'logo'], false);

		foreach ($perms as &$perm){
			$this->checkRolePerm($role, $perm);
		}

		return view('admin.role.permission', ['perms' => $perms, 'role' => $role]);
	}

	protected function checkRolePerm($role, &$node){
		$perm = $node['item'];
		if($role->hasPermission($perm->name)){
			$node['state']['checked'] = true;
		}
		if(!empty($node['nodes'])){
			foreach ($node['nodes'] as &$n){
				$this->checkRolePerm($role, $n);
			}
		}
	}

}

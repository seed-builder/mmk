<?php
namespace App\Http\Controllers\Admin;

use App\Models\Busi\Position;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\Models\User;

class UserController extends AdminController
{

	public function newEntity(array $attributes = [])
	{
		// TODO: Implement newEntity() method.
		return new User($attributes);
	}

	/**
	* Display a listing of the resource.
	*
	* @return  \Illuminate\Http\Response
	*/
	public function index()
	{
		//
		return view('admin.user.index');
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return  \Illuminate\Http\Response
	*/
	public function create()
	{
		return view('admin.user.create');
	}

	/**
	* Display the specified resource.
	*
	* @param    int  $id
	* @return  \Illuminate\Http\Response
	*/
	public function edit($id)
	{
		$entity = User::find($id);
		return view('admin.user.edit', ['entity' => $entity]);
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
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function pagination(Request $request, $searchCols = [], $with = [], $conditionCall = null){
		$searchCols = ["email","name","password","remember_token"];
		return parent::pagination($request, $searchCols);
	}

	public function setRole(Request $request, $id){
		$roles = Role::all();
		$user = User::find($id);
		if($request->isMethod('post')){
			$roleIds = $request->input('roles',[]);
			$user->roles()->sync($roleIds);
			$this->flash_success('设置成功!');
		}
		return view('admin.user.role', ['roles' => $roles, 'user' => $user]);
	}

	public function setPosition(Request $request, $id){
		$user = User::find($id);
		//var_dump($user->positions);
		if($request->isMethod('post')){
			$positionIds = $request->input('positions',[]);
			$user->positions()->sync($positionIds);
			$this->flash_success('设置成功!');
		}

		$tops = Position::where('fparpost_id',0)->get();
		$positions = [];
		foreach ($tops as $top) {
			$positions[] = $this->toBootstrapTreeViewData2($top, ['text' => 'fname', 'dataid' => 'id'], false, $user);
		}
		return view('admin.user.position', ['positions' => $positions, 'user' => $user]);
	}

	/**
	 * 将实体数据转换成树形（bootstrap treeview）数据
	 * @param $entity
	 * @param $props 属性映射集合 ['text' => 'name', 'data-id' => 'id']
	 * @param bool $expanded
	 * @param null $user
	 * @return array
	 */
	public function toBootstrapTreeViewData2($entity, $props, $expanded = true, &$user = null){
		$data = ['item' => $entity];
		if(!empty($entity)){
			foreach ($props as $k => $val){
				$data[$k] = $entity->{$val};
				$data['state']['expanded'] = $expanded;
				//$data['state']['checked'] = true;
			}
			if($user->hasPosition($entity->id)){
				//var_dump($entity);
				$data['state']['checked'] = true;
			}else{
				$data['state']['checked'] = false;
			}
			if(!empty($entity->children)){
				$nodes = [];
				foreach ($entity->children as $child){
					$nodes[] = $this->toBootstrapTreeViewData2($child, $props, $expanded, $user);
				}
				if(!empty($nodes))
					$data['nodes'] = $nodes;
			}
		}
		return $data;
	}

}

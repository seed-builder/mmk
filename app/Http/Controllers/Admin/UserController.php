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
		//$positions = Position::all();
		//position options
		$topPositions = Position::where('fparpost_id',0)->get();
		$positions = [];
		foreach ($topPositions as $position){
			$this->toSelectOption($position, ['label' => 'fname', 'value' => 'id', 'fnumber' => 'fnumber'], $positions);
		}

		$user = User::find($id);
		if($request->isMethod('post')){
			$positionIds = $request->input('positions',[]);
			$user->positions()->sync($positionIds);
			$this->flash_success('设置成功!');
		}
		return view('admin.user.position', ['positions' => $positions, 'user' => $user]);
	}


}

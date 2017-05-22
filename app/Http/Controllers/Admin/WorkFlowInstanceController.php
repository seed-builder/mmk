<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Busi\WorkFlowInstance;
use Illuminate\Support\Facades\Auth;
use WorkFlowEngine;

class WorkFlowInstanceController extends AdminController
{
	public function newEntity(array $attributes = [])
	{
		// TODO: Implement newEntity() method.
		return new WorkFlowInstance($attributes);
	}

	/**
	* Display a listing of the resource.
	*
	* @return  \Illuminate\Http\Response
	*/
	public function index()
	{
		//
		return view('admin.work-flow-instance.index');
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return  \Illuminate\Http\Response
	*/
	public function create()
	{
		return view('admin.work-flow-instance.create');
	}

	/**
	* Display the specified resource.
	*
	* @param    int  $id
	* @return  \Illuminate\Http\Response
	*/
	public function edit($id)
	{
		$entity = WorkFlowInstance::find($id);
		return view('admin.work-flow-instance.edit', ['entity' => $entity]);
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
		$searchCols = ["bill_no","desc","sponsor","title","uid"];
		return parent::pagination($request, $searchCols);
	}

	/**
	 * 我的流程
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function my(Request $request){
		return view('admin.work-flow-instance.my');
	}

	public function myPagination(Request $request){
		$searchCols = ["bill_no","desc","title"];
		return parent::pagination($request, $searchCols, ['workflow'], function ($query){
			$user = Auth::user();
			if(!$user->isAdmin())
				$query->where('sponsor_id', $user->id);
		});
	}

	public function dismiss(Request $request, $id){
		$result = WorkFlowEngine::dismiss($id);
		return  $result ? $this->success(1) : $this->fail('已被处理，不能撤销');
	}

}

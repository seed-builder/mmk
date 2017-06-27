<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Busi\WorkFlow;

class WorkFlowController extends AdminController
{
	public function newEntity(array $attributes = [])
	{
		// TODO: Implement newEntity() method.
		return new WorkFlow($attributes);
	}

	/**
	* Display a listing of the resource.
	*
	* @return  \Illuminate\Http\Response
	*/
	public function index()
	{
		//
		return view('admin.work-flow.index');
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return  \Illuminate\Http\Response
	*/
	public function create()
	{
		return view('admin.work-flow.detail');
	}

	/**
	* Display the specified resource.
	*
	* @param    int  $id
	* @return  \Illuminate\Http\Response
	*/
	public function edit($id)
	{
		$entity = WorkFlow::find($id);
		return view('admin.work-flow.edit', ['entity' => $entity]);
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
		return view('admin.work-flow.detail', compact('id'));
	}

	/**
	 * @param  Request $request
	 * @param  array $searchCols
	 * @param array $with
	 * @param null $conditionCall
	 * @param bool $all_columns
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function pagination(Request $request, $searchCols = [],$with=[], $conditionCall = null, $all_columns = false){
		$searchCols = ["name","table"];
		return parent::pagination($request, $searchCols, ['default_task_approver']);
	}

	public function setDefaultApprover(Request $request, $id){
		$wf = WorkFlow::find($id);
		if(!empty($wf)){
			$wf->default_task_approver_id = $request->input('approver_id');
			$res = $wf->save();
			return $this->success($res);
		}
		return $this->fail('fail');
	}

}

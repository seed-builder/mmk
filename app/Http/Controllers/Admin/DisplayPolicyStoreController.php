<?php
namespace App\Http\Controllers\Admin;

use App\Models\Busi\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Busi\DisplayPolicyStore;

class DisplayPolicyStoreController extends AdminController
{
	public function newEntity(array $attributes = [])
	{
		// TODO: Implement newEntity() method.
		return new DisplayPolicyStore($attributes);
	}

	/**
	* Display a listing of the resource.
	*
	* @return  \Illuminate\Http\Response
	*/
	public function index()
	{
		//
		return view('admin.display-policy-store.index');
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return  \Illuminate\Http\Response
	*/
	public function create()
	{
		return view('admin.display-policy-store.create');
	}

	/**
	* Display the specified resource.
	*
	* @param    int  $id
	* @return  \Illuminate\Http\Response
	*/
	public function edit($id)
	{
		$entity = DisplayPolicyStore::find($id);
		return view('admin.display-policy-store.edit', ['entity' => $entity]);
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
	public function pagination(Request $request, $searchCols = [], $with=[], $conditionCall = null){
		$searchCols = ["fbill_no","fdocument_status","fsketch"];
        $with=['department','employee','policy'];
        $data = $request->all();
        if(!empty($data['nodeid'])){//组织树点击查询
            $query = DisplayPolicyStore::query();
            $dept = Department::find($data['nodeid']);
            $deptids = $dept->getAllChildDept()->pluck('id')->toArray();

            $request['queryBuilder'] = $query->whereIn('fcost_dept_id',$deptids)->with($with);;
        }
		return parent::pagination($request, $searchCols,$with);
	}

}

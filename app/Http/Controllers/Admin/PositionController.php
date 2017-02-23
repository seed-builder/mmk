<?php
namespace App\Http\Controllers\Admin;

use App\Models\Busi\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Busi\Position;

class PositionController extends AdminController
{
	public function newEntity(array $attributes = [])
	{
		// TODO: Implement newEntity() method.
		return new Position($attributes);
	}

	/**
	* Display a listing of the resource.
	*
	* @return  \Illuminate\Http\Response
	*/
	public function index()
	{
		//
		return view('admin.position.index');
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return  \Illuminate\Http\Response
	*/
	public function create()
	{
		return view('admin.position.create');
	}

	/**
	* Display the specified resource.
	*
	* @param    int  $id
	* @return  \Illuminate\Http\Response
	*/
	public function edit($id)
	{
		$entity = Position::find($id);
		return view('admin.position.edit', ['entity' => $entity]);
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
	public function pagination(Request $request, $searchCols = [],$with=[]){
		$searchCols = ["fdocument_status","fforbid_status","fname","fnumber","fremark"];

        $with = ['department','senior'];

        $data = $request->all();
        if(!empty($data['nodeid'])){//组织树点击查询
            $query = Position::query();
            $dept = Department::find($data['nodeid']);
            $deptids = $dept->getAllChildDept()->pluck('id')->toArray();

            $request['queryBuilder'] = $query->whereIn('fdept_id',$deptids)->with($with);
        }

		return parent::pagination($request, $searchCols,$with);
	}

}

<?php
namespace App\Http\Controllers\Admin;

use App\Models\Busi\Employee;
use App\Models\Busi\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Busi\ViewRevisit;

class ViewRevisitController extends AdminController
{
	public function newEntity(array $attributes = [])
	{
		// TODO: Implement newEntity() method.
		return new ViewRevisit($attributes);
	}

	/**
	* Display a listing of the resource.
	*
	* @return  \Illuminate\Http\Response
	*/
	public function index()
	{
		//
        $ids = $this->getCurUsersEmployeeIds();
        $employees = Employee::query()->whereIn('id',$ids)->get();
        $stores = Store::where('fdocument_status', 'A')->get();
		return view('admin.view-revisit.index',compact('employees','stores'));
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return  \Illuminate\Http\Response
	*/
	public function create()
	{
		return view('admin.view-revisit.create');
	}

	/**
	* Display the specified resource.
	*
	* @param    int  $id
	* @return  \Illuminate\Http\Response
	*/
	public function edit($id)
	{
		$entity = ViewRevisit::find($id);
		return view('admin.view-revisit.edit', ['entity' => $entity]);
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
		$searchCols = ["senior_name","store_name","store_number"];
		return parent::pagination($request, $searchCols);
	}

}

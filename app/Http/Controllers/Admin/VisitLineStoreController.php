<?php
namespace App\Http\Controllers\Admin;

use App\Models\Busi\Department;
use App\Models\Busi\Store;
use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Busi\VisitLineStore;
use App\Models\Busi\VisitLine;

class VisitLineStoreController extends AdminController
{
	public function newEntity(array $attributes = [])
	{
		// TODO: Implement newEntity() method.
		return new VisitLineStore($attributes);
	}

	/**
	* Display a listing of the resource.
	*
	* @return  \Illuminate\Http\Response
	*/
	public function index()
	{
		//
		$lines = VisitLine::all();
		$citys = City::query()->where('LevelType',1)->get();
		$depts = Department::all();
		return view('admin.visit-line-store.index',compact('lines','citys','depts'));
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return  \Illuminate\Http\Response
	*/
	public function create()
	{
		return view('admin.visit-line-store.create');
	}

	/**
	* Display the specified resource.
	*
	* @param    int  $id
	* @return  \Illuminate\Http\Response
	*/
	public function edit($id)
	{
		$entity = VisitLineStore::find($id);
		return view('admin.visit-line-store.edit', ['entity' => $entity]);
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
	public function pagination(Request $request, $searchCols = []){
		$searchCols = ["fline_id","femp_id"];
		$data = $request->all();

		if (!empty($data['distinctfields'])){
            $request->distinct = $data['distinctfields'];
        }

		return parent::pagination($request, $searchCols);
	}

    public function destroyAll(Request $request){
	    $data = $request->all();
	    return VisitLineStore::query()->whereIn('id',$data['ids'])->delete();
    }

    //门店线路互调
    public function storeLineIml(Request $request){
        $data = $request->all();
        $query = VisitLineStore::query();

        $update = [];
        if (!empty($data['ids'])){
            $query->whereIn('id',$data['ids']);
        }
        if (!empty($data['fline_id'])){
            $update['fline_id'] = $data['fline_id'];
        }
        if (!empty($data['femp_id'])){
            $update['femp_id'] = $data['femp_id'];
        }

        return $query->update($update);

    }

}

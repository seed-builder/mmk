<?php
namespace App\Http\Controllers\Admin;

use App\Models\Busi\Department;
use App\Models\Busi\Employee;
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

        if(!empty($data['nodeid'])){//组织树点击查询
            $query = VisitLineStore::query();
            $emp = Employee::find($data['nodeid']);
            if (empty($emp)){
                $dept = Department::find($data['nodeid']);
                $emps = $dept->getAllEmployeeByDept();
                $ids = [];
                foreach ($emps as $e){
                    $ids[] = $e->id;
                }
                $request['queryBuilder'] = $query->whereIn('femp_id',$ids);
            }else{
                $request['queryBuilder'] = $query->where('femp_id',$data['nodeid']);
            }
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

    //生成员工线路
    public function makeEmpAllLine(Request $request){
        $data = $request->all();
        $lines = VisitLine::all();

        $stores = Store::query()->where('femp_id',$data['id'])->get();

        if (count($stores)==0){ //若该员工无负责门店 则生成失败
            return response()->json([
                'code' => 500,
                'result' => '该员工无负责门店，生成线路失败！'
            ]);
        }

        $ids = [];
        foreach ($stores as $s){
            $ids[] = $s->id;
        }
        $randomindex = array_rand($ids,1); //随机选择一个用户负责的门店

        foreach ($lines as $l){
            $count = VisitLineStore::query()->where('femp_id',$data['id'])->where('fline_id',$l->id)->count();
            if ($count==0){
                VisitLineStore::create([
                    'fline_id' => $l->id,
                    'fstore_id' => $ids[$randomindex],
                    'femp_id' => $data['id'],
                    'fweek_day' => $l->fnumber
                ]);
            }

        }

        return response()->json([
            'code' => 200,
            'result' => '生成线路成功！'
        ]);
    }

}

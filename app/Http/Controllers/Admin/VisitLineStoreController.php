<?php
namespace App\Http\Controllers\Admin;

use App\Models\Busi\Store;
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
		return view('admin.visit-line-store.index',compact('lines'));
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
		if (!empty($data['fname'])||!empty($data['faddress'])||!empty($data['is_allot'])||!empty($data['fnumber'])){
            $request['queryBuilder']=$this->readyAllotStoreQuery($data);
        }


		return parent::pagination($request, $searchCols);
	}

	public function readyAllotStoreQuery($data){
        $query = VisitLineStore::query();
        if (!empty($data['fname'])){
            $stores = Store::query()->where('fname','like','%'.$data['fname'].'%')->get();
            $ids = [];
            foreach ($stores as $s){
                $ids[] = $s->id;
            }
            $query->whereIn('fstore_id',$ids);
        }
        if (!empty($data['faddress'])){
            $stores = Store::query()->where('faddress','like','%'.$data['faddress'].'%')->get();
            $ids = [];
            foreach ($stores as $s){
                $ids[] = $s->id;
            }
            $query->whereIn('fstore_id',$ids);
        }
        if (!empty($data['fnumber'])){
            $lines = Line::query()->where('fnumber','like','%'.$data['fnumber'].'%')->get();
            $ids = [];
            foreach ($lines as $l){
                $ids[] = $l->id;
            }
            $query->whereIn('fline_id',$ids);
        }

        return $query;
    }

}

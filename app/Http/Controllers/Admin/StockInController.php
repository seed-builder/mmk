<?php
namespace App\Http\Controllers\Admin;

use App\Models\Busi\Customer;
use App\Models\Busi\Material;
use App\Models\Busi\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Busi\StockIn;
use Illuminate\Support\Facades\Auth;

class StockInController extends AdminController
{
	public function newEntity(array $attributes = [])
	{
		// TODO: Implement newEntity() method.
		return new StockIn($attributes);
	}

	/**
	* Display a listing of the resource.
	*
	* @return  \Illuminate\Http\Response
	*/
	public function index()
	{
        $customers = Customer::all()->map(function ($item){
            return ['label' => $item->fname, 'value' => $item->id];
        });
        $materials = Material::all()->map(function ($item){
            return ['label' => $item->fname, 'value' => $item->id];
        });
		return view('admin.stock-in.index',compact('customers','materials'));
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return  \Illuminate\Http\Response
	*/
	public function create()
	{
		return view('admin.stock-in.create');
	}

	/**
	* Display the specified resource.
	*
	* @param    int  $id
	* @return  \Illuminate\Http\Response
	*/
	public function edit($id)
	{
		$entity = StockIn::find($id);
		return view('admin.stock-in.edit', ['entity' => $entity]);
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
	* @return  \Illuminate\Http\JsonResponse
	*/
	public function pagination(Request $request, $searchCols = [], $with=[], $conditionCall = null){
		$searchCols = ["fbill_no","fdocument_status","fsend_status"];
        $with = ['customer','user'];
		return parent::pagination($request, $searchCols,$with);
	}

    public function store(Request $request,$extraFields=[])
    {
        $data = $request->input('data', []);
        $props = current($data);

        $extraFields=[
            'fuser_id' => Auth::user()->id,
            'fbill_no' => rand(10000,99999).date("YmdHis")
        ];
        return parent::store($request,$extraFields);
    }

}

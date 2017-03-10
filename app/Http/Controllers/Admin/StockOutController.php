<?php
namespace App\Http\Controllers\Admin;

use App\Models\Busi\Customer;
use App\Models\Busi\Material;
use App\Models\Busi\StockOutItem;
use App\Models\Busi\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Busi\StockOut;
use Illuminate\Support\Facades\Auth;

class StockOutController extends AdminController
{
	public function newEntity(array $attributes = [])
	{
		// TODO: Implement newEntity() method.
		return new StockOut($attributes);
	}

	/**
	* Display a listing of the resource.
	*
	* @return  \Illuminate\Http\Response
	*/
	public function index()
	{

        $all = Customer::all();
        $customers = $all->map(function ($item){
            return ['label' => $item->fname, 'value' => $item->id];
        });

        $stores = Store::all()->map(function ($item){
            return ['label' => $item->ffullname, 'value' => $item->id];
        });
        $materials = Material::all()->map(function ($item){
            return ['label' => $item->fname, 'value' => $item->id];
        });
		return view('admin.stock-out.index',compact('customers','stores','materials'));
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return  \Illuminate\Http\Response
	*/
	public function create()
	{
		return view('admin.stock-out.create');
	}

	/**
	* Display the specified resource.
	*
	* @param    int  $id
	* @return  \Illuminate\Http\Response
	*/
	public function edit($id)
	{
		$entity = StockOut::find($id);
		return view('admin.stock-out.edit', ['entity' => $entity]);
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

	public function store(Request $request, $extraFields=[])
    {
        $data = $request->input('data', []);
        $props = current($data);

        $extraFields=[
            'fuser_id' => Auth::user()->id,
            'fbill_no' => Store::find($props['fstore_id'])->fnumber.date("Ymd")
        ];
        return parent::store($request, $extraFields);
    }

	/**
	* @param  Request $request
	* @param  array $searchCols
	* @param  array $with
	* @param  null $conditionCall
	* @return  \Illuminate\Http\JsonResponse
	*/
	public function pagination(Request $request, $searchCols = [], $with=[], $conditionCall = null){
		$searchCols = ["fbill_no","fdocument_status","fsbill_no"];
        $with=['customer','store','user'];
		return parent::pagination($request, $searchCols, $with);
	}

}

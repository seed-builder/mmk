<?php
namespace App\Http\Controllers\Customer;

use App\Models\Busi\Customer;
use App\Models\Busi\Material;
use Illuminate\Http\Request;
use App\Http\Controllers\Customer\BaseController;
use App\Models\Busi\CustomerPrice;

class CustomerPriceController extends BaseController
{
	public function newEntity(array $attributes = [])
	{
		// TODO: Implement newEntity() method.
		return new CustomerPrice($attributes);
	}

    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function index()
    {
        // TODO: Implement newEntity() method.
        $customers = Customer::where('fdocument_status','C')->where('fforbid_status', 'A')->get();
        $options = $customers->map(function ($item){
            return ['label' => $item->fname, 'value' => $item->id];
        });
        $collection = array_merge([['label'=> '--请选择--', 'value' => '']] , $options->toArray());
        $materials = Material::all();
        $option2s = $materials->map(function ($item){
            return ['label' => $item->fname, 'value' => $item->id];
        });
        $mc = array_merge([['label'=> '--请选择--', 'value' => '']] , $option2s->toArray());
        return view('customer.customer-price.index', ['customers' => $collection, 'materials' => $mc]);
    }

	/**
	* Show the form for creating a new resource.
	*
	* @return  \Illuminate\Http\Response
	*/
	public function create()
	{
		return view('customer.customer-price.create');
	}

	/**
	* Display the specified resource.
	*
	* @param    int  $id
	* @return  \Illuminate\Http\Response
	*/
	public function edit($id)
	{
		$entity = CustomerPrice::find($id);
		return view('customer.customer-price.edit', ['entity' => $entity]);
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
		$searchCols = ["fspecification"];
		return parent::pagination($request, $searchCols, ['customer', 'material']);
	}

}

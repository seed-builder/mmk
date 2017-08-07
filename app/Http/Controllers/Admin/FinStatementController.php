<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Busi\Customer;
use App\Services\Utility;
use Illuminate\Http\Request;
//use App\Http\Controllers\Customer\BaseController;
use App\Models\Busi\FinStatement;
use Illuminate\Support\Facades\Auth;

class FinStatementController extends AdminController
{
	public function newEntity(array $attributes = [])
	{
		// TODO: Implement newEntity() method.
		return new FinStatement($attributes);
	}

	/**
	* Display a listing of the resource.
	*
	* @return  \Illuminate\Http\Response
	*/
	public function index()
	{
		//
		//$customers = Customer::where('fdocument_status', 'C')->where('fforbid_status', 'A')->get();
		$user = Auth::user();
		if($user->isAdmin()){
			$customers = Customer::where('fdocument_status', 'C')->where('fforbid_status', 'A')->get();
		}else if ($user->reference_type == 'employee'){
			$customers = $user->reference->getVisibleCustomer();
		}

		return view('admin.fin-statement.index', ['customers' => $customers]);
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return  \Illuminate\Http\Response
	*/
	public function create()
	{
		return view('admin.fin-statement.create');
	}

	/**
	* Display the specified resource.
	*
	* @param    int  $id
	* @return  \Illuminate\Http\Response
	*/
	public function edit($id)
	{
		$entity = FinStatement::find($id);
		return view('admin.fin-statement.edit', ['entity' => $entity]);
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
		$searchCols = ["bill_type","project_no"];
		return parent::pagination($request, $searchCols, $with, function ($queryBuilder){
//			$queryBuilder->where('cust_id', Auth::user()->reference_id);
		});
	}

	/**
	 * 获取经销商账款余额接口
	 */
	public function getCustAmount(Request $request){
		if(env('APP_DEBUG')){
			return response(['data' => 100.10, 'code' => 200, 'msg' => '', 'success' => true]);
		}
		$cust_id = Auth::user()->reference_id;
		$amount = Utility::getCustomerBalance($cust_id);
		return response(['data' => $amount, 'code' => 200, 'msg' => '', 'success' => true]);
	}

	public function print(Request $request){
		$ids = $request->input('ids');
		$items = [];
		if(!empty($ids)){
			$arr = explode(',', $ids);
			$items = FinStatement::whereIn('id', $arr)->get();
		}
		return view('admin.fin-statement.print', ['items' => $items]);
	}

}

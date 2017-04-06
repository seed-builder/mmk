<?php
namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Busi\Customer;

class CustomerController extends AdminController
{
	public function newEntity(array $attributes = [])
	{
		// TODO: Implement newEntity() method.
		return new Customer($attributes);
	}

	/**
	* Display a listing of the resource.
	*
	* @return  \Illuminate\Http\Response
	*/
	public function index()
	{
		//
		return view('admin.customer.index');
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return  \Illuminate\Http\Response
	*/
	public function create()
	{
		return view('admin.customer.create');
	}

	/**
	* Display the specified resource.
	*
	* @param    int  $id
	* @return  \Illuminate\Http\Response
	*/
	public function edit($id)
	{
		$entity = Customer::find($id);
		return view('admin.customer.edit', ['entity' => $entity]);
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
	 * @param bool $all_columns
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function pagination(Request $request, $searchCols = [], $with=[], $conditionCall = null, $all_columns = false){
		$searchCols = ["faddress","farea","fbusiness_mode","fcity","fcompany_nature","fcompany_scale","fcountry","fcust_type_id","fdiscount_list_id","ffax","fgroup","finvoice_type","fmode_transport","fname","fprice_list_id","fprovince","fsale_depart","fseller","fservice_depart","fshort_name","ftax_rate","ftax_register_code","ftax_type","ftel","ftrading_curr_id","fwebsite","fzip"];
		return parent::pagination($request, $searchCols);
	}

	/**
	 * 开通经销商门户后台登陆
	 * @param Request $request
	 * @param $id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function open(Request $request, $id){
		$customer =	Customer::find($id);
		if($request->isMethod('POST')){
			$this->validate($request, [
				'name' => 'required|max:255',
				'password' => 'required',
			]);
			$prop = [
				'name' => $request->input('name'),
				'password' =>  bcrypt($request->input('password')),
				'status' => 1
			];
			$user = $customer->user;
			if(empty($user)){
				$customer->user()->create($prop);
			}else{
				$user->update($prop);
				//$user->save();
			}
//			$customer->login_name = $request->input('login_name');
//			$customer->password = bcrypt($request->input('password'));
//			$customer->save();
			return $this->success($customer);
		}else{
			return view('admin.customer.open', ['customer' =>$customer ,'user'=>$customer->user]);
		}
	}

	public function unique(Request $request, $id){
		$name = $request->input('name');
		$count = User::where('name',$name)->where('reference_type', 'customer')->where('reference_id', '<>', $id)->count();
		$valid = $count == 0 ;
		return response(['valid' => $valid, 'message' => '该名称已存在'], 200);
	}

}

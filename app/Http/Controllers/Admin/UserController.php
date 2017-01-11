<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends AdminController
{
    //
	public function newEntity(array $attributes = [])
	{
		// TODO: Implement newEntity() method.
	}

	public function index()
	{
		return view('admin.user.index');
	}

	/**
	 * @param Request $request
	 * @param array $searchCols
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function pagination(Request $request, $searchCols = []){
		$searchCols = ['name'];
		return parent::pagination($request, $searchCols);
	}



	public function login(Request $request){
		if($request->isMethod('get')){
			return  view('admin.user.login');
		}else{
			return redirect('/admin/');
		}
	}

	public function logout(){
		return redirect('/admin/user/login');
	}
}

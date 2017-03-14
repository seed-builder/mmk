<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends BaseController
{
	function __construct()
	{
		$this->middleware('auth');
	}

	//
	public function index(){
		return view('customer.index.index');
	}
}

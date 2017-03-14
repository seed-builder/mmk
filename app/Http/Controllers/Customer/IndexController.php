<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends BaseController
{
	//
	public function index(){
		return view('customer.index.index');
	}
}

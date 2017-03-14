<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\DatatablesController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BaseController extends DatatablesController
{
    //
	public function __construct()
	{
		//$this->middleware('auth');
	}

	public function newEntity(array $attributes = [])
	{
		// TODO: Implement newEntity() method.
	}
}

<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends AdminController
{
    //
    public function index(){
        return view('admin.home.index');
    }

	public function newEntity(array $attributes = [])
	{
		// TODO: Implement newEntity() method.
	}
}

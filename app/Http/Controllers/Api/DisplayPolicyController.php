<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Busi\DisplayPolicy;

class DisplayPolicyController extends ApiController
{
    //
	public function newEntity(array $attributes = [])
	{
		//
		return new DisplayPolicy($attributes);
	}
}

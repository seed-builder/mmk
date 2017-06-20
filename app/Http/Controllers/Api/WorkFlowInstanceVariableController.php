<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Models\Busi\WorkFlowInstanceVariable;

class WorkFlowInstanceVariableController extends ApiController
{
	//
	public function newEntity(array $attributes = [])
	{
		// TODO: Implement newEntity() method.
		return new WorkFlowInstanceVariable($attributes);
	}
}
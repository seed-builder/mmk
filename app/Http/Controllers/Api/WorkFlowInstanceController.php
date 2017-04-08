<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Models\Busi\WorkFlowInstance;

class WorkFlowInstanceController extends ApiController
{
	//
	public function newEntity(array $attributes = [])
	{
		// TODO: Implement newEntity() method.
		return new WorkFlowInstance($attributes);
	}

	/**
	 * 同意，审批通过
	 */
	public function agree(){

	}

	/**
	 * 不同意，审批结束
	 */
	public function against(){

	}

}
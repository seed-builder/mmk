<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Models\Busi\WorkFlowLog;

class WorkFlowLogController extends ApiController
{
	//
	public function newEntity(array $attributes = [])
	{
		// TODO: Implement newEntity() method.
		return new WorkFlowLog($attributes);
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
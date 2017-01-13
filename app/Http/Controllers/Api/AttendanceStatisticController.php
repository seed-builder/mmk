<?php

namespace App\Http\Controllers\Api;

use App\Models\Busi\AttendanceStatistic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AttendanceStatisticController extends ApiController
{
    //
	public function newEntity(array $attributes = [])
	{
		// TODO: Implement newEntity() method.
		return new AttendanceStatistic($attributes);
	}
}

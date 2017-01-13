<?php

namespace App\Http\Controllers\Api;

use App\Models\Busi\AttendanceReport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AttendanceReportController extends ApiController
{
    //
	public function newEntity(array $attributes = [])
	{
		// TODO: Implement newEntity() method.
		return new AttendanceReport($attributes);
	}
}

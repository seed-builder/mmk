<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Busi\Attendance as Entity;

class AttendanceController extends ApiController
{
    public function newEntity(array $attributes = [])
    {
        return new Entity($attributes);
    }
}

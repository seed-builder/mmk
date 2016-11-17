<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Busi\Leave as Entity;

class LeaveController extends Controller
{
    public function newEntity(array $attributes = [])
    {
        return new Entity($attributes);
    }
}

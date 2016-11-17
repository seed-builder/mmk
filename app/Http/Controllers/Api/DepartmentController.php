<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Busi\Department as Entity;

class DepartmentController extends ApiController
{
    public function newEntity(array $attributes = [])
    {
        return new Entity($attributes);
    }


}

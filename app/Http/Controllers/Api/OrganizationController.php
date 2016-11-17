<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Busi\Organization as Entity;

class OrganizationController extends Controller
{
    public function newEntity(array $attributes = [])
    {
        return new Entity($attributes);
    }
}

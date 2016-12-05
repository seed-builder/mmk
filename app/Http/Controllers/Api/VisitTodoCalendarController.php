<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Busi\VisitTodoCalendar;

class VisitTodoCalendarController extends ApiController
{
    //
    public function newEntity(array $attributes = [])
    {
        // TODO: Implement newEntity() method.
        return new VisitTodoCalendar($attributes);
    }
}

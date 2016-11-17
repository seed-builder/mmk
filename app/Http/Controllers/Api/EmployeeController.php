<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Busi\Employee as Entity;
use Hash;
use App\Http\Requests\StoreEmployeeRequest;

class EmployeeController extends ApiController
{
    //
    public function login(Request $request){
        $this->validate($request, [
            'phone' => 'required',
            'pwd' => 'required'
        ]);
        $emp = Entity::where('fphone', $request->input('phone'))->first();
        $pwd = $request->input('pwd');
        if($pwd == $emp->fpassword){
            return response($emp, 200);
        }else{
            return response('wrong!', 401);
        }
    }

    public function newEntity(array $attributes = [])
    {
        return new Entity($attributes);
    }
}

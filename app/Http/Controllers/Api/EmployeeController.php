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
        $device = $request->input('device','');
        $emp = Entity::where('fphone', $request->input('phone'))->first();
        $pwd = $request->input('pwd');
        if(empty($emp)){
            return response('该号码不存在！', 401);
        }
        var_dump($emp);
        if($pwd == $emp->fpassword){
            if(empty($emp->device)){
                if(!env('APP_DEBUG'))
                    $emp->device = $device;
            }else if($emp->device != $device){
                return response('设备号不一致！', 401);
            }
            $emp->login_time += 1;
            $emp->save();
            return response($emp, 200);
        }else{
            return response('密码错误!', 401);
        }
    }

    public function newEntity(array $attributes = [])
    {
        return new Entity($attributes);
    }
}

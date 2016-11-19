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
            'pwd' => 'required',
            'device_sn' => 'required',
            'device' => 'required',
        ]);
        $device_sn = $request->input('device_sn','');
        $device = $request->input('device','');
        $emp = Entity::where('fphone', $request->input('phone'))->first();
        $pwd = $request->input('pwd');
        if(empty($emp)){
            return response('该号码不存在！', 401);
        }
        //var_dump($emp);
        if($pwd == $emp->fpassword){
            if(empty($emp->device_sn)){
                if(!env('APP_DEBUG')) {
                    $emp->device_sn = $device_sn;
                    $emp->device = $device;
                }
            }else if($emp->device_sn != $device_sn){
                return response('设备号不一致！', 401);
            }
            $emp->login_time += 1;
            $emp->save();
            $senior = $emp->getSenior();
            $data = [
                'id' => $emp->id,
                'fname' => $emp->fname,
                'fname' => $emp->fname,
                'fphoto' => $emp->fphoto,
                'login_time' => $emp->login_time,
                'position' => $emp->position ? $emp->position->fname : '',
                'senior_phone' => $senior ? $senior->fphone:'',
                'senior_name' => $senior ? $senior->fname:'',
                'department_name' => $emp->department? $emp->department->fname : '',
                'department_id' => $emp->fdept_id,
                'org_name' => $emp->organization? $emp->organization->fname : '',
                'org_id' => $emp->forg_id
            ];

            return response($data, 200);
        }else{
            return response('密码错误!', 401);
        }
    }

    public function newEntity(array $attributes = [])
    {
        return new Entity($attributes);
    }
}

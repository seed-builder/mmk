<?php

namespace App\Http\Controllers\Api;

use App\Models\Busi\Employee;
use App\Repositories\SysConfigRepo;
use Illuminate\Http\Request;
use App\Models\Busi\Employee as Entity;
use Hash;
use App\Http\Requests\StoreEmployeeRequest;
use Illuminate\Support\Facades\DB;

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
        $debug = $request->input('debug',0);
        $emp = Entity::where('fphone', $request->input('phone'))->first();
        $pwd = $request->input('pwd');
        if(empty($emp)){
            return response('该号码不存在！', 401);
        }
        //var_dump($emp);
        if($pwd == $emp->fpassword){
            //13000000000 测试账号
            if($emp->fphone != '13000000000') {
	            $sn = trim($emp->device_sn);
	            if (empty($sn)) {
		            //if(!env('APP_DEBUG')) {
		            $emp->device_sn = $device_sn;
		            $emp->device = $device;
		            //}
	            } else if ($debug == 0 && $emp->device_sn != $device_sn) {
		            return response('设备号不一致！', 401);
	            }
            }
            $emp->login_time += 1;
            $emp->save();
            $senior = $emp->getSenior();
            $data = [
                'id' => $emp->id,
                'fname' => $emp->fname,
                'femail' => $emp->femail,
                'fphone' => $emp->fphone,
                'fphoto' => $emp->fphoto,
                'login_time' => $emp->login_time,
                'position' => $emp->position ? $emp->position->fname : '',
                'senior_phone' => $senior ? $senior->fphone:'',
                'senior_name' => $senior ? $senior->fname:'',
                'department_name' => $emp->department? $emp->department->fname : '',
                'department_id' => $emp->fdept_id,
                'org_name' => $emp->organization? $emp->organization->fname : '',
                'org_id' => $emp->forg_id,
	            'customer' => $emp->customer
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

	/**
	 * 获取该员工有权限管理的下属
	 * @param Request $request
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 */
	public function subordinates(Request $request, $id)
	{
		$employee = Employee::find($id);
		if ($employee->isDataIsolate()) {
			$subs = $employee->getSubordinates();
		}else{
			$subs = Employee::all();
		}
		return response(['list' => $subs], 200);
    }
}

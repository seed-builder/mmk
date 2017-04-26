<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017-04-17
 * Time: 15:28
 */

namespace App\Repositories;

use App\Events\EmployeeLoginedEvent;
use Illuminate\Support\Facades\Cache;
use App\Models\Busi\Employee;

class EmployeeRepo extends Repo
{
	protected $prefix = 'empployee_';

	public function login($phone, $pwd, $device, $sn)
	{
		$loginData = $this->getLoginData($phone);//Cache::get($this->prefix . $phone);
		if (empty($loginData)) {
			return $this->fail('该号码不存在！');
		}
		if ($pwd == $loginData['fpassword']) {
			event(new EmployeeLoginedEvent($loginData['id'], $device, $sn));
			return $this->success($loginData);
		}else{
			return $this->fail('密码错误！');
		}
	}

	public function getLoginData($phone){
		$key = $this->prefix . $phone;
		$loginData = Cache::get($key);
		//var_dump($loginData);
		if(is_null($loginData)){
			$emp = Employee::where('fphone', $phone)->first();
			if(!empty($emp)){
				$senior = $emp->getSenior();
				$loginData = [
					'id' => $emp->id,
					'fpassword' => $emp->fpassword,
					'fname' => $emp->fname,
					'femail' => $emp->femail,
					'fphone' => $emp->fphone,
					'fphoto' => $emp->fphoto,
					'login_time' => $emp->login_time,
					'position' => $emp->position ? $emp->position->fname : '',
					'senior_phone' => $senior ? $senior->fphone : '',
					'senior_name' => $senior ? $senior->fname : '',
					'department_name' => $emp->department ? $emp->department->fname : '',
					'department_id' => $emp->fdept_id,
					'org_name' => $emp->organization ? $emp->organization->fname : '',
					'org_id' => $emp->forg_id,
					'customer' => $emp->customer->first(),
					'user_id' => empty($emp->user) ? 0 : $emp->user->id
				];

				Cache::forever($key, $loginData);
			}
		}
		return $loginData;
	}

	public function clearCache($phone){
		$key = $this->prefix . $phone;
		Cache::forget($key);
	}

	public function changePwd($phone, $pwd, $code){
		$resp = Sms::checkVerifyCode($phone, $code);
		if($resp){
			$emp = Employee::where('fphone', $phone)->first();
			$emp->fpassword = $pwd;
			$emp->save();
			$this->clearCache($phone);
			return $this->success($emp, '修改密码成功');
		}else{
			return $this->fail('验证码错误!');
		}
	}
}
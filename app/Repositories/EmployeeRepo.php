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
use Sms;

class EmployeeRepo extends Repo
{
	protected $prefix = 'empployee_';

	public function login($phone, $pwd, $device, $sn)
	{
		$loginData = $this->getLoginData($phone);//Cache::get($this->prefix . $phone);
		if (empty($loginData)) {
			return $this->fail('该号码不存在！');
		}
		$device_sn = trim($loginData['device_sn']);
		if ($phone != '13000000000') {
			if (!empty($device_sn) && $sn != $device_sn) {
				return $this->fail('设备号不一致！');
			}
		}
		if ($pwd == $loginData['fpassword']) {
			event(new EmployeeLoginedEvent($loginData['id'], $device, $sn));
			if(empty($device_sn)) {
				$loginData['device'] = $device;
				$loginData['device_sn'] = $sn;
				$this->clearCache($phone);
				$this->cacheData($phone, $loginData);
			}
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
			$emp = Employee::where('fphone', $phone)->where('fforbid_status','A')->first();
			if(!empty($emp)){
				$senior = $emp->getSenior();
				$loginData = [
					'id' => $emp->id,
					'fpassword' => $emp->fpassword,
					'fname' => $emp->fname,
					'femail' => $emp->femail,
					'device' => $emp->device,
					'device_sn' => $emp->device_sn,
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

	public function cacheData($phone, $data){
		$key = $this->prefix . $phone;
		Cache::forever($key, $data);
	}

	public function clearCache($phone){
		$key = $this->prefix . $phone;
		Cache::forget($key);
	}

	public function changePwd($phone, $pwd, $code){
		$resp = Sms::checkVerifyCode($phone, $code);
		if($resp){
			$emp = Employee::where('fphone', $phone)->first();
			if(!empty($emp)) {
				$emp->fpassword = $pwd;
				$emp->save();
				$this->clearCache($phone);
				return $this->success($emp, '修改密码成功');
			}else{
				return $this->fail('用户不存在!');
			}
		}else{
			return $this->fail('验证码错误!');
		}
	}

	public function syncUser($employee){
		if (empty($employee->user)) {
			$user = $employee->user()->create([
				'name' => $employee->fphone,
				'password' => bcrypt('888888'),
				'login_time' => $employee->login_time,
				'status' => $employee->fforbid_status == 'A',
				'nick_name' => $employee->fname,
				'logo' => $employee->fphoto,
			]);
			if($employee->fpost_id > 0)
			{
				$user->positions()->sync([$employee->fpost_id]);
			}
			//$user->roles()->sync([3]);
		}else{
			$employee->user()->update([
				'name' => $employee->fphone,
				'password' =>  bcrypt('888888'), //$employee->fpassword,
				'login_time' => $employee->login_time,
				'nick_name' => $employee->fname,
				'logo' => $employee->fphoto,
				'status' => $employee->fforbid_status == 'A',
			]);
//			if($employee->fpost_id > 0)
//			{
//				$employee->user->positions()->sync([$employee->fpost_id]);
//			}
//			$employee->user->roles()->sync([3]);
		}
		$this->clearCache($employee->fphone);
	}

}
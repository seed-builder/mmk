<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017-04-27
 * Time: 17:10
 */

namespace App\Services\DataSync;

use App\Models\Busi\Employee;
use EmployeeRepo;

class EmployeeFilter extends DefaultFilter
{
	public function afterAccept(&$data)
	{
		//parent::afterAccept($data); // TODO: Change the autogenerated stub
		if(!empty($data['fphone'])) {
//			EmployeeRepo::clearCache($data['fphone']);
			$employee = Employee::find($data['id']);
//			if(!empty($employee) && empty($employee->user)) {
//				$employee->user()->create([
//					'name' => $employee->fphone,
//					'password' => bcrypt('888888'),//$employee->fpassword,
//					'login_time' => $employee->login_time ?: 0,
//					'logo' => $employee->fphoto ?: '',
//					'status' => 1
//				]);
//			}
			EmployeeRepo::syncUser($employee);
		}
	}
}
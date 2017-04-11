<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017-04-11
 * Time: 13:58
 */

namespace App\Services\WorkFlow;
use App\Models\User;

/**
 * 审批人，处理人
 * Class Approver
 * @package App\Services\WorkFlow
 */
class Approver
{
	protected $user;

	public function __construct($id)
	{
		//$this->id = $id;
		$this->user = User::find($id);
		//$this->name = $name;
	}

	public function getSeniors(){
		$seniors = [];
		$user = User::find($this->id);
		if(!empty($user)){
			$arr = $user->getSeniors();
			$seniors = $arr->map(function($user){
				return new Approver($user->id, $user->name);
			});
		}
		return $seniors;
	}

	public static function getApprovers($node, $preTaskApprover){
		$approvers = [];
		//审批人类型(0-特定人，1-按职位角色, 2-直接上级)
		switch ($node->approver_type) {
			case 0:
				$approvers[] = new Approver($node->approver);
				break;
			case 1:

				break;
			case 2:
				$approvers = $preTaskApprover->getSeniors();
				break;
		}
		return $approvers;
	}

	public function __get($name)
	{
		// TODO: Implement __get() method.
		return $this->user->{$name} ?: null;
	}
}
<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017-04-10
 * Time: 18:44
 */

namespace App\Services\WorkFlow;

use App\Models\User;

/**
 * 发起人
 * Class Sponsor
 * @package App\Services\WorkFlow
 */
class Sponsor
{
	protected $user;

	public function __construct($id)
	{
		$this->user = User::find($id);
	}

	public function __get($name)
	{
		// TODO: Implement __get() method.
		return $this->user->{$name} ?: null;
	}
}
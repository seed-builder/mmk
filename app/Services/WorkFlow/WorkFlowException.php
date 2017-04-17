<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017-04-15
 * Time: 18:08
 */

namespace App\Services\WorkFlow;


use Throwable;

class WorkFlowException extends \Exception
{
	public function __construct($message = "", $code = 0, Throwable $previous = null)
	{
		parent::__construct($message, $code, $previous);
	}

}
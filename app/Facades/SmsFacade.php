<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017-03-02
 * Time: 12:19
 */

namespace App\Facades;

use App\Services\Sms\ISmsSvr;
use Illuminate\Support\Facades\Facade;

/**
 * @see \Illuminate\Cache\CacheManager
 * @see \Illuminate\Cache\Repository
 */
class SmsFacade extends Facade
{
	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return ISmsSvr::class;
	}

}

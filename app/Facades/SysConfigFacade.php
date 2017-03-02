<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017-03-02
 * Time: 12:19
 */

namespace App\Facades;
use Illuminate\Support\Facades\Facade;
use App\Repositories\ISysConfigRepo;

/**
 * @see \Illuminate\Cache\CacheManager
 * @see \Illuminate\Cache\Repository
 */
class SysConfigFacade extends Facade
{
	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return ISysConfigRepo::class;
	}

}

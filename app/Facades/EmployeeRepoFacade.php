<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017-03-02
 * Time: 12:19
 */

namespace App\Facades;

use App\Repositories\EmployeeRepo;
use Illuminate\Support\Facades\Facade;

/**
 * @see \Illuminate\Cache\CacheManager
 * @see \Illuminate\Cache\Repository
 */
class EmployeeRepoFacade extends Facade
{
	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'employee-repo';
	}

}

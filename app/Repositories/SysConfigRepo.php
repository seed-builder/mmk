<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017-03-02
 * Time: 9:54
 */

namespace App\Repositories;

use App\Models\SysConfig;
use Illuminate\Support\Facades\Cache;

class SysConfigRepo extends Repo implements ISysConfigRepo
{
	/**
	 * app端是否启动了数据隔离
	 * @return bool
	 */
	public function isAppDataIsolate(){
		if( Cache::has('app-data-isolate')) {
			$config = Cache::get('app-data-isolate');
		}else{
			$config = SysConfig::where('name', 'app-data-isolate')->first();
			Cache::put('app-data-isolate', $config);
		}
		return $config->status == 1 ;
	}

	/**
	 * 后端是否启动了数据隔离
	 * @return bool
	 */
	public function isMgtDataIsolate(){
		if( Cache::has('mgt-data-isolate')) {
			$config = Cache::get('mgt-data-isolate');
		}else{
			$config = SysConfig::where('name', 'mgt-data-isolate')->first();
			Cache::put('mgt-data-isolate', $config);
		}
		return $config->status == 1 ;
	}

	/**
	 * 不受数据隔离限制的员工 id 字符串
	 * @return string
	 */
	public function noDataIsolateEmployees(){
		if( Cache::has('no-data-isolate-employees')) {
			$config = Cache::get('no-data-isolate-employees');
		}else{
			$config = SysConfig::where('name', 'no-data-isolate-employees')->first();
			Cache::put('no-data-isolate-employees', $config);
		}
		return $config->status == 1 ? $config->value : '';
	}

}
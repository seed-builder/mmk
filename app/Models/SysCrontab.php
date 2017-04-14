<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SysCrontab extends Model
{
    //
	protected $table = 'sys_crontabs';
	protected $guarded = ['id'];
	public $validateRules=['name' => 'required|unique:sys_crontabs'];

	public static function exec($name, $remark = ''){
		var_dump($name);
		$crontab = static::where('name', $name)->first();
		var_dump($crontab);
		if(!empty($crontab)){
			$crontab->update([
				'exec_time' => date('Y-m-d H:i:s'),
				'exec_remark' => $remark
			]);
		}
	}
}

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
		$crontab = static::where('name', $name)->first();
		if(!empty($crontab)){
			$crontab->update([
				'exec_time' => date('Y-m-d H:i:s'),
				'exec_remark' => $remark
			]);
		}
	}
}

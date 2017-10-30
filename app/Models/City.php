<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    //
	protected $table = 'citys';

	/**
	 * 获取邮政编码
	 * @param $province
	 * @param $city
	 * @param $country
	 * @return bool|string
	 */
	public static function getPostalCode($province, $city, $country){
		$arr = ['中国'];
		if(!empty($province)) $arr[] = str_replace('市', '', $province) ;
		if(!empty($city)) $arr[] = $city;
		if(!empty($country)) $arr[] = $country;
		$mergerName = implode(',',$arr);
		$entity = static::where('MergerName', $mergerName)->first();
		if($entity){
			return $entity->ZipCode;
		}else{
			return false;
		}
	}
}

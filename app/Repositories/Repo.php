<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017-03-02
 * Time: 9:55
 */

namespace App\Repositories;


class Repo
{
	public function success($data){
		return ['data' => $data, 'success' => true];
	}

	public function fail($msg){
		return ['data' => null, 'success' => false, 'error' => $msg];
	}
}
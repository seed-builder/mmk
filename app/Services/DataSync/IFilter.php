<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017-01-14
 * Time: 15:42
 */

namespace App\Services\DataSync;

interface IFilter
{
	public function beforeSend($data);
	public function afterSend($data);

	public function beforeAccept($data);
	public function afterAccept($data);
}
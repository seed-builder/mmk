<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017-04-15
 * Time: 11:16
 */

namespace App\Services\WorkFlow;

use App\Models\Busi\Message as EntityMessage;

class Message
{
	public static function send($fromId, $toId, $content){
		EntityMessage::create([
			''
		]);
	}
}
<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017-04-15
 * Time: 11:16
 */

namespace App\Services\WorkFlow;

use App\Models\Busi\Message as EntityMessage;
use App\Models\Busi\MessageContent;

class Message
{
	public static function sendStoreChangeTask($toId, $title, $content, $taskId){
		static::send($toId, $title, $content, 'workflow_store_change',$taskId, 2);
	}

	/**
	 * @param $toId
	 * @param $title
	 * @param $content
	 * @param $extraType
	 * @param $extraId
	 * @param int $type
	 * @param int $fromId
	 */
	public static function send($toId, $title, $content, $extraType, $extraId, $type=2, $fromId = 0){
		$mc = MessageContent::create([
			'type' => $type ,
			'title' => $title,
			'content' => $content,
			'subtitle' => $content,
		]);
		EntityMessage::create([
			'from_id' => $fromId,
			'to_id' => $toId,
			'message_content_id' => $mc->id,
			'type' => $type ,//消息类型（0-系统公告,1-公司发文,2-流程消息,3-任务消息）
			'extra_id' => $extraId,
			'extra_type' => $extraType,
		]);
	}
}
<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2017/4/9
 * Time: 18:47
 */

namespace App\Services;

use App\Models\Busi\Message;
use App\Models\Busi\MessageContent;
use JPush\Client as JPush;
use App\Services\LogSvr;


class MessageService
{
    private static $instance;

    public function sendMessage($ids,$content_id, $type = 1){
        $message = MessageContent::find($content_id);
        $content = $message->content;
        if(env('APP_DEBUG')){
            return;
        }

        $client = new JPush(env('JPUSH_APP_KEY'), env('JPUSH_SECRET'));
        try {
            $response = $client->push()
                ->setPlatform(array('ios', 'android'))
                ->addAlias($ids)
                ->iosNotification($content, array(
                    'sound' => 'sound.caf',
                    'badge' => '1',
                    // 'content-available' => true,
                    // 'mutable-content' => true,
                    'category' => 'jiguang',
                    'extras' => ['type' => $type]
                ))
                ->androidNotification($content, array(
                    'title' => $message->title,
                    // 'build_id' => 2,
                    'extras' =>  ['type' => $type]
                ))
                //->message($content, $message)
                ->send();
            $msg[] = '发送成功！';
        } catch (\JPush\Exceptions\APIConnectionException $e) {
            // try something here
            //print $e;
            LogSvr::MessageService()->error('错误, APIConnectionException：'. $e);
            $msg[] = '发送失败: ' . $e->getMessage();
        } catch (\JPush\Exceptions\APIRequestException $e) {
            // try something here
            //print $e;
            LogSvr::MessageService()->error('错误, APIRequestException：'. $e);
            $msg[] = '发送失败: ' . $e->getMessage();
        }
    }

	/**
	 * 创建消息
	 * @param $fromId
	 * @param $toId
	 * @param $content
	 * @param bool $push 是否推送到app
	 */
    public function createSend($fromId, $toId, MessageContent $content, $push = false, $extraId=0, $extraType=''){
		if(empty($content->id)){
			$content->save();
		}
		$msg = Message::create([
			'from_id' => $fromId,
			'to_id' => $toId,
			'message_content_id' => $content->id,
			'type' => $content->type,
			'extra_id' => $extraId,
			'extra_type' => $extraType,
		]);
		if($push){
			$this->sendMessage([$toId], $content->id, 2);
		}
    }

	/**
	 * 系统发送消息
	 * @param $toId
	 * @param $title
	 * @param MessageContent $content
	 * @param bool $push
	 * @param int $extraId
	 * @param string $extraType
	 */
    public function systemSend($toId, $title, $content, $push = false, $extraId=0, $extraType=''){
    	$mc = new MessageContent([
    		'title' => $title,
		    'subtitle' => $title,
		    'content' => $content,
		    'type' => 0,

	    ]);
    	return $this->createSend(0, $toId, $mc, $push, $extraId, $extraType);
    }

	/**
	 * singleton
	 * @return MessageService
	 */
    public static function Instance(){
    	if(static::$instance == null){
		    static::$instance = new MessageService();
	    }
    	return  static::$instance ;
    }
}
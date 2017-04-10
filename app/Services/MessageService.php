<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2017/4/9
 * Time: 18:47
 */

namespace App\Services;

use App\Models\Busi\MessageContent;
use JPush\Client as JPush;
use App\Services\LogSvr;


class MessageService
{
    public function sendMessage($ids,$content_id){
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
                    'extras' => ['type' => 1]
                ))
                ->androidNotification($content, array(
                    'title' => $message->title,
                    // 'build_id' => 2,
                    'extras' =>  ['type' => 1]
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
}
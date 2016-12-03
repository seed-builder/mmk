<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Busi\Attendance;
use DB;
use JPush\Client as JPush;
use App\Services\LogSvr;
use App\Models\Busi\MessageTemplate;

class AttendancePolling extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:attendance_polling';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '考勤日完成情况轮询通知';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $today = date('Y-m-d');
        //date_format(ftime, '%Y-%m-%d') = ?
        //$results = DB::select('select * from ms_attendances WHERE date_format(ftime, \'%Y-%m-%d\') = ?',
        $messageTemp = MessageTemplate::where('type', 0)->first();
        if(empty($messageTemp)){
            LogSvr::AttendancPolling()->warn('警告：没有找到【type=0】的消息模板！');
            return;
        }
        $client = new JPush(env('JPUSH_APP_KEY'), env('JPUSH_SECRET'));
        // type=1 , content=
        $content = str_replace('#name', 'test', $messageTemp->content);
//        $message = array(
//            'title' => $messageTemp->title,
//            'content_type' => 'text',
//            'extras' => ['type' => 1]
//        );

        try {
            $response = $client->push()
                ->setPlatform(array('ios', 'android'))
                ->addAlias(['1','120412','3'])
                ->iosNotification($content, array(
                    'sound' => 'sound.caf',
                    'badge' => '1',
                    // 'content-available' => true,
                    // 'mutable-content' => true,
                    'category' => 'jiguang',
                    'extras' => ['type' => 1]
                ))
                ->androidNotification($content, array(
                    'title' => $messageTemp->title,
                    // 'build_id' => 2,
                    'extras' =>  ['type' => 1]
                ))
                //->message($content, $message)
                ->send();

        } catch (\JPush\Exceptions\APIConnectionException $e) {
            // try something here
            //print $e;
            LogSvr::AttendancPolling()->error('错误, APIConnectionException：'. $e);
        } catch (\JPush\Exceptions\APIRequestException $e) {
            // try something here
            //print $e;
            LogSvr::AttendancPolling()->error('错误, APIRequestException：'. $e);
        }
        //print_r($response);
    }
}

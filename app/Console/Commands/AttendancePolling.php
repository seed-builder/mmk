<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Busi\Attendance;
use DB;
use JPush\Client as JPush;
use App\Services\LogSvr;
use App\Models\Busi\MessageTemplate;
use App\Models\Busi\WorkCalendarData;

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
        $day = WorkCalendarData::where('fday', $today)->first();
        if(!$day->fis_work_time) return; //非工作日

        $sql = <<<EOH
select e.id from bd_employees e
where NOT EXISTS (select a.id from ms_attendances a where e.id = a.femp_id and a.ftype = 1)
EOH;
		$result = DB::select($sql);

		if(!empty($result)){
			$ids = $result->map(function ($item){
				return $item->id;
			});
			$this->sendMsg($ids->all());
		}
    }

    protected function sendMsg($ids){

	    $messageTemp = MessageTemplate::where('type', 0)->first();
	    if(empty($messageTemp)){
		    LogSvr::AttendancPolling()->warn('警告：没有找到【type=0】的消息模板！');
		    return;
	    }
	    // type=1 , content=
	    $content = $messageTemp->content ;//str_replace('#name', 'test', $messageTemp->content);

	    if(env('APP_DEBUG')){
		    LogSvr::AttendancPolling()->info('AttendancePolling测试, 待发送推送消息的 ids：'. json_encode($ids));
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
    }
}

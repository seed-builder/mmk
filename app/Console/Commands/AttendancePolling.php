<?php

namespace App\Console\Commands;

use App\Models\SysCrontab;
use Illuminate\Console\Command;
use App\Models\Busi\Attendance;
use DB;
use JPush\Client as JPush;
use App\Services\LogSvr;
use App\Models\Busi\MessageTemplate;
use App\Models\Busi\WorkCalendarData;

class AttendancePolling extends Command
{
	//protected $name = 'attendance_polling';
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
	    $this->log('考勤日完成情况轮询通知开始..!');
        $today = date('Y-m-d');
        $day = WorkCalendarData::where('fday', $today)->first();
        if(!$day->fis_work_time) return; //非工作日

        $sql = <<<EOH
SELECT
	e.id,
	u.id as user_id
FROM
	bd_employees e
INNER JOIN sys_users u on e.id=u.reference_id and u.reference_type='employee'
WHERE
	NOT EXISTS (
		SELECT
			a.id
		FROM
			ms_attendances a
		WHERE
			e.id = a.femp_id
		AND DATE_FORMAT(a.ftime, '%Y-%m-%d') = '$today'
		AND a.ftype = 1
	)
EOH;
		$result = DB::select($sql);

		if(!empty($result)){
			$ids = array_map(function ($item){
				return $item->user_id . '';
			}, $result);
			$this->sendMsg($ids);
		}
	    $this->log('考勤日完成情况轮询通知结束!');
    }

    protected function sendMsg($ids){
	    $msg = [];
	    $messageTemp = MessageTemplate::where('type', 0)->first();
	    if(empty($messageTemp)){
		    $this->log('警告：没有找到【type=0】的消息模板！');
		    return;
	    }
	    //var_dump($messageTemp);
	    // type=1 , content=
	    $content = $messageTemp->content ;//str_replace('#name', 'test', $messageTemp->content);
	    $msg[] = '待发送推送消息的数量：'. count($ids);
	    $this->log(implode($msg));
	    if(env('APP_DEBUG')){
		    $this->log('AttendancePolling测试, 待发送推送消息的 ids：'. json_encode($ids));
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
		    $msg[] = '发送成功！';
	    } catch (\JPush\Exceptions\APIConnectionException $e) {
		    // try something here
		    //print $e;
		    $this->log('错误, APIConnectionException：'. $e);
		    $msg[] = '发送失败: ' . $e->getMessage();
	    } catch (\JPush\Exceptions\APIRequestException $e) {
		    // try something here
		    //print $e;
		    $this->log('错误, APIRequestException：'. $e);
		    $msg[] = '发送失败: ' . $e->getMessage();
	    }
	    SysCrontab::exec('attendance_polling', implode($msg));
    }

	public function log($msg, $method = 'info'){
		$this->info($msg);
		//$this->log($msg);
		LogSvr::AttendancPolling()->{$method}($msg);
	}
}

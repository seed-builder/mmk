<?php

namespace App\Console\Commands;

use App\Models\SysCrontab;
use Illuminate\Console\Command;
use App\Models\Busi\Attendance;
use App\Models\Busi\AttendanceReport;
use App\Models\Busi\Employee;
use App\Models\Busi\WorkCalendarData;
use App\Models\Busi\AttendanceStatistic;
use DB;
use App\Services\LogSvr;

class AttStatisticGen extends Command
{
	protected $name = 'att-stc';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gen:att-stc {--begin=} {--end=} {--emp=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'generate attendance statistic ; gen:att-stc {--begin=} {--end=} {--emp=}';

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
	    $begin = $this->option('begin');
	    $end = $this->option('end');
	    $empId = $this->option('emp');
	    if(empty($begin)){
	    	$begin = date("Y-m-d",strtotime("-1 day"));//date('Y-m-d');
	    }
	    if(empty($end)){
	    	$end = date('Y-m-d');
	    }

	    $this->log('AttStatisticGen begin');
	    //$workdays = DB::select("select fday from  eng_work_calendar_data where fday >='$begin' and fday <= '$end'and fis_work_time=1");
	    $workdays = WorkCalendarData::where('fday', '>=', $begin)->where('fday', '<=', $end)->where('fis_work_time', 1)->get();
	    if(count($workdays) > 0) {
	    	if(is_null($empId)) {
			    $employees = Employee::all();
		    } else {
			    $employee = Employee::find($empId);
			    $employees = [$employee];
		    }
			foreach ($workdays as $day){
				$this->log('begin day=' . $day->fday );
				$dayTime = strtotime($day->fday);
				foreach ($employees as $employee){
					if($dayTime >= strtotime($employee->fstart_date))
						$this->day($day->fday, $employee);
				}
				$this->log('end day=' . $day->fday);
			}
	    }
	    $this->log('AttStatisticGen end!');
	    SysCrontab::exec($this->name);
    }

    public function day($day, $employee)
    {
	    $entity = AttendanceStatistic::where('femp_id', $employee->id)
		    ->where('fday', $day)->first();
	    if(!empty($entity) && $entity->fstatus == 1){
	    	return;
	    }
	    $workTimeBegin = env('WORK_TIME_BEGIN');
	    $workTimeEnd = env('WORK_TIME_END');
	    $beginStatus = 0;
	    $completeStatus = 0;
	    $date = strtotime($day);
	    $props = [
		    'forg_id' => $employee->forg_id,
		    'femp_id' => $employee->id,
		    'fyear' => date('Y', $date),
		    'fmonth' => date('m', $date),
		    'fday' => $day,
		    'fbegin_status' => 0,
		    'fcomplete_status' => 0,
	    ];
	    //$day = str_replace(' 00:00:00','',$day);
	    $beginAtt = DB::select('select * from ms_attendances where ftype=0 AND DATE_FORMAT(ftime,	\'%Y-%m-%d\')=\'' . date('Y-m-d', $date) . '\' and femp_id=' . $employee->id . ' order by ftime asc limit 1 ');
	    $completeAtt = DB::select('select * from ms_attendances where ftype=1 AND DATE_FORMAT(ftime,	\'%Y-%m-%d\')=\'' . date('Y-m-d', $date) . '\' and femp_id=' . $employee->id . ' order by ftime desc limit 1 ');
	    if (!empty($beginAtt)) {
		    $begin = $beginAtt[0]->ftime;
		    $workBegin = str_replace('00:00:00', $workTimeBegin, $day);
		    if (strtotime($workBegin) > strtotime($begin)) {
			    $beginStatus = 1;
		    } else {
			    $beginStatus = 2;
		    }
		    $props['fbegin'] = $begin;
		    $props['fbegin_id'] = $beginAtt[0]->id;
		    $props['fbegin_status'] = $beginStatus;
	    }
	    if (!empty($completeAtt)) {
		    $complete = $completeAtt[0]->ftime;
		    $workEnd = str_replace('00:00:00', $workTimeEnd, $day);
		    if (strtotime($complete) >= strtotime($workEnd)) {
			    $completeStatus = 1;
		    } else {
			    $completeStatus = 2;
		    }
		    $props['fcomplete'] = $complete;
		    $props['fcomplete_id'] = $completeAtt[0]->id;
		    $props['fcomplete_status'] = $completeStatus;
	    }

	    if ($beginStatus == 0 || $completeStatus == 0) {
		    $props['fstatus'] = 0;
	    } elseif ($beginStatus == 1 && $completeStatus == 1) {
		    $props['fstatus'] = 1;
	    } elseif ($beginStatus == 2 || $completeStatus == 2) {
		    $props['fstatus'] = 2;
	    }

	    if (empty($entity)) {
		    $entity = new AttendanceStatistic($props);
	    } else {
		    $entity->fill($props);
	    }
	    $re = $entity->save();
	    $this->log('attendance statistic : ' . json_encode($entity));
    }

	public function log($msg){
		$this->info($msg);
		LogSvr::AttStatisticGen()->info($msg);
	}

}

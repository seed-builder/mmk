<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Busi\Attendance;
use App\Models\Busi\AttendanceReport;
use App\Models\Busi\Employee;
use App\Models\Busi\WorkCalendarData;
use DB;
use App\Services\LogSvr;

/**
 * 生成考勤报表数据
 * Class AttRepoortGen
 * @package App\Console\Commands
 */
class AttRepoortGen extends Command
{
    /**
     * attendance report generator!
     *
     * @var string
     */
    protected $signature = 'gen:att-rpt {--year=0} {--month=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'attendance report generator! cmd: gen:att-rpt {--year=0} {--month=0}';

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
	    $year = $this->option('year');
	    $month = $this->option('month');
	    if($year == 0){
			$year = date('Y');
	    }
	    if($month == 0){
	    	$month = date('m');
	    }
	    $this->log("year: $year, month: $month, generate attendance report begin...");
	    $this->init($year, $month);
	    $this->statistic($year, $month);
	    $this->log("year: $year, month: $month, generate attendance report end!");
    }

	/**
	 * 初始化生成月份数据
	 * @param $year
	 * @param $month
	 */
    public function init($year, $month){
    	$this->log('begin init..');
    	$date = $year.'-'. sprintf('%02d',$month);
		$employees = Employee::all();
		if(!empty($employees)){
			foreach ($employees as $employee){
				$startDate=$employee->fstart_date;
				$workdays = DB::select("select count(1) as c from  eng_work_calendar_data where DATE_FORMAT(fday,'%Y-%m')='$date' and fday >= '$startDate' and fis_work_time=1");
				//var_dump($workdays);
				if(!empty($workdays) && $workdays[0]->c > 0) {
					$count = AttendanceReport::where('fyear', $year)
						->where('fmonth', $month)
						->where('forg_id', $employee->forg_id)
						->where('femp_id', $employee->id)
						->count();
					if ($count == 0) {
						$rp = AttendanceReport::create([
								'fyear' => $year,
								'fmonth' => $month,
								'fwork_days' => $workdays[0]->c,
								'forg_id' => $employee->forg_id,
								'femp_id' => $employee->id
							]
						);
						if ($rp) {
							$this->log('craete data success , data=【' . json_encode($rp) . '】');
						}
					}
				}
			}
		}
	    $this->log('end init!');
    }

    public function statistic($year, $month){
    	$this->log('begin statistic ...');
	    $rps = AttendanceReport::where('fyear', $year)->where('fmonth', $month)->get();
	    $date = $year.'-'. sprintf('%02d',$month);
	    $today = date('Y-m-d');
		if(!empty($rps)){
			foreach ($rps as $rp){
				$empId = $rp->femp_id;
				$normalSql = "SELECT count(1) c FROM attendance_statistics WHERE DATE_FORMAT(fday,'%Y-%m')='$date' AND fday<='$today' AND  femp_id=$empId AND fstatus=1";
				$abnormalSql = "SELECT count(1) c FROM	 attendance_statistics WHERE DATE_FORMAT(fday,'%Y-%m')='$date' AND	fday<='$today' AND femp_id=$empId AND fstatus<>1";
				$normal = DB::select($normalSql);
				$abnormal = DB::select($abnormalSql);
				$rp->fnormal_days = $normal[0]->c;
				$rp->fabnormal_days = $abnormal[0]->c;
				$rp->save();
				$this->log('emp id: ' . $empId . ' normal days: ' . $normal[0]->c . ', abnormal days: ' . $abnormal[0]->c);
			}
		}
		$this->log('end statistic!');
    }

    public function log($msg){
    	$this->info($msg);
	    LogSvr::AttRepoortGen()->info($msg);
    }
}

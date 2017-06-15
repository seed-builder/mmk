<?php

use App\Models\Busi\Customer;
use App\Models\Busi\DisplayPolicyStore;
use App\Models\Busi\Employee;
use App\Models\City;
use App\Models\User;
use App\Repositories\EmployeeRepo;
use App\Services\CodeBuilder;
use App\Services\DataSync\KingdeeWorker;
use App\Services\DbHelper;
use App\Services\MessageService;
use App\Services\VisitCalendarService;
use App\Services\WorkFlowEngine;
use Illuminate\Foundation\Inspiring;
use App\Models\Busi\Store;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('test', function () {
	$this->comment('begin ...');
	MessageService::Instance()->systemSend(462, "测试", '测试');
	$this->comment('end ...');
})->describe('philo blade test');

Artisan::command('test1', function () {
	$this->comment('begin ...');
	$db = new DbHelper();
	$columns = $db->getColumns('fin_statements');
	$builder = new CodeBuilder('FinStatement','fin_statements', $columns);
	$builder->createFiles( 'customer');
	$this->comment('end ...');
})->describe('philo blade test');

Artisan::command('push-store', function () {
	$this->comment('begin ...');
	$dataSync = app('dataSync');
	$stores = Store::all();
	foreach ($stores as $store) {
		$dataSync->send('st_stores', 0, $store->toArray());
		$this->comment('complete send store: ' . $store->ffullname);
	}
	$this->comment('end ...');
})->describe('push store to cloud');

Artisan::command('push-sign-store', function () {
	$this->comment('begin ...');
	$dataSync = app('dataSync');
	$stores = \App\Models\Busi\DisplayPolicyStore::take(1)->get();
	foreach ($stores as $store) {
		$dataSync->send('exp_display_policy_store', 0, $store->toArray());
		$this->comment('complete send store: ' . $store->ffullname);
	}
	$this->comment('end ...');
})->describe('push store to cloud');

Artisan::command('create-position-flag', function () {
	$this->comment('begin ...');
	$tops = \App\Models\Busi\Position::where('fparpost_id', 0)->get();
	foreach ($tops as $position) {
		createPositionFlag($position, '');
		//$this->comment('gen flag: ' . $position->flag);
		//$this->comment('complete send store: ' . $store->ffullname);
	}
	$this->comment('end ...');
})->describe('create position flag');

function createPositionFlag($position, $pflag){
	$position->flag = $pflag . $position->id;
	$position->save();
	print($position->flag );
	print "\r\n";
	if($position->children){
		foreach ($position->children as $child) {
			createPositionFlag($child, $position->flag . '-');
		}
	}
}

Artisan::command('create-permission-flag', function () {
	$this->comment('begin ...');
	$tops = \App\Models\Permission::where('pid', 0)->get();
	foreach ($tops as $position) {
		createPositionFlag($position, '');
		//$this->comment('gen flag: ' . $position->flag);
		//$this->comment('complete send store: ' . $store->ffullname);
	}
	$this->comment('end ...');
})->describe('create permission flag');

Artisan::command('make-calendar', function () {
	$this->comment('make all stores todo calendar ...');
	$stores = Store::where('fline_id','>',0)->get();
	//var_dump($stores->toArray());
	$svr = new VisitCalendarService();
	foreach ($stores as $store) {
		$svr->byStore($store);
		$this->comment('complete store = ' . $store->ffullname);
	}
	$this->comment('end ...');
})->describe('make all stores todo calendars');

Artisan::command('make-store-number', function () {
	$this->comment('make all stores fnumber...');
	$stores = Store::all();
	$this->comment('count = ' . $stores->count());
	foreach ($stores as $store) {
		if(!empty($store->fnumber))
			continue;
		$this->comment('store fprovince【'.$store->fprovince.'】 fcity【'.$store->fcity.'】 fcountry【'.$store->fcountry.'】');
		if(!empty($store->fprovince) && !empty($store->fcity) && !empty($store->fcountry)) {
			$postalcode = City::getPostalCode($store->fprovince, $store->fcity, $store->fcountry);
			if (!$postalcode) {
				$postalcode = City::getPostalCode($store->fprovince, $store->fcity, '');
			}
			if ($postalcode) {
				$fn = Store::where('fpostalcode', $postalcode)->max('fnumber');
				if ($fn) {
					$fn++;
					$store->fnumber = $fn;
				} else {
					$store->fnumber = $postalcode . sprintf('%05d', 1);
				}
				$store->fpostalcode = $postalcode;
				$store->save();
				$this->comment('make store 【'.$store->ffullname.'】 fnumber【'.$store->fnumber.'】');
			}
		}
	}
	$this->comment('end ...');
})->describe('make all stores fnumber');

Artisan::command('cp-customer-to-user', function () {
	$this->comment('begin ...');
	$customers = Customer::whereNotNull('ftel')->where('ftel', '<>', '')->get();
	$this->comment('ready to copy '.count($customers).' customers to sys-users table');
	if(!empty($customers)){
		DB::beginTransaction();
		try {
			foreach ($customers as $customer) {
				if (empty($customer->user)) {
					$exists = User::where('name', $customer->ftel)->count();
					if($exists)
						continue;

					$customer->user()->create([
						'name' => $customer->ftel,
						'password' => md5('888888'),
						'status' => 1,
						'nick_name' => $customer->fname,

					]);
					$this->comment('success copy customer:  ' . $customer->fname);
				}else{
					$customer->user()->update([
						'name' => $customer->ftel,
						'password' => md5('888888'),
						'status' => 1,
						'nick_name' => $customer->fname,

					]);
					$this->comment('success copy customer:  ' . $customer->fname);
				}

			}
			DB::commit();
		} catch (Exception $e) {
			$this->comment(' copy customer err:  ' . $e->getMessage());
			DB::rollBack();
		}
	}
	$this->comment('end ...');
})->describe('copy customers to sys_users tables');

Artisan::command('cp-employee-to-user', function () {
	$this->comment('begin ...');
	$employees = Employee::whereNotNull('fphone')->get();
	$this->comment('ready to copy '.count($employees).' employees to sys-users table');
	$repo = new EmployeeRepo();
	if(!empty($employees)){
		DB::beginTransaction();
		try {
			foreach ($employees as $employee) {
				$repo->syncUser($employee);
				$this->comment('success copy employee:  ' . $employee->fname);
			}
			DB::commit();
		} catch (Exception $e) {
			$this->comment(' copy customer err:  ' . $e->getMessage());
			DB::rollBack();
		}
	}
	$this->comment('end ...');
})->describe('copy employees to sys_users tables');

Artisan::command('fill-user-nickname', function () {
	$this->comment('begin ...');
	$users = User::whereNotNull('reference_type')->get();
	$this->comment('ready to copy '.count($users).' users fill');
	if(!empty($users)){
		DB::beginTransaction();
		try {
			foreach ($users as $user) {
				if (!empty($user->reference)) {
					//$user->update(['nick_name' => $user->reference->fname]);
					$user->nick_name = $user->reference->fname;
					$user->save();
					$this->comment('success fill user:  ' . $user->reference->fname);
				}
			}
			DB::commit();
		} catch (Exception $e) {
			$this->comment(' fill user err:  ' . $e->getMessage());
			DB::rollBack();
		}
	}
	$this->comment('end ...');
})->describe('fill users nick name');

Artisan::command('push-attendance', function () {
	$this->comment('begin  send attendances...');
	$dataSync = app('dataSync');
	$stores = \App\Models\Busi\Attendance::where('ftime', '>', '2017-03-27')->where('ftime', '<', '2017-03-30')->get();
	foreach ($stores as $store) {
		$dataSync->send('ms_attendances', 0, $store->toArray());
		$this->comment('complete send attendance: ' . $store->ftime);
	}
	$this->comment('end ...');
})->describe('push attendance to cloud');

Artisan::command('cust-amount', function () {
	$this->comment('begin get cust amount');
	$worker = new KingdeeWorker();
	$res = $worker->post('http://shantu.ik3cloud.com/k3cloud/CYD.ApiService.ServicesStub.CustomBusinessService.CustBalAmountGet.common.kdsvc',
		['parameters' => [293095]]);
	var_dump($res);
	$this->comment('end get cust amount');
})->describe('get cust amount');


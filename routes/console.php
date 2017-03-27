<?php

use App\Models\Busi\DisplayPolicyStore;
use App\Models\City;
use App\Services\CodeBuilder;
use App\Services\DbHelper;
use App\Services\VisitCalendarService;
use Illuminate\Foundation\Inspiring;
use App\Models\Busi\Store;

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
	$affected = DB::update('update st_stores set fis_signed = ?', [0]);
	$this->comment('update $affected =' . $affected);
	$now = date('Y-m-d');
	//取得当前有效的签约
	$policies = DisplayPolicyStore::where('fstatus', 1)
		->where('fstart_date', '<=', $now)
		->where('fend_date', '>=', $now)
		->get();
	$this->comment('count = ' . $policies->count());
	if(!empty($policies)){
		foreach ($policies as $policy) {
			$store = $policy->store;
			$store->fis_signed = 1;
			$store->save();
		}
	}
	$this->comment('end ...');
})->describe('philo blade test');

Artisan::command('test1', function () {
	$this->comment('begin ...');
	$db = new DbHelper();
	$columns = $db->getColumns('view_store_outs');
	$builder = new CodeBuilder('ViewStoreOut', 'view_store_outs', $columns);
	$builder->createFiles('admin', 'customer');
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
		//$this->comment('complete send store: ' . $store->ffullname);
	}
	$this->comment('end ...');
})->describe('push store to cloud');

function createPositionFlag($position, $pflag){
	$position->flag = $pflag . $position->id;
	$position->save();
	echo $position->flag;
	if($position->children){
		foreach ($position->children as $child) {
			createPositionFlag($child, $position->flag . '-');

		}
	}
}

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
		$this->comment('store 【'.$store->ffullname.'】 fnumber【'.$store->fnumber.'】');
		if(!empty($store->fnumber))
			continue;

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
<?php

use App\Services\CodeBuilder;
use App\Services\DbHelper;
use Illuminate\Foundation\Inspiring;

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
	$db = new DbHelper();
	$columns = $db->getColumns('sys_permissions');
	$builder = new CodeBuilder('Permission', 'sys_permissions', $columns);
	$builder->createFiles();
	$this->comment('end ...');
})->describe('philo blade test');

Artisan::command('test1', function () {
	$this->comment('begin ...');
	$db = new DbHelper();
	$columns = $db->getColumns('bd_message_templates');
	$builder = new CodeBuilder('MessageTemplate', 'bd_message_templates', $columns);
	$builder->createFiles();
	$this->comment('end ...');
})->describe('philo blade test');
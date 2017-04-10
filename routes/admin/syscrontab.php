<?php
Route::get('sys-crontab/pagination', ['uses' => 'SysCrontabController@pagination']);
Route::resource('sys-crontab', 'SysCrontabController');
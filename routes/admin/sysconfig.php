<?php
Route::get('sys-config/pagination', ['uses' => 'SysConfigController@pagination']);
Route::resource('sys-config', 'SysConfigController');
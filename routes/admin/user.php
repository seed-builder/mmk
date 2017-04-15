<?php
Route::get('user/pagination', ['uses' => 'UserController@pagination']);
Route::get('user/reset-pwd', ['uses' => 'UserController@resetPwd']);
Route::match(['get', 'post'], 'user/{id}/set-role', ['uses' => 'UserController@setRole']);
Route::match(['get', 'post'], 'user/{id}/set-position', ['uses' => 'UserController@setPosition']);
Route::resource('user', 'UserController');
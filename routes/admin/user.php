<?php
Route::get('user/pagination', ['uses' => 'UserController@pagination']);
Route::get('user/reset-pwd', ['uses' => 'UserController@resetPwd']);
Route::match(['get', 'post'], 'user/{id}/set-role', ['uses' => 'UserController@setRole']);
Route::match(['get', 'post'], 'user/{id}/set-position', ['uses' => 'UserController@setPosition']);
Route::get('user/batch-user-role', ['uses' => 'UserController@batchUserRole']);
Route::post('user/batch-user-role', ['uses' => 'UserController@batchUserRole']);
Route::resource('user', 'UserController');
Route::post('user/reset-device/{id}', ['uses' => 'UserController@resetDevice']);
Route::post('user/reset-user-pwd/{id}', ['uses' => 'UserController@resetUserPwd']);
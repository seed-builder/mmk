<?php
Route::get('user/pagination', ['uses' => 'UserController@pagination']);
Route::match(['get', 'post'], 'user/{id}/set-role', ['uses' => 'UserController@setRole']);
Route::match(['get', 'post'], 'user/{id}/set-position', ['uses' => 'UserController@setPosition']);
Route::resource('user', 'UserController');
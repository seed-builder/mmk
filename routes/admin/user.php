<?php
Route::get('user/pagination', ['uses' => 'UserController@pagination']);
Route::match(['get', 'post'], 'user/{id}/set-role', ['uses' => 'UserController@setRole']);
Route::resource('user', 'UserController');
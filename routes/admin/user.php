<?php
Route::get('user/pagination', ['uses' => 'UserController@pagination']);
Route::resource('user', 'UserController');
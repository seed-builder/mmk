<?php
Route::get('customer/pagination', ['uses' => 'CustomerController@pagination']);
Route::get('customer/check', ['uses' => 'CustomerController@check']);
Route::get('customer/uncheck', ['uses' => 'CustomerController@uncheck']);
Route::resource('customer', 'CustomerController');
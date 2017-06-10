<?php
Route::get('customer/pagination', ['uses' => 'CustomerController@pagination']);
Route::get('customer/check', ['uses' => 'CustomerController@check']);
Route::get('customer/uncheck', ['uses' => 'CustomerController@uncheck']);
Route::match(['get', 'post'], 'customer/{id}/open', ['uses' => 'CustomerController@open']);
Route::match(['get', 'post'], 'customer/{id}/unique', ['uses' => 'CustomerController@unique']);
Route::get('customer/reset-location/{id}', ['uses' => 'CustomerController@resetLocation']);

Route::resource('customer', 'CustomerController');
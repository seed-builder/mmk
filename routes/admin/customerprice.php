<?php
Route::get('customer-price/pagination', ['uses' => 'CustomerPriceController@pagination']);
Route::get('customer-price/check', ['uses' => 'CustomerPriceController@check']);
Route::get('customer-price/uncheck', ['uses' => 'CustomerPriceController@uncheck']);
Route::resource('customer-price', 'CustomerPriceController');
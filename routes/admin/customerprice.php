<?php
Route::get('customer-price/pagination', ['uses' => 'CustomerPriceController@pagination']);
Route::resource('customer-price', 'CustomerPriceController');
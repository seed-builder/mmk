<?php
Route::get('customer/pagination', ['uses' => 'CustomerController@pagination']);
Route::resource('customer', 'CustomerController');
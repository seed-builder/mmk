<?php
Route::get('customer-order/pagination', ['uses' => 'CustomerOrderController@pagination']);
Route::resource('customer-order', 'CustomerOrderController');
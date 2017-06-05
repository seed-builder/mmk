<?php
Route::get('customer-order-item/pagination', ['uses' => 'CustomerOrderItemController@pagination']);
Route::resource('customer-order-item', 'CustomerOrderItemController');
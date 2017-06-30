<?php
Route::get('sale-order/pagination', ['uses' => 'SaleOrderController@pagination']);
Route::post('sale-order/accept/{id}', ['uses' => 'SaleOrderController@accept']);
Route::post('sale-order/send', ['uses' => 'SaleOrderController@send']);
Route::resource('sale-order', 'SaleOrderController');
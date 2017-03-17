<?php
Route::get('sale-order-item/pagination', ['uses' => 'SaleOrderItemController@pagination']);
Route::post('sale-order-item/make-sure/{id}', ['uses' => 'SaleOrderItemController@makeSure']);
Route::post('sale-order-item/send', ['uses' => 'SaleOrderItemController@send']);
Route::resource('sale-order-item', 'SaleOrderItemController');
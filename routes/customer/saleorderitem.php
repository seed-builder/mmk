<?php
Route::get('sale-order-item/pagination', ['uses' => 'SaleOrderItemController@pagination']);
Route::post('sale-order-item/make-sure/{id}', ['uses' => 'SaleOrderItemController@makeSure']);
Route::resource('sale-order-item', 'SaleOrderItemController');
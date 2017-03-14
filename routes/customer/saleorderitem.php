<?php
Route::get('sale-order-item/pagination', ['uses' => 'SaleOrderItemController@pagination']);
Route::resource('sale-order-item', 'SaleOrderItemController');
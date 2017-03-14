<?php
Route::get('sale-order/pagination', ['uses' => 'SaleOrderController@pagination']);
Route::resource('sale-order', 'SaleOrderController');
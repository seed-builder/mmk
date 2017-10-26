<?php
Route::get('view-sale-order-item/pagination', ['uses' => 'ViewSaleOrderItemController@pagination']);
Route::resource('view-sale-order-item', 'ViewSaleOrderItemController');
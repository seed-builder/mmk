<?php
Route::get('stock-out-item/pagination', ['uses' => 'StockOutItemController@pagination']);
Route::resource('stock-out-item', 'StockOutItemController');
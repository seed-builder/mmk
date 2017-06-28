<?php
Route::get('stock-check-item/pagination', ['uses' => 'StockCheckItemController@pagination']);
Route::resource('stock-check-item', 'StockCheckItemController');
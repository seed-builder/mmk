<?php
Route::get('stock-check-item/pagination', ['uses' => 'StockCheckItemController@pagination']);
Route::get('stock-check-item/month-pagination', ['uses' => 'StockCheckItemController@month_pagination']);
Route::resource('stock-check-item', 'StockCheckItemController');
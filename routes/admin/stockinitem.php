<?php
Route::get('stock-in-item/pagination', ['uses' => 'StockInItemController@pagination']);
Route::resource('stock-in-item', 'StockInItemController');
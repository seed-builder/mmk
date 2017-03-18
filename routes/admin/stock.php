<?php
Route::get('stock/pagination', ['uses' => 'StockController@pagination']);
Route::get('stock/check', ['uses' => 'StockController@check']);
Route::get('stock/uncheck', ['uses' => 'StockController@uncheck']);
Route::resource('stock', 'StockController');
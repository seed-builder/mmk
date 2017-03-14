<?php
Route::get('stock-in/pagination', ['uses' => 'StockInController@pagination']);
Route::get('stock-in/check', ['uses' => 'StockInController@check']);
Route::get('stock-in/uncheck', ['uses' => 'StockInController@uncheck']);
Route::resource('stock-in', 'StockInController');
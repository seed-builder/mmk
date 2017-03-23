<?php
Route::get('stock-out/pagination', ['uses' => 'StockOutController@pagination']);
Route::get('stock-out/check', ['uses' => 'StockOutController@check']);
Route::get('stock-out/uncheck', ['uses' => 'StockOutController@uncheck']);
Route::resource('stock-out', 'StockOutController');
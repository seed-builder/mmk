<?php
Route::get('stock-out/pagination', ['uses' => 'StockOutController@pagination']);
Route::get('stock-out/check', ['uses' => 'StockOutController@check']);
Route::get('stock-out/uncheck', ['uses' => 'StockOutController@uncheck']);
Route::get('stock-out/print-out-order/{id}', ['uses' => 'StockOutController@printOutOrder']);
Route::resource('stock-out', 'StockOutController');
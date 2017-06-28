<?php
Route::get('stock-check/pagination', ['uses' => 'StockCheckController@pagination']);
Route::get('stock-check/show/{id}', ['uses' => 'StockCheckController@show']);
Route::resource('stock-check', 'StockCheckController');
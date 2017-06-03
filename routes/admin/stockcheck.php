<?php
Route::get('stock-check/pagination', ['uses' => 'StockCheckController@pagination']);
Route::resource('stock-check', 'StockCheckController');
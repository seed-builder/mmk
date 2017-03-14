<?php
Route::get('stock/pagination', ['uses' => 'StockController@pagination']);
Route::resource('stock', 'StockController');
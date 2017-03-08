<?php
Route::get('stock-out/pagination', ['uses' => 'StockOutController@pagination']);
Route::resource('stock-out', 'StockOutController');
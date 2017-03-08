<?php
Route::get('stock-in/pagination', ['uses' => 'StockInController@pagination']);
Route::resource('stock-in', 'StockInController');
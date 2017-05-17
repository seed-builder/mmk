<?php
Route::get('price/pagination', ['uses' => 'PriceController@pagination']);
Route::get('price/check', ['uses' => 'PriceController@check']);
Route::get('price/uncheck', ['uses' => 'PriceController@uncheck']);
Route::resource('price', 'PriceController');
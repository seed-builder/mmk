<?php
Route::get('price/pagination', ['uses' => 'PriceController@pagination']);
Route::resource('price', 'PriceController');
<?php

Route::get('store/pagination', ['uses' => 'StoreController@pagination']);
Route::get('store/index', ['uses' => 'StoreController@index']);
Route::get('store/query', ['uses' => 'StoreController@diyquery']);
Route::resource('store', 'StoreController');
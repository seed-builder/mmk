<?php

Route::get('store/pagination', ['uses' => 'StoreController@pagination']);
Route::get('store/index', ['uses' => 'StoreController@index']);
Route::resource('store', 'StoreController');
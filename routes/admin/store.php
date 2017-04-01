<?php

Route::get('store/pagination', ['uses' => 'StoreController@pagination']);
Route::get('store/index', ['uses' => 'StoreController@index']);
Route::get('store/query', ['uses' => 'StoreController@diyquery']);
Route::get('store/getStore/{id}', ['uses' => 'StoreController@getStore']);
Route::post('store/createStore', ['uses' => 'StoreController@createStore']);
Route::post('store/editStore', ['uses' => 'StoreController@editStore']);
Route::get('store/storeInfo/{id}', ['uses' => 'StoreController@storeInfo']);
Route::post('store/exchange', ['uses' => 'StoreController@exchange']);
Route::get('store/check', ['uses' => 'StoreController@check']);
Route::get('store/uncheck', ['uses' => 'StoreController@uncheck']);
Route::resource('store', 'StoreController');
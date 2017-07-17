<?php

Route::get('store/pagination', ['uses' => 'StoreController@pagination']);
Route::get('store/index', ['uses' => 'StoreController@index']);
Route::get('store/query', ['uses' => 'StoreController@diyquery']);
Route::get('store/getStore/{id}', ['uses' => 'StoreController@getStore']);
Route::post('store/createStore', ['uses' => 'StoreController@createStore']);
Route::post('store/editStore', ['uses' => 'StoreController@editStore']);
Route::post('store/forbidden/{id}', ['uses' => 'StoreController@forbidden']);
Route::post('store/start_use/{id}', ['uses' => 'StoreController@start_use']);
Route::get('store/storeInfo/{id}', ['uses' => 'StoreController@storeInfo']);
Route::post('store/exchange', ['uses' => 'StoreController@exchange']);
Route::get('store/check', ['uses' => 'StoreController@check']);
Route::get('store/uncheck', ['uses' => 'StoreController@uncheck']);
Route::get('store/store-exchange', ['uses' => 'StoreController@storeChangeIndex']);
Route::post('store/store-exchange', ['uses' => 'StoreController@storeChange']);
Route::post('store/export-excel', ['uses' => 'StoreController@exportExcel']);
Route::post('store/batch-remove', ['uses' => 'StoreController@batch_remove']);
Route::resource('store', 'StoreController');
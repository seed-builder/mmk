<?php

Route::get('/', ['uses' => 'IndexController@index']);
Route::get('/show-image', ['uses' => 'IndexController@showImage']);
Route::any('/customer-dd-return', ['uses' => 'IndexController@getCustomerDDReturn']);
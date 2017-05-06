<?php

Route::get('/', ['uses' => 'IndexController@index']);
Route::get('/show-image', ['uses' => 'IndexController@showImage']);
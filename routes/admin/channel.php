<?php
Route::get('channel/pagination', ['uses' => 'ChannelController@pagination']);
Route::get('channel/index', ['uses' => 'ChannelController@index']);
Route::get('channel/check/{id}', ['uses' => 'ChannelController@check']);
Route::get('channel/uncheck/{id}', ['uses' => 'ChannelController@unCheck']);
Route::resource('channel', 'ChannelController');
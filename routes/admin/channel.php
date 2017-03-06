<?php
Route::get('channel/pagination', ['uses' => 'ChannelController@pagination']);
Route::get('channel/index', ['uses' => 'ChannelController@index']);
Route::get('channel/check', ['uses' => 'ChannelController@check']);
Route::get('channel/uncheck', ['uses' => 'ChannelController@unCheck']);
Route::resource('channel', 'ChannelController');
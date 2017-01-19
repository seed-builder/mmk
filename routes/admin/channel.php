<?php
Route::get('channel/pagination', ['uses' => 'ChannelController@pagination']);
Route::get('channel/index', ['uses' => 'ChannelController@index']);
Route::resource('channel', 'ChannelController');
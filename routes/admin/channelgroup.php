<?php
Route::get('channel-group/pagination', ['uses' => 'ChannelGroupController@pagination']);
Route::any('channel-group/channelGroupTree', ['uses' => 'ChannelGroupController@channelGroupTree']);
Route::get('channel-group/check', ['uses' => 'ChannelGroupController@check']);
Route::get('channel-group/uncheck', ['uses' => 'ChannelGroupController@unCheck']);
Route::resource('channel-group', 'ChannelGroupController');
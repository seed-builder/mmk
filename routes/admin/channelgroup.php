<?php
Route::get('channel-group/pagination', ['uses' => 'ChannelGroupController@pagination']);
Route::any('channel-group/channelGroupTree', ['uses' => 'ChannelGroupController@ajaxGetChannelGroups']);
Route::get('channel-group/check/{id}', ['uses' => 'ChannelGroupController@check']);
Route::get('channel-group/uncheck/{id}', ['uses' => 'ChannelGroupController@unCheck']);
Route::resource('channel-group', 'ChannelGroupController');
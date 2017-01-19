<?php
Route::get('channel-group/pagination', ['uses' => 'ChannelGroupController@pagination']);
Route::any('channel-group/channelGroupTree', ['uses' => 'ChannelGroupController@ajaxGetChannelGroups']);
Route::resource('channel-group', 'ChannelGroupController');
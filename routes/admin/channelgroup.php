<?php
Route::get('channel-group/pagination', ['uses' => 'ChannelGroupController@pagination']);
Route::resource('channel-group', 'ChannelGroupController');
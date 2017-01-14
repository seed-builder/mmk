<?php
Route::get('channel/pagination', ['uses' => 'ChannelController@pagination']);
Route::resource('channel', 'ChannelController');
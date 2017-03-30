<?php
Route::get('message-content/pagination', ['uses' => 'MessageContentController@pagination']);
Route::resource('message-content', 'MessageContentController');
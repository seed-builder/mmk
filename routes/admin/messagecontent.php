<?php
Route::get('message-content/pagination', ['uses' => 'MessageContentController@pagination']);
Route::get('message-content/create', ['uses' => 'MessageContentController@create']);
Route::get('message-content/edit/{id}', ['uses' => 'MessageContentController@edit']);
Route::post('message-content/update/{id}', ['uses' => 'MessageContentController@update']);
Route::post('message-content/send', ['uses' => 'MessageContentController@send']);
Route::get('message-content/info/{message_id}', ['uses' => 'MessageContentController@info']);
Route::resource('message-content', 'MessageContentController');
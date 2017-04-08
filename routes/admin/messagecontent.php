<?php
Route::get('message-content/pagination', ['uses' => 'MessageContentController@pagination']);
Route::get('message-content/create', ['uses' => 'MessageContentController@create']);
Route::get('message-content/edit/{id}', ['uses' => 'MessageContentController@edit']);
Route::post('message-content/update/{id}', ['uses' => 'MessageContentController@update']);
Route::post('message-content/send', ['uses' => 'MessageContentController@send']);
Route::resource('message-content', 'MessageContentController');
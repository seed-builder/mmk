<?php
Route::get('message/pagination', ['uses' => 'MessageController@pagination']);
Route::get('message/receivePagination', ['uses' => 'MessageController@receivePagination']);
Route::get('message/receiveMessages', ['uses' => 'MessageController@receiveMessages']);
Route::get('message/unread', ['uses' => 'MessageController@unreadMessagesData']);
Route::resource('message', 'MessageController');
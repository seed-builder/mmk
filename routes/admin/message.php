<?php
Route::get('message/pagination', ['uses' => 'MessageController@pagination']);
Route::resource('message', 'MessageController');
<?php
Route::get('position/pagination', ['uses' => 'PositionController@pagination']);
Route::post('position/createPos', ['uses' => 'PositionController@createPos']);
Route::post('position/updatePos/{id}', ['uses' => 'PositionController@updatePos']);
Route::resource('position', 'PositionController');
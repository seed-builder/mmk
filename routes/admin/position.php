<?php
Route::get('position/pagination', ['uses' => 'PositionController@pagination']);
Route::resource('position', 'PositionController');
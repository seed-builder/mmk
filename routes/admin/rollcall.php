<?php
Route::get('rollcall/pagination', ['uses' => 'RollcallController@pagination']);
Route::resource('rollcall', 'RollcallController');
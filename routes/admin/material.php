<?php
Route::get('material/pagination', ['uses' => 'MaterialController@pagination']);
Route::get('material/check', ['uses' => 'MaterialController@check']);
Route::get('material/uncheck', ['uses' => 'MaterialController@unCheck']);
Route::resource('material', 'MaterialController');
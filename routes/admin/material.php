<?php
Route::get('material/pagination', ['uses' => 'MaterialController@pagination']);
Route::get('material/check/{id}', ['uses' => 'MaterialController@check']);
Route::get('material/uncheck/{id}', ['uses' => 'MaterialController@unCheck']);
Route::resource('material', 'MaterialController');
<?php
Route::get('material/pagination', ['uses' => 'MaterialController@pagination']);
Route::resource('material', 'MaterialController');
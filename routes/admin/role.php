<?php
Route::get('role/pagination', ['uses' => 'RoleController@pagination']);
Route::resource('role', 'RoleController');
<?php
Route::get('role/pagination', ['uses' => 'RoleController@pagination']);
Route::match(['get', 'post'],'role/{id}/set-permission', ['uses' => 'RoleController@pagination']);
Route::match(['get', 'post'], 'role/{id}/set-user', ['uses' => 'RoleController@pagination']);
Route::resource('role', 'RoleController');
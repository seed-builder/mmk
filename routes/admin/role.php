<?php
Route::get('role/pagination', ['uses' => 'RoleController@pagination']);
Route::match(['get', 'post'],'role/{id}/set-permission', ['uses' => 'RoleController@setPermission']);
Route::resource('role', 'RoleController');
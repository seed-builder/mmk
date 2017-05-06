<?php
Route::get('permission/pagination', ['uses' => 'PermissionController@pagination']);
Route::get('permission/tree', ['uses' => 'PermissionController@tree']);
Route::resource('permission', 'PermissionController');
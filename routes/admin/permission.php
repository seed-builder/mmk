<?php
Route::get('permission/pagination', ['uses' => 'PermissionController@pagination']);
Route::resource('permission', 'PermissionController');
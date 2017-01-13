<?php

Route::get('department/pagination', ['uses' => 'DepartmentController@pagination']);
Route::get('department/index', ['uses' => 'DepartmentController@index']);
Route::resource('department', 'DepartmentController');
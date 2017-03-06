<?php

Route::get('department/pagination', ['uses' => 'DepartmentController@pagination']);
Route::get('department/index', ['uses' => 'DepartmentController@index']);
Route::get('department/ajaxGetDepart', ['uses' => 'DepartmentController@ajaxGetDepart']);
Route::any('department/departmentTree', ['uses' => 'DepartmentController@departmentTree']);
Route::get('department/check', ['uses' => 'DepartmentController@check']);
Route::get('department/uncheck', ['uses' => 'DepartmentController@unCheck']);
Route::resource('department', 'DepartmentController');
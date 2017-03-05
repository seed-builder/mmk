<?php

Route::get('department/pagination', ['uses' => 'DepartmentController@pagination']);
Route::get('department/index', ['uses' => 'DepartmentController@index']);
Route::get('department/ajaxGetDepart', ['uses' => 'DepartmentController@ajaxGetDepart']);
Route::any('department/departmentTree', ['uses' => 'DepartmentController@departmentTree']);
Route::get('department/check/{id}', ['uses' => 'DepartmentController@check']);
Route::get('department/uncheck/{id}', ['uses' => 'DepartmentController@unCheck']);
Route::resource('department', 'DepartmentController');
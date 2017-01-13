<?php

Route::get('department/pagination', ['uses' => 'DepartmentController@pagination']);
Route::get('department/index', ['uses' => 'DepartmentController@index']);
Route::get('department/ajaxGetDepart', ['uses' => 'DepartmentController@ajaxGetDepart']);
Route::resource('department', 'DepartmentController');
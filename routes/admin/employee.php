<?php

Route::get('employee/pagination', ['uses' => 'EmployeeController@pagination']);
Route::get('employee/index', ['uses' => 'EmployeeController@index']);
Route::any('employee/employeeTree', ['uses' => 'EmployeeController@ajaxEmployeeTree']);
Route::resource('employee', 'EmployeeController');
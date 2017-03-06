<?php

Route::get('employee/pagination', ['uses' => 'EmployeeController@pagination']);
Route::get('employee/index', ['uses' => 'EmployeeController@index']);
Route::any('employee/employeeTree', ['uses' => 'EmployeeController@employeeTree']);
Route::any('employee/employees', ['uses' => 'EmployeeController@ajaxGetEmployees']);
Route::get('employee/check', ['uses' => 'EmployeeController@check']);
Route::get('employee/uncheck', ['uses' => 'EmployeeController@unCheck']);
Route::resource('employee', 'EmployeeController');
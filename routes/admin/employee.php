<?php

Route::get('employee/pagination', ['uses' => 'EmployeeController@pagination']);
Route::get('employee/index', ['uses' => 'EmployeeController@index']);
Route::any('employee/employeeTree', ['uses' => 'EmployeeController@employeeTree']);
Route::any('employee/employees', ['uses' => 'EmployeeController@ajaxGetEmployees']);
Route::get('employee/check/{id}', ['uses' => 'EmployeeController@check']);
Route::get('employee/uncheck/{id}', ['uses' => 'EmployeeController@unCheck']);
Route::resource('employee', 'EmployeeController');
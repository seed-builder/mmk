<?php

Route::get('employee/pagination', ['uses' => 'EmployeeController@pagination']);
Route::get('employee/index', ['uses' => 'EmployeeController@index']);
Route::resource('employee', 'EmployeeController');
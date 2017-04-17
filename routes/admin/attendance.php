<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017-01-11
 * Time: 13:35
 */

Route::get('attendance/pagination', ['uses' => 'AttendanceStatisticController@pagination']);
Route::get('attendance/index', ['uses' => 'AttendanceStatisticController@index']);
Route::get('attendance/attendanceInfo/{id}', ['uses' => 'AttendanceStatisticController@attendanceInfo']);
Route::post('attendance/export-excel', ['uses' => 'AttendanceStatisticController@exportExcel']);
Route::resource('attendance', 'AttendanceStatisticController');


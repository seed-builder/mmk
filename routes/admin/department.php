<?php

Route::get('department/pagination', ['uses' => 'DepartmentController@pagination']);
Route::get('department/index', ['uses' => 'DepartmentController@index']);
Route::get('department/ajaxGetDepart', ['uses' => 'DepartmentController@ajaxGetDepart']);
Route::any('department/departmentTree', ['uses' => 'DepartmentController@departmentTree']);
Route::get('department/test/{id}', function ($id){
    $dept = \App\Models\Busi\Department::find($id);
    dd($dept->getAllEmployeeByDept());
});
Route::resource('department', 'DepartmentController');
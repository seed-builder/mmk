<?php
Route::get('visit-todo-temp/pagination', ['uses' => 'VisitTodoTempController@pagination']);
Route::get('visit-todo-temp/temp-tree', ['uses' => 'VisitTodoTempController@tempTree']);
Route::post('visit-todo-temp/save', ['uses' => 'VisitTodoTempController@save']);
Route::get('visit-todo-temp/delete/{id}', ['uses' => 'VisitTodoTempController@delete']);
Route::resource('visit-todo-temp', 'VisitTodoTempController');
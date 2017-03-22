<?php
Route::get('visit-store-todo/pagination', ['uses' => 'VisitStoreTodoController@pagination']);
Route::get('visit-store-todo/todoTree', ['uses' => 'VisitStoreTodoController@todoTree']);
Route::post('visit-store-todo/save', ['uses' => 'VisitStoreTodoController@save']);
Route::get('visit-store-todo/todos/{id}', ['uses' => 'VisitStoreTodoController@storeTodoList']);
Route::get('visit-store-todo/todos-template', ['uses' => 'VisitStoreTodoController@todosTemplate']);
Route::get('visit-store-todo/delete/{id}', ['uses' => 'VisitStoreTodoController@delete']);
Route::get('visit-store-todo/index', ['uses' => 'VisitStoreTodoController@showIndex']);
Route::post('visit-store-todo/batch-make-todos', ['uses' => 'VisitStoreTodoController@batchMakeTodos']);
Route::resource('visit-store-todo', 'VisitStoreTodoController');